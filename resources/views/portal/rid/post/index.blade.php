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
                
                echo $time->setTimezone(Session::get('time-zone'))->format('Y/m/d h:i A');
            @endphp
        </div>
    </div><!-- end .titleBar -->
    @include('include.alerts')
    <div class="viewData">
        <div class="row">
            @foreach($postApprovalActions as $postApprovalAction)
				<?php $doc = \App\RidPostApprovalDocs::where('rid_id', $rid->id)->where('doc_id', $postApprovalAction->id)->first(); ?>
                <div class="col-md-6 col-xl-4">
                    <div class="card card-body p-3 mb-3">
                        @if($postApprovalAction->type == 'Uploadable')
                            <h5 class="mb-0 strong">{{$postApprovalAction->name}}</h5>
                            @if($doc->uploaded_file_id ?? null)
                                <div class="d-flex justify-content-between mt-2 flex-wrap">
                                    <div class="border-left pl-3 ml-2 small">
                                        <strong class="d-block">{{$doc->file->name}}</strong>
                                        {{($doc && $doc->upload_notes) ? $doc->upload_notes : ''}}
                                    </div>
                                    <div class="">
                                        <a title="Edit" class="btn btn-info btn-sm" data-toggle="modal" data-target="#UploadModal{{$postApprovalAction->id}}" href="#UploadModal{{$postApprovalAction->id}}" aria-hidden="true">
                                            <span class="fal fa-edit"></span> Edit Upload
                                        </a>
                                    </div>
                                </div>
                                <div class="alert alert-success p-2 mb-n2 mt-2 d-flex justify-content-between align-items-center">
                                    <h6 class="m-0 strong text-success">
                                        <i class="far fa-check"></i>
                                        Uploaded
                                    </h6>
                                    <a title="Review" class="btn btn-success btn-sm" data-toggle="modal" data-target="#UploadReviewModal{{$postApprovalAction->id}}" href="#UploadReviewModal{{$postApprovalAction->id}}" aria-hidden="true">
                                        <span class="fal fa-search"></span> Review
                                    </a>
                                </div>
                            @else
                                <div class="mt-2 ">
                                    <a title="Add" class="btn btn-warning" data-toggle="modal" data-target="#UploadModal{{$postApprovalAction->id}}" href="#UploadModal{{$postApprovalAction->id}}" aria-hidden="true">
                                        <i class="fad fa-upload"></i>
                                        Upload Required
                                    </a>
                                </div>
                            @endif
                            <div class="modal fade" id="UploadModal{{$postApprovalAction->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                <form method="post" action="{{ route('eac.portal.rid.post.approval.action.save') }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="rid_id" value="{{ $rid->id }}"/>
                                    <input type="hidden" name="document_id" value="{{ $postApprovalAction->id }}"/>
                                    <input type="hidden" name="action" value="upload"/>
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header p-2">
                                                <h5 class="m-0">
                                                    {{$postApprovalAction->name}}
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
                                                        <small>({{config('eac.storage.file.type')}})</small>
                                                    </label>
                                                    @if($doc->uploaded_file_id ?? null)
                                                        <div class="row">
                                                            <div class="col-sm">
                                                                @include('include.portal.file-btns', ['id' => $doc->file->id])
                                                            </div>
                                                            <div class="col-sm-auto">
                                                                <a class="btn btn-danger btn-sm" href="#" onclick="removeDocument('{{$doc->id}}',event)">
                                                                    <i class="far fa-times"></i>
                                                                    Delete
                                                                </a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="input-group">
                                                            <input type="file" class="form-control" name="upload_file" value="filename.extension" required/>
                                                        </div>
                                                        <label class="d-block small text-right">Maximum filesize: {{config('eac.storage.file.maxSize')}}</label>
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
                            <div class="modal fade" id="UploadReviewModal{{$postApprovalAction->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                <form method="post" action="{{ route('eac.portal.rid.post.approval.action.save') }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="rid_id" value="{{ $rid->id }}"/>
                                    <input type="hidden" name="document_id" value="{{ $postApprovalAction->id }}"/>
                                    <input type="hidden" name="action" value="review"/>
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header p-2">
                                                <h5 class="m-0">
                                                    {{$postApprovalAction->name}} Review </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <i class="fal fa-times"></i>
                                                </button>
                                            </div>
                                            <div class="alert-secondary p-2 border-bottom text-center">
                                                @if($doc->file ?? false)
                                                    Document
                                                    @include('include.portal.file-btns', ['id' => $doc->file->id])
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
                                                            Does the {{$postApprovalAction->name}} document match with the corresponding drug, physician and patient?
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
                                                        <input type="date" value="{{($doc && $doc->expiration_date) ? $doc->expiration_date : ''}}" name="exp_date" class="form-control"/>
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
                            <h5 class="mb-0 strong">{{$postApprovalAction->name}}</h5>
                            @if($doc && ($doc->is_acknowledged == 1))
                                <div class="alert alert-success p-2 mb-n2 mt-2 d-flex justify-content-between align-items-center">
                                    <h6 class="mt-1 mb-1 strong text-success">
                                        <i class="far fa-check"></i>
                                        Acknowledgement Complete
                                    </h6>
                                </div>
                            @else
                                <div class="mt-2 ">
                                    <a title="Add" class="btn btn-warning" data-toggle="modal" data-target="#AcknowledgeModal{{$postApprovalAction->id}}" href="#AcknowledgeModal{{$postApprovalAction->id}}" aria-hidden="true">
                                        <i class="fad fa-notes-medical"></i>
                                        Acknowledgement Required
                                    </a>
                                </div>
                            @endif
                            <div class="modal fade" id="AcknowledgeModal{{$postApprovalAction->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                <form method="post" action="{{ route('eac.portal.rid.post.approval.action.save') }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="rid_id" value="{{ $rid->id }}"/>
                                    <input type="hidden" name="document_id" value="{{ $postApprovalAction->id }}"/>
                                    <input type="hidden" name="action" value="acknowledgement"/>
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header p-2">
                                                <h5 class="m-0">
                                                    {{$postApprovalAction->name}}
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <i class="fal fa-times"></i>
                                                </button>
                                            </div>
                                            <div class="modal-body p-3">
                                                @if($postApprovalAction->desc)
                                                    <div class="mb-3">
														<?php
														$desc = str_replace('{drug_name}', $rid->drug->name, $postApprovalAction->desc);
														$descFinal = str_replace('{company_name}', $rid->drug->company->name, $desc);
														echo $descFinal;
														?>
                                                    </div>
                                                @endif
                                                <label class="d-block">
                                                    <input type="checkbox" name="" value="" required/>
                                                    @if($postApprovalAction->desc)
                                                        By checking this box I certify I have read the {{$postApprovalAction->name}}
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
                    </div>
                </div>
            @endforeach
        </div>
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
