@extends('layouts.portal')

@section('title')
	Edit Visit
@endsection

@section('styles')
	<style>
	</style>
@endsection

@php
	$bColor = $visit->status->badge;
@endphp

@section('content')
	<div class="titleBar">
		<pre>.titleBar</pre><br />
		<a href="#" class="btn btn-light">test button</a>
		<a href="#" class="btn btn-light">test button</a>
	</div><!-- end .titleBar -->
	<div class="actionBar">
		<pre>.actionBar</pre><br />
		<a href="#" class="btn btn-light">test button</a>
		<a href="#" class="btn btn-light">test button</a>
	</div><!-- end .actionBar -->
	@php
		if($warning == true && (url()->previous() == 'http://v2adev.earlyaccesscare.com/portal/dashboard' ) ){
		 $alert_dismiss = view('layouts.alert-dismiss', ['type' => 'danger', 'message' => 'Please complete all required areas in the visit section']);
		 echo $alert_dismiss;
		}
	@endphp
	@include('include.alerts')
	<div class="viewData">
		{{-- <a class="btn btn-primary" data-toggle="collapse" href="#showRIDmaster" role="button" aria-expanded="false" aria-controls="showRIDmaster">
		 Link with href
		</a>
		<div class="collapse" id="showRIDmaster">
		  Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
		</div>
		<hr /> --}}
		<div class="row">
			<div class="col-xl-3 order-xl-2">
				<div class="row">
					<div class="col-lg col-xl-12">
						<div class="mb-3 pt-2 pl-3 pr-3 pb-2 alert-secondary">
							<ul class="mb-0 nav navbar-nav flex-row justify-content-between justify-content-xl-start flex-xl-column">
								@if(\Auth::user()->type->name == 'Early Access Care')
									@access('rid.document.update')
										{{-- @if(!$rid->visits->count()) --}}
											<li class="nav-item">
												<a href="{{route('eac.portal.rid.resupply', $rid->id)}}" class="nav-link">
													<i class="fas fa-fw fa-calendar-edit"></i>
													Manage Visits
												</a>
											</li>
										{{-- @endif --}}
									@endif
								@endif
								@access('rid.index.update')
									<li class="nav-item">
									<a href="{{ route("eac.portal.rid.edit", $rid->id) }}" class="nav-link">
										<i class="fas fa-fw fa-edit"></i>
										Edit Request Details
									</a>
								</li>
								@endif
								@access('rid.user.create')
									<li class="nav-item">
										<a href="{{route('eac.portal.rid.edit', $rid->id)}}#xusergrpT" class="nav-link">
											<i class="fas fa-fw fa-users"></i>
											Assign User Group
										</a>
									</li>
								@endif
								@access('rid.document.update')
									<li class="nav-item">
										<a href="{{route('eac.portal.rid.postreview', $rid->id)}}" class="nav-link">
											<i class="fas fa-fw fa-upload"></i>
											Post Approval Documents
										</a>
									</li>
								@endif
							</ul>
						</div>
						<div class="row">
							<div class="col-sm-6 col-lg col-xl-12 mb-3">
								<div class="card mb-0">
									<ul class="list-group list-group-flush mb-0">
										<li class="list-group-item">
											<label class="d-block">Drug</label>
										</li>
										<li class="list-group-item">
											<label class="d-block">Request Date</label>
										</li>
										<li class="list-group-item">
											<label class="d-block">Requested By</label>
										</li>
										<li class="list-group-item">
											<label class="d-block">Ship To</label>
										</li>
										<li class="list-group-item">
											<label class="d-block">Pre-Approval Required</label>
										</li>
									</ul>
								</div>
							</div>
							<div class="col-sm-6 col-lg col-xl-12 mb-3">
								<div class="bg-gradient-primary text-white">
									<h6 class="text-center upper mb-0">Patient</h6>
									@if(isset($rid->patient_dob))
										<div class="row">
											<div class="col-sm text-sm-center">
												<label class="d-block">Date of Birth</label>
												{{ $rid->patient_dob }}
											</div>
											<div class="col-sm text-sm-center">
												<label class="d-block">Age</label>
												{{ $rid->getPatientAge() }}
											</div>
										</div>
									@endif

									<div class="row">
										@if(isset($rid->patient_gender))
											<div class="col-sm text-sm-center">
												<label class="d-block">Gender</label>
												{{ $rid->patient_gender }}
											</div>
										@endif
										@if(isset($rid->patient_weight))
											<div class="col-sm text-sm-center">
												<label class="d-block">Weight</label>
												{{ $rid->patient_weight }}KG
											</div>
										@endif
										@if(isset($rid->ethnicity->name))
											<div class="col-sm text-sm-center">
												<label class="d-block">Ethnicity</label>
												{{ $rid->ethnicity->name }}
											</div>
										@endif
										@if(isset($rid->race->name))
											<div class="col-sm text-sm-center">
												<label class="d-block">Race</label>
												{{ $rid->race->name }}
											</div>
										@endif
									</div>
								</div>
								<div class="card mb-0">
									<ul class="list-group list-group-flush mb-0">
										<li class="list-group-item">
											<label class="d-block">Patient</label>
											@if(isset($rid->patient_gender)) {{ $rid->patient_gender }}, @endif 
										 @if(isset($rid->patient_dob)) age {{ $rid->getPatientAge() }}
										  ({{ $rid->patient_dob }})
										 @endif
										</li>
										@if(isset($rid->patient_weight))
											<li class="list-group-item">
												<label class="d-block">Weight</label>
												{{ $rid->patient_weight }}KG
											</li>
										@endif
										@if(isset($rid->ethnicity->name))
											<li class="list-group-item">
												<label class="d-block">Ethnicity</label>
												{{ $rid->ethnicity->name }}
											</li>
										@endif
											<li class="list-group-item">
												<label class="d-block">Race</label>
											</li>
										@if(isset($rid->reason))
											<li class="list-group-item">
												<label class="d-block">Reason for Request</label>
												{{ $rid->reason }}
											</li>
										@endif
										@if($rid->proposed_treatment_plan)
											<li class="list-group-item">
												<label class="d-block">Proposed Treatment</label>
												{{ $rid->proposed_treatment_plan }}
											</li>
										@endif
									</ul>
								</div>
							</div>
						</div><!-- /.row -->
					</div>
					@access('rid.note.view')
						<div class="col-lg-4 col-xl-12 mb-3">
							@if($rid->notes->count() > 0)
								@php $i = 0; @endphp
									<div class="table-responsive">
										<table class="notesTbl small table" data-page-length="5">
											<thead>
											<tr>
												<th>
													<strong>{{$rid->notes->count()}}</strong>
													Notes
												</th>
											</tr>
											</thead>
											<tbody>
											@foreach($rid->notes as $note)
												@php
													// strip tags to avoid breaking any html
													$string = strip_tags($note->text);
													if (strlen($string) > 100) {
														// truncate string
														$stringCut = substr($string, 0, 100);
														$endPoint = strrpos($stringCut, ' ');
														//if the string doesn't contain any space then it will cut without word basis.
														$string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
														$string .= '...<a data-toggle="modal" class="badge badge-info float-right" data-target="#dispNote'.$note->id.'" href="#dispNote{{$note->id}}">Read More</a>';
													}
												@endphp
												@php $i++ @endphp
												<tr>
													<td data-order="{{date('Y-m-d', strtotime($note->created_at))}}">
														<div class="d-flex justify-content-between align-items-center">
															<strong>{{ $note->author->full_name ?? 'N/A' }}</strong>
															<div class="text-muted">
																{{ $note->created_at->format('d M, Y') }}
															</div>
														</div>
														{!! $string !!}
													</td>
												</tr>
												@if (strlen($string) > 75)
													<div class="modal fade" id="dispNote{{$note->id}}" tabindex="-1" role="dialog" aria-labelledby="dispNote{{$note->id}}Label" aria-hidden="true">
														<div class="modal-dialog modal-dialog-centered" role="document">
															<div class="modal-content">
																<div class="modal-header p-2">
																	<h5 class="m-0">
																		View Note </h5>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																		<i class="fal fa-times"></i>
																	</button>
																</div>
																<div class="modal-body p-3">
																	<div class="d-flex justify-content-between align-items-center">
																		<strong>{{ $note->author->full_name ?? 'N/A' }}</strong>
																		<div class="text-muted">
																			{{ $note->created_at->format('d M, Y') }}
																		</div>
																	</div>
																	{{$note->text}}
																</div>
																<div class="modal-footer">
																	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
																</div>
															</div>
														</div>
													</div>
												@endif
											@endforeach
											</tbody>
										</table>
									</div>
								@else
								<div class="card card-body mb-0 p-3">
									<div class="text-muted">
										<span class="fad fa-info-square fa-lg"></span> No notes to display
									</div>
								</div>
							@endif
							<div class="card-footer p-2">
								<a href="#" class="btn btn-success btn-block" data-toggle="modal" data-target="#RidNoteAdd">
									<i class="fad fa-comment-alt-plus"></i>
									Add Note
								</a>
							</div>
						</div>
					@endif
				</div><!-- /.row -->
			</div>
			<div class="col-xl-9 order-xl-1">
		  <div class="card">
			  <div class="card-header border-light">
						<div class="row">
							<div class="col">
			     <h4 class="mb-3 mono">{{ $rid->number }}</h4>
			    </div>
							<div class="col-auto">
								<div class="p-2 bg-gradient-dark text-white  mb-0">
			      <small>Status:</small>
			      {{$rid->status->name}}
			     </div>
		     </div>
		    </div>
		    <ul class="nav nav-tabs card-header-tabs nav-justified" id="n_a_v__t_a_b_s" role="tablist">
						 <li class="nav-item">
						  <a class="nav-link active" id="details2x-tab" data-toggle="tab" href="#details2x" role="tab" aria-controls="details2x" aria-selected="true">
							  Details
							 </a>
						 </li>
						 <li class="nav-item">
						  <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
						   Profile
						  </a>
						 </li>
						 <li class="nav-item">
						  <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">
							  Contact
							 </a>
						 </li>
						</ul>
					</div>
					<div class="card-body">
						<div class="tab-content" id="n_a_v__t_a_b_sContent">
						 <div class="tab-pane fade show active" id="details2x" role="tabpanel" aria-labelledby="details2x-tab">
						 details2x
						 </div>
						 <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
						 profile
						 </div>
						 <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
						 contact
						 </div>
						</div>
					</div>
				</div>
			</div>
		</div>

				@include('portal.rid.show.master')
				@php $visit_index = $visit->index; @endphp
				@if(false)
					<div role="alert" class="alert text-white {{$visit->requiredDocs()->count() == $visit->uploadedDocs()->count() ? 'bg-gradient-success border-success' : 'bg-gradient-danger border-danger'}} mb-0">
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
						<div class="wizardSteps symbols nav flex-row flex-sm-column mt-sm-3" id="tab" role="tablist" aria-orientation="vertical">
							<a class="nav-link active @if($visit->getDocStatus()) complete @endif" id="xdocumentsT" data-toggle="pill" href="#xdocuments" role="tab" aria-controls="xdocuments" aria-selected="true">
								<span>Required Forms</span>
							</a>
							<a class="nav-link  @if($visit->notes->count() > 0) complete @endif " id="xnotesT" data-toggle="pill" href="#xnotes" role="tab" aria-controls="xnotes" aria-selected="false">
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
				</div><!-- /.thisone -->
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
