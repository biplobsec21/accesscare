@if((\Auth::user()->type->name == 'Physician') && ($rid->user_groups->count() > 0))
    <div class="alert alert-danger mb-3">
        Please assign a user group to this request
    </div>
@endif
<div class="masterBox mb-3 mb-xl-5">
    <ul class="nav nav-tabs" id="RequestTabs" role="tablist">
        @access('rid.info.view')
        <li class="nav-item">
            <a class="nav-link active" id="master-tab" data-toggle="tab" href="#master" role="tab" aria-controls="master" aria-selected="true">
                Request Details
            </a>
        </li>
        @endif
        @access('rid.user.view')
        <li class="nav-item">
            <a class="nav-link" id="users-tab" data-toggle="tab" href="#users" role="tab" aria-controls="users" aria-selected="false">
                Assigned Groups
            </a>
        </li>
        @endif
        @access('rid.drug.view')
        <li class="nav-item">
            <a class="nav-link" id="drug-tab" data-toggle="tab" href="#drug" role="tab" aria-controls="drug" aria-selected="false">
                Reference Documents
            </a>
        </li>
        @endif
        @if(\Auth::user()->type->name == 'Early Access Care' || \Auth::user()->type->name == 'Physician')
            <li class="nav-item ml-xl-auto">
                <a class="nav-link" href="#ridLogin{{$rid->id}}" data-toggle="modal" data-target="#ridLogin{{$rid->id}}">
                    <span class="fas fa-lock-alt"></span> Patient Password
                </a>
            </li>
        @endif
    </ul>
    <div class="tab-content" id="RequestTabsContent">
        
        <div class="bg-gradient-dark text-white p-3">
            <div class="row">
                <div class="col-sm">
                    <h5 class="mb-0 strong d-inline-block">Viewing RID: <span class="mono">{{ $rid->number }}</span>
                    </h5>
                    @access('rid.index.update')
                    <a href="{{ route("eac.portal.rid.edit", $rid->id) }}" class="small" style="color: var(--yellow)">
                        [edit RID]
                    </a>
                    @endif
                </div>
                <div class="col-sm col-lg-auto">
                    <h5 class="mb-0 strong">Status:
                        <span class="upper">{{$rid->status->name}}</span>
                    </h5>
                </div>
            </div>
        </div>
        <div class="tab-pane fade active show" id="master" role="tabpanel" aria-labelledby="master-tab">
            <div class="border border-info border-top-0 border-bottom-0 bg-white">
                <div class="row">
                    <div class="col-md">
                        <div class="row">
                            <div class="col-sm">
                                <div class="p-3">
                                    @access('rid.drug.view')
                                    <div class="mb-2">
                                        @include('portal.rid.show.drug')
                                    </div>
                                    @endif
                                    @access('rid.info.view')
                                    @include('portal.rid.show.info')
                                    @endif
                                    @access('rid.drug.view')
                                    <div class="mb-2">
                                        <strong class="d-block">Pre-Approval Req</strong>
                                        @if($rid->drug->pre_approval_req)
                                            NO
                                        @else
                                            YES
                                        @endif
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-5">
                                @access('rid.patient.view')
                                <div class="p-3">
                                    @include('portal.rid.show.patient')
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="alert-light text-dark h-100">
                            @access('rid.note.view')
                            <div class="table-responsive">
                                @if($rid->notes->count() > 0)
                                    @php $i = 0; @endphp
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
                                @else
                                    <div class="p-3">No notes to display</div>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-primary text-white p-3 d-flex justify-content-between">
                <div>
                    @access('rid.user.create')
                        <a href="#" class="btn btn-light">
                            <i class="fa-fw fas fa-users"></i>
                            Assign User Group
                        </a>
                    @endif
                    @access('rid.document.update')
                        <a href="{{route('eac.portal.rid.postreview', $rid->id)}}" class="btn btn-light ml-2">
                            <i class="fa-fw fas fa-upload"></i>
                            Post Approval Documents
                        </a>
                    @endif
                    @access('rid.note.view')
                        <a href="#" class="btn btn-success ml-2" data-toggle="modal" data-target="#RidNoteAdd">
                            <i class="fa-fw fas fa-comment-alt-edit"></i>
                            Add Note
                        </a>
                    @endif
                </div>
                <div>
                    @if(\Auth::user()->type->name == 'Early Access Care')
                        @access('rid.document.update')
                        <a href="{{route('eac.portal.rid.resupply', $rid->id)}}" class="btn btn-info ml-2 @if(!$rid->visits->count()) disabled @endif">
                            <i class="fa-fw fas fa-calendar-edit"></i>
                            Manage Visits
                        </a>
                        @endif
                    @endif
                    @access('rid.index.update')
                    <a href="{{ route("eac.portal.rid.edit", $rid->id) }}" class="btn btn-info ml-2">
                        <i class="fa-fw fas fa-edit"></i>
                        Edit RID Master
                    </a>
                    @endif
                </div>
            </div>
        
        </div>
        @access('rid.drug.view')
        <div class="tab-pane fade" id="drug" role="tabpanel" aria-labelledby="drug-tab">
            <div class="card card-body mb-3">
                <h5 class="mb-3">Reference Documents</h5>
                @if($rid->drug->resources->count() > 0)
                    <ul class="">
                        @foreach($rid->drug->resources->sortBy('name') as $resource)
                            @if($resource->active)
                                <li class="">
                                    {{ $resource->name }}
                                    @include('include.portal.file-btns', ['id' => $resource->file_id])
                                    <p class="small mb-0">
                                        {{-- {{$resource->desc}} --}}
                                        {!! $resource->desc ? $resource->desc : '<br> ' !!}
                                    </p>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted mb-0">Information unavailable</p>
                @endif
            </div>
        </div>
        @endif
        @access('rid.user.view')
        <div class="tab-pane fade" id="users" role="tabpanel" aria-labelledby="users-tab">
            <div class="card card-body">
                <h5 class="mb-3">Assigned Groups</h5>
                @if($rid->user_groups->count() > 0)
                    @include('portal.rid.show.users')
                @else
                    <p class="text-muted mb-0">Information unavailable</p>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>@include('include.portal.modals.rid.patient.ridlogin', $rid)
