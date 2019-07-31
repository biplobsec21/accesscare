@extends('layouts.portal')
<style type="text/css">
	.upload-add {
		cursor: pointer;
	}
</style>
@section('title')
	Post Approval Documents
@endsection

@section('content')
	<div class="titleBar">
		<nav aria-label="breadcrumb">
			<div class="row">
				<div class="col-sm-auto">
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<a href="{{ route('eac.portal.getDashboard') }}">Dashboard</a>
						</li>
						<li class="breadcrumb-item">
							<a href="{{ route('eac.portal.rid.list') }}">All RIDs</a>
						</li>
						<li class="breadcrumb-item">
							<a href="{{ route("eac.portal.rid.show", $rid->id) }}">View</a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">
							@yield('title')
						</li>
					</ol>
				</div>
				<div class="col-sm-auto ml-sm-auto d-none d-sm-block">
					<div class="small">
						<strong>Last Updated:</strong>
						@php
							$time = $rid->updated_at;
							$time->tz = "America/New_York";
							echo $time->setTimezone(Session::get('time-zone'))->format('Y/m/d h:i A');
						@endphp
					</div>
				</div>
			</div>
		</nav>
		<h6 class="title small upper m-0">
			@yield('title')
		</h6>
		<h2 class="m-0">
			{{$rid->number}}
		</h2>
		<div class="small d-sm-none">
			<strong>Last Updated:</strong>
			@php
				$time = $rid->updated_at;
				$time->tz = "America/New_York";
				echo $time->setTimezone(Session::get('time-zone'))->format('Y/m/d h:i A');
			@endphp
		</div>
	</div><!-- end .titleBar -->
	@if(Session::has('alerts'))
		{!! view('layouts.alert-dismiss', ['type' => Session::get('alerts')['type'], 'message' => Session::get('alerts')['msg']]) !!}
	@endif
	<div class="viewData">
		<!-- <form method="post" action="" enctype="multipart/form-data"> -->
		<div class="row">
			<div class="col-lg-10 col-xl-10">
				@foreach($ridPADocs as $document)
					<?php $doc = \App\RidPostApprovalDocs::where('rid_id', $rid->id)->where('doc_id', $document->id)->first(); ?>
					@if($document->type == 'Uploadable')
						<div class="row">
							<div class="col-md-6 card card-body mb-0"><p>{{$document->name}}</p></div>
							<div class="col-md-6 card card-body mb-0">
								@if($doc->uploaded_file_id ?? null)
									<a title="Add" class="upload-add" data-toggle="modal" data-target="#UploadModal{{$document->id}}" aria-hidden="true">
										<i class="far fa-plus text-success"></i>
										<span class="text-success">Uploaded (Click to change)</span>
									</a>
									<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#UploadReviewModal{{$document->id}}" aria-hidden="true">
										Review
									</a>
								@else
									<a title="Add" class="upload-add" data-toggle="modal" data-target="#UploadModal{{$document->id}}" aria-hidden="true">
										<i class="far fa-plus text-danger"></i>
										<span class="text-danger">Upload required</span>
									</a>
								@endif
							</div>
						</div>
						<div class="modal fade" id="UploadModal{{$document->id}}" tabindex="-1" role="dialog" aria-hidden="true">
							<form method="post" action="{{ route('eac.portal.rid.modal.review.doc.save') }}" enctype="multipart/form-data">
								{{ csrf_field() }}
								<input type="hidden" name="rid_id" value="{{ $rid->id }}"/>
								<input type="hidden" name="document_id" value="{{ $document->id }}"/>
								<input type="hidden" name="action" value="upload"/>
								<div class="modal-dialog modal-dialog-centered" role="document">
									<div class="modal-content">
										<div class="modal-header p-2">
											<h5 class="m-0">
												{{$document->name}}
											</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<i class="fal fa-times"></i>
											</button>
										</div>
										<div class="alert-secondary p-2 border-bottom">
											{{$rid->number}}
										</div>
										<div class="modal-body p-3">
											<div class="mb-3">
												<label class="d-block">Attach Document
													<small>(PDF/JPG)</small>
												</label>
												@if($doc->uploaded_file_id ?? null){
												<div>
													<div class="row">
														<div class="col-sm">
															{{$doc->file->name}}
														</div>
														<div class="col-sm-auto">
															<a class="btn btn-danger btn-sm" href="#" onclick="removeDocument('{{$doc->id}}',event)">
																<i class="far fa-times"></i>
																Delete
															</a>
														</div>
													</div>
												</div>
												@else
													<div class="input-group">
														<input type="file" class="form-control" name="upload_file" value="filename.extension" required/>
													</div>
												@endif
											
											</div>
											<div class="">
												<label class="d-block">Notes</label>
												<textarea class="form-control" rows="3" name="up_notes">{{($doc && $doc->upload_notes) ? $doc->upload_notes : ''}}</textarea>
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
						
						
						<div class="modal fade" id="UploadReviewModal{{$document->id}}" tabindex="-1" role="dialog" aria-hidden="true">
							<form method="post" action="{{ route('eac.portal.rid.modal.review.doc.save') }}" enctype="multipart/form-data">
								{{ csrf_field() }}
								<input type="hidden" name="rid_id" value="{{ $rid->id }}"/>
								<input type="hidden" name="document_id" value="{{ $document->id }}"/>
								<input type="hidden" name="action" value="review"/>
								<div class="modal-dialog modal-dialog-centered" role="document">
									<div class="modal-content">
										<div class="modal-header p-2">
											<h5 class="m-0">
												{{$document->name}} Review </h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<i class="fal fa-times"></i>
											</button>
										</div>
										<div class="alert-secondary p-2 border-bottom text-center">
											@if($document->file)
												@include('include.portal.file-btns', ['id' => $document->file->id])
											@endif
										</div>
										<div class="modal-body p-3">
											<div class="mb-3">
												<div class="row">
													<div class="col-sm-auto">
														<label class="d-sm-block mb-1">
															<input type="radio" name="is_match" value="yes" {{($doc && $doc->is_matched == 'yes') ? 'checked' : ''}}/>
															Yes
														</label>
														<label class="d-sm-block">
															<input type="radio" name="is_match" value="no" {{($doc && $doc->is_matched == 'no') ? 'checked' : ''}}/>
															No
														</label>
													</div>
													<div class="col-sm">
														Does the {{$document->name}} document match with the corresponding drug, physician and patient?
													</div>
												</div>
											</div>
											<hr class="mt-0"/>
											<div class="row">
												<div class="col-md mb-3">
													<label class="d-block">Record #</label>
													<input type="number" value="{{($doc && $doc->record_no) ? $doc->record_no : ''}}" name="record_no" class="form-control"/>
												</div>
												<div class="col-md mb-3">
													<label class="d-block">Expiration Date
														<small>(YYYY-MM-DD)</small>
													</label>
													<input type="text" value="{{($doc && $doc->expiration_date) ? $doc->expiration_date : ''}}" name="exp_date" class="form-control"/>
												</div>
											</div>
											<div class="">
												<label class="d-block">Notes</label>
												<textarea class="form-control" rows="3" name="review_notes">{{($doc && $doc->review_notes) ? $doc->review_notes : ''}}</textarea>
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
					
					@else
						<div class="row">
							<div class="col-md-6 card card-body mb-0"><p>{{$document->name}}</p></div>
							<div class="col-md-6 card card-body mb-0">
								@if($doc && ($doc->is_acknowledged == 1))
									<div class="text-success">Acknowledgement Complete</div>
								@else
									<a title="Add" class="upload-add" data-toggle="modal" data-target="#AcknowledgeModal{{$document->id}}" aria-hidden="true">
										<i class="far fa-plus text-danger"></i>
										<span class="text-danger">Acknowledgement Required</span>
									</a>
								@endif
							</div>
						</div>
						
						<div class="modal fade" id="AcknowledgeModal{{$document->id}}" tabindex="-1" role="dialog" aria-hidden="true">
							<form method="post" action="{{ route('eac.portal.rid.modal.review.doc.save') }}" enctype="multipart/form-data">
								{{ csrf_field() }}
								<input type="hidden" name="rid_id" value="{{ $rid->id }}"/>
								<input type="hidden" name="document_id" value="{{ $document->id }}"/>
								<input type="hidden" name="action" value="acknowledgement"/>
								<div class="modal-dialog modal-dialog-centered" role="document">
									<div class="modal-content">
										<div class="modal-header p-2">
											<h5 class="m-0">
												{{$document->name}}
											</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<i class="fal fa-times"></i>
											</button>
										</div>
										<div class="modal-body p-3">
											@if($document->desc)
												<div class="mb-3">
													<?php
													$desc = str_replace('{drug_name}', $rid->drug->name, $document->desc);
													$descFinal = str_replace('{company_name}', $rid->drug->company->name, $desc);
													echo $descFinal;
													?>
												</div>
											@endif
											<label class="d-block">
												<input type="checkbox" name="" value="" required/>
												@if($document->desc)
													By checking this box I certify I have read the {{$document->name}}
													and agree to its terms.
												@else
													By checking this box I certify that the patient has given consent to
													the receipt of the investigational drug.
												@endif
											</label>
										</div>
										<div class="modal-footer p-2 d-flex justify-content-center">
											<button type="button" class="btn btn-secondary d-none" data-dismiss="modal" tabindex="-1">Cancel
											</button>
											<button type="submit" class="btn btn-success">
												Submit
											</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					@endif
				@endforeach
			</div>
		
		</div>
		
		<!-- </form> -->
	
	</div>
	@include('include.portal.modals.rid.post.upload')
	<!-- @include('include.portal.modals.rid.post.acknowledge') -->
	
	<!-- @include('include.portal.modals.rid.post.health') -->
	<!-- @include('include.portal.modals.rid.post.ethics') -->
	<!-- @include('include.portal.modals.rid.post.drug') -->
	<!-- @include('include.portal.modals.rid.post.letter') -->
	<!-- @include('include.portal.modals.rid.post.consent') -->
@endsection

@section('scripts')
	<script type="text/javascript">
        function removeDocument($id, $e) {

            $.ajax({
                url: "{{route('eac.portal.rid.modal.review.doc.delete')}}",
                type: 'POST',
                data: {
                    id: $id,

                },
                success: function () {
                    $e.target.parentNode.parentNode.parentNode.innerHTML = '<div class="input-group"><input class="form-control" type="file" name="upload_file"/></div>'
                }
            });
        }
	</script>
@endsection
