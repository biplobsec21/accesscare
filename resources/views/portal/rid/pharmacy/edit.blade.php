@extends('layouts.portal')

@section('styles')
	<style>
		.group-member-template {
			display: none;
		}

		@media screen and (min-width: 1200px) {
			:root {
				--leftCol: 250px;
				--rightCol: 675px;
			}

			.actionBar, .viewData {
				max-width: calc(var(--leftCol) + var(--rightCol));
			}

			.viewData .row.thisone > [class*=col]:first-child {
				max-width: var(--leftCol);
				min-width: var(--leftCol);
			}

			.viewData .row.thisone > [class*=col]:last-child {
				max-width: var(--rightCol);
				min-width: var(--rightCol);
			}
		}

		@media screen and (min-width: 1400px) {
			:root {
				--leftCol: 230px;
				--rightCol: 850px;
			}
		}
	</style>
@endsection

@section('title')
	Edit Pharmacy
@endsection

@section('content')
	<div class="titleBar">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="{{route('eac.portal.getDashboard')}}">Dashboard</a>
				</li>
				<li class="breadcrumb-item">
					<a href="{{route('eac.portal.pharmacy.list.all')}}">All Pharmacies</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">
					@yield('title')
				</li>
			</ol>
		</nav>
		<h6 class="m-0">
			@yield('title')
		</h6>
		<h2 class="m-0">
			{{ $pharmacy->name }}
		</h2>
	</div><!-- end .titleBar -->
	@include('include.alerts')

	<div class="viewData">
		<form method="post" action="{{ route('eac.portal.pharmacy.update', $pharmacy->id) }}">
			{{ csrf_field() }}
			<input type="hidden" name="user_id" value="{{ \Auth::user()->id }}">
			<div class="bg-dark text-white pt-2 pb-2 pr-3 pl-3 d-flex justify-content-between">
				<a href="{{ route("eac.portal.pharmacy.show", $pharmacy->id) }}" class="btn btn-secondary">
					View Pharmacy
				</a>
			</div>
			<div class="row thisone m-0 mb-xl-5">
				<div class="col-sm-3 col-xl-auto mb-2 mb-sm-0 p-0">
					<div class="wizardSteps symbols nav flex-row flex-sm-column mt-sm-3" id="tab" role="tablist"
					     aria-orientation="vertical">
						<a class="nav-link active complete" id="xdetailsT" data-toggle="pill" href="#xdetails" role="tab"
						   aria-controls="xdetails" aria-selected="true">
							<span>Details</span>
						</a>
						<a class="nav-link @if($pharmacy->pharmacists->count()) complete @endif" id="xpharmacistsT" data-toggle="pill" href="#xpharmacists" role="tab"
						   aria-controls="xpharmacists" aria-selected="false">
							<span>Pharmacists</span>
						</a>
					</div>
				</div>
				<div class="col-sm-9 col-xl p-0">
					<div class="card tab-content wizardContent" id="tabContent">
						<div class="alert-light text-dark pt-3 pl-3 pr-3">
							<div class="row">
								<div class="col-md mb-1 mb-md-3">
									<strong>{{ $pharmacy->name }}</strong>
									@if($pharmacy->active)
										<span class="badge badge-success">Active</span>
									@else
										<span class="badge badge-secondary">Inactive</span>
									@endif
									<div class="small">
										@if($pharmacy->address)
											{!! $pharmacy->address->strDisplay() !!}
										@endif
									</div>
								</div>
								<div class="col-md-4 col-lg-5 col-xl-6 mb-md-3">
									<div class="row">
										<div class="col-auto col-sm col-md-12 col-xl mb-3 mb-md-3 mb-xl-2">
											<small class="upper d-block">Physician</small>
											<a href="{{ route('eac.portal.user.show', $pharmacy->physician_id) }}">
												<strong>{{ $pharmacy->physician->full_name }}</strong>
											</a>
										</div>
										<div class="col-auto col-sm col-md-12 col-xl-auto mb-3 mb-md-0">
											<small class="upper d-block">Created On</small>
											<strong>{{date('Y-m-d', strtotime($pharmacy->created_at)) }}</strong>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane fade show active" id="xdetails" role="tabpanel"
						     aria-labelledby="xdetails-tab">
							<div class="card-body">
								<h5 class="mb-3">
									Details
								</h5>
								<div class="row">
									<div class="col-sm mb-3">
										<label class="d-block label_required">Pharmacy Name</label>
										<input type="text" name="pharmacy_name" value="{{ $pharmacy->name }}"
										       class="form-control" required="required">
									</div>
									<div class="col-sm-auto text-sm-center mb-3">
										<label class="d-block">
											Active
											<span class="d-sm-block">
									            <input data-field="active" type="checkbox" name="active" {{ $pharmacy->active ? 'checked'  : '' }} />
									        </span>
										</label>
									</div>
									<div class="col-lg-4 col-xl-3 mb-3">
										<label class="d-block">Physician</label>
										<a href="{{ route('eac.portal.user.show', $pharmacy->physician_id) }}">
											{{ $pharmacy->physician->full_name }}
										</a>
									</div>
								</div>
								<div class="mb-3">
									<label class="d-block label_required">Street Address</label>
									<div class="row m-md-0">
										<div class="col-md mb-1 mb-md-3 p-md-0">
											<input type="text" name="pharmacy_addr1"
											       value="{{ $pharmacy->address->addr1 ? $pharmacy->address->addr1 : '' }}"
											       class="form-control" placeholder="Street Address">
										</div>
										<div class="col-md-5 mb-3 p-md-0 pl-md-1">
											<input type="text" name="pharmacy_addr2"
											       value="{{ $pharmacy->address->addr2 ?  $pharmacy->address->addr2 : ''}}"
											       class="form-control"
											       placeholder="Address Continued (Building #, Suite, Floor, etc)">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm col-md-8 col-lg-12 col-xl-7 mb-3">
										<label class="d-block label_required">Country</label>
										<select name="pharmacy_country_id" id="ci" class="form-control"
										        required="required">
											<option disabled hidden selected value="">-- Select --</option>
											@foreach($countries as $country)
												@if ($pharmacy->address->country->id == $country->id)))
												<option value="{{ $country->id }}"
												        selected>{{ $country->name }}</option>
												@else
													<option value="{{ $country->id }}">{{ $country->name }}</option>
												@endif
											@endforeach
										</select>
									</div>
									<div class="col-sm col-md-4 col-lg-12 col-xl mb-3">
										<label class="d-block label_required" id="city_lbl">Town/City</label>
										<input type="text" name="pharmacy_city"
										       value="{{ $pharmacy->address ? $pharmacy->address->city : ''}}"
										       class="form-control" required="required">
									</div>
								</div>
								<div class="row">
									<div class="col-sm col-lg-7 mb-3">
										<label class="d-block">State</label>
										<select name="pharmacy_state_province" id="pharmacy_state_province"
										        class="form-control">
											<option selected value="">-- Select --</option>
											@foreach($states as $state)
												@if($pharmacy->address->state_province)
													<option
														value="{{ $state->id }}" {{$pharmacy->address && $pharmacy->address->state_province == $state->id ? 'selected' : ''}}>{{$state->name}}</option>
												@else
													<option value="{{ $state->id }}">{{ $state->name }}</option>
												@endif
											@endforeach
										</select>
									</div>
									<div class="col-sm col-lg-5 mb-3">
										<label class="d-block label_required" id="zip_lbl">Postal Code</label>
										<input type="number" name="pharmacy_zip"
										       value="{{ $pharmacy->address ? $pharmacy->address->zipcode : '' }}"
										       class="form-control" required="required">
									</div>
								</div>
							</div>
							<div class="card-footer d-flex justify-content-between p-2">
								<button class="btn btn-success" type="submit">
									<i class="far fa-check"></i> Save Pharmacy
								</button>
							</div>

						</div>
						<div class="tab-pane fade" id="xpharmacists" role="tabpanel" aria-labelledby="xpharmacists-tab">
							<div class="card-body">
								<h5 class="mb-3">
									Pharmacists
									<span
										class="badge badge-dark">{{ $pharmacy->pharmacists ?  $pharmacy->pharmacists->count() : '0'}}</span>
								</h5>
								{{-- dynamic for loop --}}
								@if($pharmacy->pharmacists->count() > 0)
									<div class="table-responsive">
										<table class="table cusGem table-sm table-striped table-hover">
											<thead>
											<tr>
												<th>Name</th>
												<th>Email</th>
												<th class="no-sort"></th>
											</tr>
											</thead>
											<tbody>
											@foreach($pharmacy->pharmacists as $val)
												<tr>
													<td>
														<a href="{{ route('eac.portal.pharmacist.edit', $val->id) }}"
														   data-toggle="tooltip" title="Edit {{ $val->name}}">
															{{ $val->name}}
														</a>
													</td>
													<td class="small">
														{{ $val->email ? $val->email : 'N/A'}}
													</td>
													<td class="text-right">
														<a href="#" onclick="Confirm_Delete('{{ $val->id }}')"
														   class="text-danger" title="Remove Pharmacist">
															<i class="fal fa-times"></i> <span
																class="sr-only">Remove</span>
														</a>
													</td>
												</tr>
											@endforeach
											</tbody>
										</table>
									</div>
								@else
									<span class="text-muted">No pharmacists to display</span>
								@endif
								{{-- dynamic for loop data end --}}
							</div>
							<div class="card-footer d-flex justify-content-between p-2 align-items-center">
								<a href="#" class="btn btn-success window-btn" data-toggle="modal"
								   data-target="#newPharmacistmodal">
									Add New Pharmacist
								</a>
								<a href="#" class="btn btn-primary" data-toggle="modal"
								   data-target="#pharmacistaddmodal">
									Assign Pharmacist
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div><!-- /.viewData -->

	<div class="modal fade" id="pharmacistaddmodal" tabindex="-1" role="dialog" aria-hidden="true">
		<form method="post" action="{{ route('eac.portal.pharmacy.assignepharmacist') }}" enctype="multipart/form-data">
			{{ csrf_field() }}
			<input type="hidden" name="pharmacy_id" value="{{$pharmacy->id}}"/>
			<div class="modal-dialog modal-dialog-centered modal-xl" role="document">
				<div class="modal-content">
					<div class="modal-header p-2">
						<h5 class="m-0">
							Select Pharmacist
						</h5>

						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<i class="fal fa-times"></i>
						</button>
					</div>
					<div class="modal-body p-3">
						<div class="table-responsive">
							<table class="table  table-sm table-striped table-hover" id="pharmacistTBL">
								<thead>
								<tr>
									<th class="no-sort no-search">Select</th>
									<th>Name</th>
									<th>Email</th>
									<th>Phone</th>
									<th>Pharmacy</th>
									<th>Created At</th>
								</tr>
								</thead>
								<tfoot>
								<tr>
									<th class="no-sort no-search">Select</th>
									<th>Name</th>
									<th>Email</th>
									<th>Phone</th>
									<th>Pharmacy</th>
									<th>Created At</th>
								</tr>
								</tfoot>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>

					<div class="modal-footer p-2 d-flex justify-content-between">
						<button type="button" class="btn btn-secondary" data-dismiss="modal" tabindex="-1">Cancel
						</button>
						<button type="submit" class="btn btn-success">
							Submit
						</button>
					</div>
				</div>
			</div>
		</form>
	</div>

	<div class="modal fade" id="newPharmacistmodal" tabindex="-1" role="dialog" aria-hidden="true">
		<form method="post" action="{{ route('eac.portal.pharmacy.newpharmacist') }}" enctype="multipart/form-data">
			{{ csrf_field() }}
			<input type="hidden" name="pharmacy_id" value="{{$pharmacy->id}}"/>
			<input type="hidden" name="country_name"
			       value="{{$pharmacy->address && $pharmacy->address->country ? $pharmacy->address->country->id  : 0 }}"/>
			<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header p-2">
						<h5 class="m-0">
							New Pharmacist
						</h5>

						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<i class="fal fa-times"></i>
						</button>
					</div>
					<div class="modal-body p-3">
						<table class="table table-sm table-striped table-hover">
							<thead>
							<tr>
								<th>Name</th>
								<th>Email</th>
								<th>Phone</th>
								<th></th>
							</tr>
							</thead>
							<tbody id="memberSection">
							<tr class="">
								<td>
									<input type="text" name="name[]" placeholder="Pharmacist Name"
									       class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
									       required="required">
								</td>
								<td>
									<input type="email" name="email[]" placeholder="Email"
									       class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
									       required="required">
								</td>
								<td>
									<input type="text" name="phone[]" placeholder="Phone"
									       class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}"
									       required="required">
								</td>
								<td>
								</td>
							</tr>
							</tbody>
						</table>


						<div class="d-flex justify-content-between mt-3">
							<a href="#" class="btn btn-link" id="addMemberBtn" onclick="addMember()">
								<i class="fal fa-plus"></i> Add Another
							</a>
						</div>
					</div>

					<div class="modal-footer p-2 d-flex justify-content-between">
						<button type="button" class="btn btn-secondary" data-dismiss="modal" tabindex="-1">Cancel
						</button>
						<button type="submit" class="btn btn-success">
							Submit
						</button>
					</div>
				</div>
			</div>
		</form>
	</div>
	<table>
		<tr class="group-member group-member-template">
			<td>
				<input type="text" name="name[]" placeholder="Pharmacist Name"
				       class="form-control " required="required">
			</td>
			<td>
				<input type="email" name="email[]" placeholder="Email"
				       class="form-control " required="required">
			</td>
			<td>
				<input type="text" name="phone[]" placeholder="Phone"
				       class="form-control " required="required">
			</td>
			<td>
				<a class="text-danger remove" href="#">
					<i class="fas fa-times"></i>
				</a>
			</td>
		</tr>
	</table>

@endsection

@section('scripts')

	<script type="text/javascript">
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
        function Confirm_Delete(param) {

            swal({
                title: "Are you sure?",
                text: "Want to remove pharmacist",
                icon: "warning",
                buttons: [
                    'No, cancel it!',
                    'Yes, I am sure!'
                ],
                dangerMode: true,
            }).then(function (isConfirm) {
                if (isConfirm) {
                    swal({
                        title: 'Successfull!',
                        text: 'Content deleted!',
                        icon: 'success'
                    }).then(function () {
                        $.get("{{route('eac.portal.pharmacy.pharmacistremove')}}",
                            {
                                id: param
                            });
                        // return false;
                        swal.close();

                        $(location).attr('href', '{{route('eac.portal.pharmacy.edit',$pharmacy->id)}}');
                    });
                } else {
                    swal("Cancelled", "Operation cancelled", "error");
                }
            })
        }


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
