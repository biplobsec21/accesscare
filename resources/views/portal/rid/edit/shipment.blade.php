@extends('layouts.portal')

@section('title')
	Edit Shipment
@endsection

@section('styles')
	<style>
		h1 .badge, h2 .badge, h3 .badge, h4 .badge {
			font-size: 14px;
			line-height: 18px;
		}
		.group-member-template,
		.group-member-templatetable {
			display: none;
		}
		#memberSection,#addMemberBtn{
			display: none;
		}

		@media screen and (min-width: 1200px) {
			:root {
				--leftCol: 230px;
				--rightCol: 675px;
			}

			.actionBar {
				max-width: calc(var(--leftCol) + var(--rightCol));
			}

			.viewData .row.thisone > [class*=col]:first-child,
			.bg-dark > .row > [class*=col]:first-child {
				min-width: var(--leftCol);
				max-width: var(--leftCol);
			}

			.viewData .row.thisone > [class*=col]:last-child {
				min-width: var(--rightCol);
				max-width: var(--rightCol);
			}
		}

		@media screen and (min-width: 1300px) {
			:root {
				--rightCol: 790px;
			}
		}

		@media screen and (min-width: 1400px) {
			:root {
				--leftCol: 220px;
				--rightCol: 900px;
			}
		}
	</style>
@endsection

@php
	$bColor = $rid->status->badge;
@endphp