<div class="modal fade" id="RidNoteAdd" tabindex="-1" role="dialog" aria-hidden="true">
    <form method="post" action="{{ route('eac.portal.note.create') }}">
        {{ csrf_field() }}
        <input type="hidden" name="subject_id" value="{{$rid->id}}">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content">
                <div class="modal-header p-2">
                    <h5 class="m-0">
                        Add Note to
                        <strong>RID: <span class="mono">{{ $rid->number }}</span></strong>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times"></i>
                    </button>
                </div>
                <div class="modal-body p-3">
                    @if(\Auth::user()->type->name == 'Early Access Care')
                        <label class="d-block">
                            <input name="physican_viewable" type="checkbox" value="1"/>
                            Viewable by Physician
                        </label>
                    @else
                        <input name="physican_viewable" type="hidden" value="1"/>
                    @endif
                    <label class="d-block">{{ \Auth::user()->first_name }} {{ \Auth::user()->last_name }}
                        <small>{{date('Y-m-d H:i')}}</small>
                    </label>
                    <textarea name="text" class="note_text form-control" rows="3" placeholder="Enter note..."></textarea>
                </div>
                <div class="modal-footer p-2 d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" tabindex="-1">Cancel
                    </button>
                    <button type="submit" name="submit" class="btn btn-success" value="Add Note">Submit
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@section('scripts')
    <script>
        $(document).ready(function () {
            $('.notesTbl').DataTable({
                "stateSave": true,
                "info": false,
                "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
                "order": [[0, "desc"]],
                "searching": false,
                "dom": 't<"d-flex justify-content-between flex-wrap small p-2"lp>'
            });
        });
        function removeTemplateDocument($id, $e, $field_name) {
        console.log($field_name);
        $.ajax({
          url: "{{route('eac.portal.rid.modal.document.remove')}}",
          type: 'POST',
          data: {
              id: $id,
              field: $field_name,
          },
          success: function () {
            location.reload();
            // var labelUploaded_ = $field_name === 'upload_file' ? 'UPLOAD FILE' : ' Redacted file';
           // var labelUploaded = '<label class="d-block">Redacted File <small>({{config('eac.storage.file.type')}})</small></label>';
           //  $e.target.parentNode.parentNode.innerHTML = labelUploaded+' <input class="form-control" type="file" name="' + $field_name + '"/>'
          }
      });
  }
    </script>
@endsection
