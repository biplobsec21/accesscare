@extends('layouts.portal')

@section('title')
	Edit Visit
@endsection

@section('styles')
	<style>
		h1 .badge, h2 .badge, h3 .badge, h4 .badge {
			font-size: 14px;
			line-height: 18px;
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
	$bColor = $visit->status->badge;
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
	@php
		if($warning == true && (url()->previous() == 'http://v2adev.earlyaccesscare.com/portal/dashboard' ) ){
		 $alert_dismiss = view('layouts.alert-dismiss', ['type' => 'danger', 'message' => 'Please complete all required areas in the visit section']);
		 echo $alert_dismiss;
		}
	@endphp
	@if(Session::has('alerts'))
		{!! view('layouts.alert-dismiss', ['type' => Session::get('alerts')['type'], 'message' => Session::get('alerts')['msg']]) !!}
	@endif
	<div class="viewData" style="max-width: calc(var(--leftCol) + var(--rightCol))">
		@include('portal.rid.show.master')
		@php $visit_index = $visit->index; @endphp
		@if(false)
			<div role="alert"
			     class="alert text-white {{$visit->requiredDocs()->count() == $visit->uploadedDocs()->count() ? 'bg-gradient-success border-success' : 'bg-gradient-danger border-danger'}} mb-0">
				<div class="row">
					<div class="col-auto">
						<h5 class="mb-0">
							<i class="{{ $visit->requiredDocs()->count() == $visit->uploadedDocs()->count() ? 'fas fa-check' : 'fas fa-exclamation-triangle'}}"></i>
							Additional
							Information {{$visit->requiredDocs()->count() == $visit->uploadedDocs()->count() ? 'complete' : 'required'}}
						</h5>
					</div>
					<div class="col-sm">
						@if($visit->shipment && !$visit->shipment->pharmacy_id)
							<a href="#" class="btn btn-dark mr-3" data-toggle="modal"
							   data-target="#newPharmacyModal{{ $visit->shipment->id }}">
								Add Pharmacy
							</a>
						@endif
					</div>
				</div><!-- /.row -->
			</div><!-- end alert -->
		@endif

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
							<span class="text-upper">Editing Visit #{{$visit->index}}</span>
							@if($visit->visit_date)-
							<strong>{{ \Carbon\Carbon::parse($visit->visit_date)->format(config('eac.date_format')) }}</strong>@endif
						</div>
						@access('rid.info.update')
						<a class="btn btn-info btn-sm" href="#" data-toggle="modal" data-target="#reassignRidModal">
							Reassign RID
						</a>
						@include('include.portal.modals.rid.reassign.physician')
						@endaccess
					</div>
				</div>
			</div>
		</div>
		<div class="row thisone m-0 mb-xl-5">
			<div class="col-sm-3 col-xl-auto p-0 mb-2 mb-sm-0">
				<div class="wizardSteps symbols nav flex-row flex-sm-column mt-sm-3" id="tab" role="tablist"
				     aria-orientation="vertical">
					<a class="nav-link active @if($visit->getDocStatus()) complete @endif" id="xdocumentsT"
					   data-toggle="pill" href="#xdocuments" role="tab" aria-controls="xdocuments" aria-selected="true">
						<span>Required Forms</span>
					</a>
					<a class="nav-link  @if($visit->notes->count() > 0) complete @endif " id="xnotesT"
					   data-toggle="pill" href="#xnotes" role="tab" aria-controls="xnotes" aria-selected="false">
						<span>Visit Notes</span>
					</a>
				</div>
			</div>
			<div class="col-sm-9 col-xl p-0">
				<div class="card tab-content wizardContent" id="tabContent">
					@include('portal.rid.edit.visit_info')
					<div class="tab-pane fade show active" id="xdocuments" role="tabpanel"
					     aria-labelledby="xdocuments-tab">
						<div class="card-body">
							@access('rid.document.view')
							@include('portal.rid.edit.documents')
							@endaccess
						</div>
					</div><!-- /.tab-pane -->
					<div class="tab-pane fade" id="xnotes" role="tabpanel" aria-labelledby="xnotes-tab">
						<div class="card-body">
							@access('rid.note.view')
							@include('portal.rid.edit.notes')
							@endaccess
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

        function removeTemplateDocument($id, $e, $field_name) {
            // $.ajax({
            //   url: "{{route('eac.portal.rid.modal.document.remove')}}",
            //   type: 'POST',
            //   data: {
            //     id: $id,
            //     field: $field_name,
            //   },
            //   success: function () {
            //     location.reload();

            //     // if($field_name == 'upload_file'){
            //     //   $e.target.parentNode.parentNode.parentNode.innerHTML = '<input class="form-control" type="file" name="' + $field_name + '" >';
            //     // }else{
            //     //   $e.target.parentNode.parentNode.innerHTML = '<input class="form-control" type="file" name="' + $field_name + '" >';
            //     // }
            //   }
            // });
            swal({
                title: "Are you sure?",
                text: "Want to delete it",
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
                        $('.modal').modal('hide')
                        $.ajax({
                            url: "{{route('eac.portal.rid.modal.document.remove')}}",
                            type: 'POST',
                            data: {
                                id: $id,
                                field: $field_name,
                            },
                            success: function () {

                            }
                        });

                        swal.close();

                        location.reload();
                    });

                } else {
                    swal("Cancelled", "Operation cancelled", "error");
                }
            })
        }

        function removeTemplateDocument2($id, $e, $field_name) {
            $.ajax({
                url: "{{route('eac.portal.drug.modal.document.remove_file')}}",
                type: 'POST',
                data: {
                    id: $id,
                    field: $field_name,
                },
                success: function () {
                    $e.target.parentNode.parentNode.innerHTML = '<input class="form-control" type="file" name="' + $field_name + '"/>'
                }
            });
        }

	</script>
@endsection