@section('content')
	<div class="titleBar">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="{{ route('eac.portal.getDashboard') }}">Dashboard</a>
				</li>
				<li class="breadcrumb-item">
					<a href="{{ route('eac.portal.rid.list') }}">All RIDs</a>
				</li>
				<li class="breadcrumb-item">
					<a href="{{ route("eac.portal.rid.show", $rid->id) }}">View RID</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">
					@yield('title')
				</li>
			</ol>
		</nav>
	</div><!-- end .titleBar -->
	@if(Session::has('alerts'))
		{!! view('layouts.alert-dismiss', ['type' => Session::get('alerts')['type'], 'message' => Session::get('alerts')['msg']]) !!}
	@endif
	<div class="viewData" style="max-width: calc(var(--leftCol) + var(--rightCol))">
		<div class="bg-dark text-white pt-2 pb-2 pr-3 pl-3">
			<div class="row justify-content-between">
				<div class="col-sm-3 col-xl-auto">
					<a class="btn btn-secondary btn-sm" href="{{ route("eac.portal.rid.show", $rid->id) }}">
						View RID
					</a>
				</div>
				<div class="col pl-sm-0">
					<div class="d-flex justify-content-between">
						<div class="">
							<span class="text-upper">Editing Shipment</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row thisone m-0 mb-xl-5">
			<div class="col-sm-3 col-xl-auto p-0 mb-2 mb-sm-0">
				<div class="wizardSteps symbols nav flex-row flex-sm-column mt-sm-3" id="tab" role="tablist"
				     aria-orientation="vertical">
					<a class="nav-link @if(!$shipment->regimensNeeded()->count()) complete @endif"
					   id="xdetailsT" data-toggle="pill" href="#xdetails" role="tab" aria-controls="xdetails"
					   aria-selected="false">
						<span>Regimen &amp; Frequency</span>
					</a>
					<a class="nav-link @if($shipment->pharmacy && $shipment->pharmacist) complete @endif" id="xpharmacyT"
					   data-toggle="pill" href="#xpharmacy" role="tab" aria-controls="xpharmacy" aria-selected="false">
						<span>Pharmacy Details</span>
					</a>
					<a class="nav-link @if($shipment->shipped_on_date) complete @endif" id="xshippingT"
					   data-toggle="pill" href="#xshipping" role="tab" aria-controls="xshipping" aria-selected="false">
						<span>Shipping Details</span>
					</a>
				</div>
			</div>
			<div class="col-sm-9 col-xl p-0">
				<div class="card tab-content wizardContent" id="tabContent">
					<div class="tab-pane fade" id="xdetails" role="tabpanel" aria-labelledby="xdetails-tab">
						<div class="card-body">
							@access('rid.regimen.update')
							@include('portal.rid.edit.regimen')
							@endaccess
						</div>
					</div><!-- /.tab-pane -->
					<div class="tab-pane fade" id="xpharmacy" role="tabpanel" aria-labelledby="xpharmacy-tab">
						<div class="card-body">
							@access('rid.pharmacy.view')
							@include('portal.rid.edit.pharmacy')
							@endaccess
						</div>
						<div class="card-footer d-flex justify-content-between">
							@if($shipment->pharmacy_id)
								@access('rid.pharmacy.update')
								<a href="#" class="btn btn-info" data-toggle="modal"
								   data-target="#PharmacyModal{{ $shipment->id }}">
									Edit Pharmacy
								</a>
								@include('include.portal.modals.rid.pharmacy.edit')
								@endaccess
							@else
								@access('rid.pharmacy.create')
								<a href="#" class="btn btn-success" data-toggle="modal"
								   data-target="#newPharmacyModal{{ $shipment->id }}">
									Add Pharmacy
								</a>
								@include('include.portal.modals.rid.pharmacy.new')
								@endaccess
							@endif
						</div>
					</div><!-- /.tab-pane -->
					<div class="tab-pane fade" id="xshipping" role="tabpanel" aria-labelledby="xshipping-tab">
						<div class="card-body">
							@access('rid.shipment.update')
							<div class="row">
								@if($shipment)
									<div class="col-md">
										<h5 class="mb-3">Shipping Dates</h5>
										<div class="row">
											<div class="col-lg mb-3">
												<label class="d-block">Ship By</label>
												@if($shipment->ship_by_date)
													{{ \Carbon\Carbon::parse($shipment->ship_by_date)->format(config('eac.date_format'))}}
												@else
													<small class="text-muted">N/A</small>
												@endif
											</div>
											<div class="col-lg mb-3">
												<label class="d-block">Expected Delivery</label>
												@if($shipment->deliver_by_date)
													{{ \Carbon\Carbon::parse($shipment->deliver_by_date)->format(config('eac.date_format'))}}
												@else
													<small class="text-muted">N/A</small>
												@endif
											</div>
										</div>

										<div class="row">
											<div class="col-lg mb-3">
												<label class="d-block">Shipped On</label>
												@if($shipment->shipped_on_date)
													{{ \Carbon\Carbon::parse($shipment->shipped_on_date)->format(config('eac.date_format'))}}
												@else
													<small class="text-muted">N/A</small>
												@endif
											</div>
											<div class="col-lg mb-3">
												<label class="d-block">Delivered On</label>
												@if($shipment->delivery_date)
													{{ \Carbon\Carbon::parse($shipment->delivery_date)->format(config('eac.date_format'))}}
												@else
													<small class="text-muted">N/A</small>
												@endif
											</div>
										</div>
									</div>
									<div class="col-md">
										<h5 class="mb-3">Shipping Courier</h5>
										<div class="row">
											<div class="col-lg mb-3">
												<label class="d-block">Shipping Via</label>
												@if($shipment->courier)
													{{ $shipment->courier->name }}
												@else
													<small class="text-muted">N/A</small>
												@endif
											</div>
											<div class="col-lg mb-3">
												<label class="d-block">Tracking Number</label>
												@if($shipment->tracking_number)
													<span class="d-block">{{ $shipment->tracking_number }}</span>
												@else
													<small class="text-muted">N/A</small>
												@endif
											</div>
										</div>
									</div>
								@endif
							</div><!-- /.row -->

							@endaccess
						</div>
						<div class="card-footer d-flex justify-content-between">
							@if(!$shipment->ship_by_date && !$shipment->deliver_by_date && !$shipment->shipped_on_date && !$shipment->delivery_date)
								@access('rid.shipment.create')
								<a href="#" class="btn btn-success" data-toggle="modal"
								   data-target="#ShipmentDateModal{{ $shipment->id }}">
									Add Dates
								</a>
								@include('include.portal.modals.rid.shipment.date')
								@endaccess
							@else
								@access('rid.shipment.update')
								<a href="#" class="btn btn-info" data-toggle="modal"
								   data-target="#ShipmentDateModal{{ $shipment->id }}">
									Edit Dates
								</a>
								@include('include.portal.modals.rid.shipment.date')
								@endaccess
							@endif
							@if(!$shipment->courier && !$shipment->tracking_number)
								@access('rid.shipment.create')
								<a href="#" class="btn btn-success" data-toggle="modal"
								   data-target="#ShipmentInfoModal{{ $shipment->id }}">
									Add Courier
								</a>
								@include('include.portal.modals.rid.shipment.info')
								@endaccess
							@else
								@access('rid.shipment.update')
								<a href="#" class="btn btn-info" data-toggle="modal"
								   data-target="#ShipmentInfoModal{{ $shipment->id }}">
									Edit Courier
								</a>
								@include('include.portal.modals.rid.shipment.info')
								@endaccess
							@endif
						</div>
					</div><!-- /.tab-pane -->
				</div>
			</div>
		</div><!-- /.row -->
	</div><!-- /.viewData -->
@endsection

@section('scripts')
	<script>
        $(function () {
            $("a.next").click(function () {
                let currentLink = $('.nav-link.active');
                setWizardStep(currentLink.index() + 1);
            });

            $("a.prev").click(function () {
                let currentLink = $('.nav-link.active');
                setWizardStep(currentLink.index() - 1);
            });

            let jumped = false;

            $(".tab-pane").each(function () {
                let errorCount = $(this).find('.is-invalid').length;
                if (errorCount > 0) {
                    let link = $('a[aria-controls=' + $(this).attr('id') + ']');
                    link.addClass('invalid');
                    if (!jumped) {
                        setWizardStep(link.index());
                        jumped = true;
                    }
                }
            });

            function setWizardStep(n) {
                $('.wizardSteps a.nav-link:nth-child(' + (n + 1) + ')').click();
            }
        });
        $(function () {
            $('#pharmacySelect').change(function () {
                if ($(this).val() == 'new') {
                    $('#newPharmacy').addClass('show');
                    $('#oldPharmacy').removeClass('show');
                } else {
                    $('#newPharmacy').removeClass('show');
                    $('#oldPharmacy').addClass('show');
                    $.ajax({
                        type: "POST",
                        url: "{{ route( 'eac.portal.pharmacy.info' ) }}",
                        data: {
                            'pharmacy_id': $(this).val(),
                        },
                        success: function (response) {
                            $('#pharmaInfo').html(response);
                        },
                    });
                }
            });
        });

        $(document).ready(function () {
            $('#pharmacistTBL tfoot th').each(function () {
                if ($(this).hasClass("no-search"))
                    return;
                var title = $(this).text();
                $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" />');
            });
            var dataTable = $('#pharmacistTBL').DataTable({
                "paginationDefault": 10,
                "paginationOptions": [10, 25, 50, 75, 100],
                // "responsive": true,
                'order': [[5, 'desc']],
                "ajax": {
                    url: "{{route('eac.portal.pharmacy.getpharmacistajaxlist')}}",
                    type: "get"
                },
                "processing": true,
                "serverSide": true,
                columnDefs: [{
                    targets: 'no-sort',
                    orderable: false,
                }],
                "columns": [
                    {"data": "select", 'name': 'select'},
                    {"data": "name", 'name': 'name'},
                    {"data": "email", 'name': 'email'},
                    {"data": "phone", 'name': 'phone'},
                    {"data": "pharmacy", 'name': 'pharmacy'},
                    {"data": "created_at", 'name': 'created_at'},
                ]
            });
            dataTable.columns().every(function () {
                var that = this;
                $('input', this.footer()).on('keyup change', function () {
                    if (that.search() !== this.value) {
                        that
                            .search(this.value)
                            .draw();
                    }
                });
            });
            $.fn.dataTable.ext.errMode = function (settings, helpPage, message) {
                swal({
                    title: "Oh Snap!",
                    text: "Something went wrong on our side. Please try again later.",
                    icon: "warning",
                });
            };
        }); // end doc ready


        $(document).on('click', 'a.remove', function (e) {
            e.preventDefault();
            $(this).closest('.group-member').remove();
            // let $count = 0;
            $('#memberSection').find('.group-member').each(function () {
                $(this).find('text[name^="name"]').attr('name', 'name[]');
                $(this).find('email[name^="email"]').attr('name', 'email[]');
                $(this).find('text[name^="phone"]').attr('name', 'phone[]');
                // $count++;
            });
        });
        function templateShow(){
            $("#memberSection").show();
            $(".group-member-templatetable ").show();
            $("#addMemberBtn").show();
        }
        function addMember() {
            let $template = $('.group-member-template');
            let $memberSection = $("#memberSection");
            console.log($template);
            $memberSection.append($template.prop('outerHTML'));
            let $newMember = $memberSection.find(".group-member:last");
            console.log($newMember);
            $newMember.removeClass('group-member-template');
            const $count = $memberSection.find(".group-member").length - 1;
            $newMember.find('text[name^="name"]').attr('name', 'name[]');
            $newMember.find('email[name^="email"]').attr('name', 'email[]');
            $newMember.find('text[name^="phone"]').attr('name', 'phone[]');
        }
	</script>
@endsection
