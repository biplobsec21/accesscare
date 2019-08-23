@extends('layouts.portal')

@section('title')
	Edit RID / Edit Visit (MOCKUP)
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
  <div class="row">
   <div class="col">
    <h6 class="small upper m-0">
     Edit RID
    </h6>
    <h2 class="mb-0 mono">{{ $rid->number }}</h2>
   </div>
   <div class="col-auto">
    <div class="pt-1 pb-1 pl-2 pr-2 bg-gradient-dark text-white mb-0">
     <small>Status:</small>
     {{$rid->status->name}}
    </div>
   </div>
  </div>
 </div><!-- end .titleBar -->
 <div class="viewData">
  <div class="row">
   <div class="col-xl-9">
    <div class="actionBar mb-3">
     <a href="{{route('eac.portal.rid.show', $rid->id)}}" class="btn btn-light">
      View RID
     </a>
     <a href="{{route('eac.portal.rid.show', $rid->id)}}" class="ml-xl-auto btn btn-warning">
      <i class="fal fa-times"></i>
      Cancel
     </a>{{-- added per request RP --}}
    </div><!-- end .actionBar -->
    <div class="border border-light mb-3">
     <ul class="nav nav-pills nav-justified" id="n_a_v__t_a_b_s" role="tablist">
      <li class="nav-item">
       <a class="nav-link active" id="visits2x-tab" data-toggle="tab" href="#visits2x" role="tab" aria-controls="visits2x" aria-selected="true">
        Request Visits
       </a>
      </li>
      <li class="nav-item">
       <a class="nav-link" id="users-tab" data-toggle="tab" href="#users" role="tab" aria-controls="users" aria-selected="false">
        Assigned Groups
       </a>
      </li>
      <li class="nav-item">
       <a class="nav-link" id="drug-tab" data-toggle="tab" href="#drug" role="tab" aria-controls="drug" aria-selected="false">
        Reference Documents
       </a>
      </li>
     </ul>
    </div>
    <div class="tab-content" id="n_a_v__t_a_b_sContent">
     <div class="tab-pane fade show active" id="visits2x" role="tabpanel" aria-labelledby="visits2x-tab">
      @access('rid.visit.view')
       <div class="row">
        <div class="col-sm-3">
         @if($rid->shipments->count() > 0)
          @php $shipment_index = 1; @endphp
          <ul class="list-group list-group-flush flex-row flex-sm-column">
           @foreach($rid->shipmentsSorted() as $shipment)
            <li class="list-group-item bg-white border-0 mb-3 p-2">
             <a class="strong {{$shipment->getTodo() === 'Ready'  ? 'complete' : ''}}" id="xshipT{{$shipment->id}}" data-toggle="pill" href="#xship{{$shipment->id}}" role="tab" aria-controls="xship{{$shipment->id}}" aria-selected="false">
              Shipment {{$shipment_index}}
             </a>
             @if($shipment->visits->count() > 0)
              <div class="d-flex flex-column ml-3">
               @foreach($shipment->visits->sortBy('index') as $visit)
                <a class="mb-1 {{$visit->getDocStatus() ? 'complete' : ''}}" id="xdetailsT{{$visit->index}}" data-toggle="pill" href="#xdetails{{$visit->index}}" role="tab" aria-controls="xdetails{{$visit->index}}" aria-selected="false">
                 Visit #{{$visit->index == 0 ? 1 : $visit->index}}
                 @if($visit->visit_date) <small>({{ $visit->visit_date }})</small> @endif
                </a>
               @endforeach
              </div>
             @endif
             @php $shipment_index ++; @endphp
            </li>
           @endforeach
          </ul>
         @endif
        </div>
        <div class="col-sm-9">
         <div class="tab-content wizardContent" id="tabContent">
          @php $shipment_index = 1; @endphp
          @foreach($rid->shipmentsSorted() as $shipment)
           @include('portal.rid.show.shipment')
           @php $shipment_index ++; @endphp
          @endforeach
          @foreach($rid->visits->sortBy('index') as $visit)
           @include('portal.rid.show.visit')
          @endforeach
         </div>
        </div>
       </div><!-- /.row -->
      @endif
     </div>
     @access('rid.user.view')
      <div class="tab-pane fade" id="users" role="tabpanel" aria-labelledby="users-tab">
       <h5 class="mb-3">Assigned Groups</h5>
       @if($rid->user_groups->count() > 0)
        @include('portal.rid.show.users')
       @else
        <p class="text-muted mb-0">Information unavailable</p>
       @endif
      </div>
     @endif
     @access('rid.drug.view')
      <div class="tab-pane fade" id="drug" role="tabpanel" aria-labelledby="drug-tab">
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
     @endif
    </div>
   </div>
   <div class="col-xl-3">
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
        @if(\Auth::user()->type->name == 'Early Access Care' || \Auth::user()->type->name == 'Physician')
         <li class="nav-item">
          <a class="nav-link" href="#ridLogin{{$rid->id}}" data-toggle="modal" data-target="#ridLogin{{$rid->id}}">
           <i class="fas fa-fw fa-lock-alt"></i> 
           Patient Password
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
     </div>
     <div class="col-sm-6 col-lg col-xl-12 mb-3">
      <div class="card mb-0">
       <ul class="list-group list-group-flush mb-0">
        @access('rid.drug.view')
         <li class="list-group-item">
          <label class="d-block">Drug</label>
          @if(\Auth::user()->type->name == 'Early Access Care')
          <a href="{{ route('eac.portal.drug.show', $rid->drug->id) }}" class="mono">
           {{ $rid->drug->name }}
          </a> ({{$rid->drug->lab_name}})
          <div>
           <a href="{{ route('eac.portal.company.show', $rid->drug->company->id) }}">
            {{ $rid->drug->company->name }}
           </a>
          </div>
          @else
           <span class="mono">{{ $rid->drug->name }}</span> ({{$rid->drug->lab_name}})
           <div>
            {{ $rid->drug->company->name }}
           </div>
          @endif
         </li>
         <li class="list-group-item">
          <label class="d-block">Pre-Approval Required</label>
          @if($rid->drug->pre_approval_req)
           No
          @else
           Yes
          @endif
         </li>
        @endif
        @access('rid.info.view')
         <li class="list-group-item">
          <label class="d-block">Request Date</label>
          {{ \Carbon\Carbon::parse($rid->req_date)->format(config('eac.date_format')) }}
         </li>
         <li class="list-group-item">
          <label class="d-block">Requested By</label>
          @if(\Auth::user()->type->name == 'Early Access Care')
           <a href="{{route('eac.portal.user.show', $rid->physician->id)}}">
            {{ $rid->physician->full_name }}
           </a>
          @else
           {{ $rid->physician->full_name }}
          @endif
         </li>
         @if($rid->physician->address)
          @php 
           $country = $rid->physician->address->country;
          @endphp 
          <li class="list-group-item">
           <label class="d-block">Ship To</label>
           <a href="#" data-toggle="modal" data-target="#Modal{{$country->id}}" >
            {{ $country->name}}
           </a>
          </li>
         @endif
        @endif
       </ul>
      </div>
     </div>
     <div class="col-sm-6 col-lg col-xl-12 mb-3">
      @access('rid.patient.view')
       <div class="card mb-0">
        <ul class="list-group list-group-flush mb-0">
         @if(isset($rid->patient_dob))
          <li class="list-group-item">
           <div class="row">
            <div class="col ">
             <label class="d-block">Date of Birth</label>
             {{ $rid->patient_dob }}
            </div>
            <div class="col ">
             <label class="d-block">Age</label>
             {{ $rid->getPatientAge() }}
            </div>
           </div><!-- /.row -->
          </li>
          <li class="list-group-item">
           <div class="row">
            @if(isset($rid->patient_gender))
             <div class="col">
              <label class="d-block">Gender</label>
              {{ $rid->patient_gender }}
             </div>
            @endif
            {{-- @if(isset($rid->patient_weight)) --}}
             <div class="col">
              <label class="d-block">Weight</label>
              {{-- {{ $rid->patient_weight }}KG --}}
              123KG
             </div>
            {{-- @endif --}}
           </div><!-- /.row -->
          </li>
         @endif
         @if(isset($rid->ethnicity->name))
          <li class="list-group-item">
           <label class="d-block">Ethnicity</label>
           {{ $rid->ethnicity->name }}
          </li>
         @endif
         @if(isset($rid->race->name))
          <li class="list-group-item">
           <label class="d-block">Race</label>
           {{ $rid->race->name }}
          </li>
         @endif
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
      @endif
     </div>
     @access('rid.note.view')
      <div class="col-lg-4 col-xl-12 mb-3">
       <div class="card card-body mb-0 p-0">
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
         <div class="text-muted p-3">
          <span class="fad fa-info-square fa-lg"></span> No notes to display
         </div>
        @endif
       </div>
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
  </div>

 </div><!-- /.viewData -->

 <div class="titleBar">
  <div class="alert-light text-dark pt-3 pl-3 pr-3">
   <div class="row">
    <div class="col-md mb-3">
     <h6>
      <a href="{{route('eac.portal.rid.show', $rid->id)}}">
       {{ $rid->number }}
      </a>
     </h6>
     <h2>
      Editing Visit #{{$visit->index}}
     </h2>
    </div>
    <div class="col-md mb-3">
     <div class="row align-items-end">
      <div class="col">
       <small class="upper d-block mb-1 mb-md-0">Visit Date</small>
       @if($visit->visit_date)
        <strong>{{ \Carbon\Carbon::parse($visit->visit_date)->format(config('eac.date_format')) }}</strong>
       @else
        <span class="text-secondary">N/A</span>
       @endif
      </div>
      <div class="col">
       <small class="upper d-block mb-1 mb-md-0">Status</small>
       <span class="badge badge-{{$bColor}}">{{ $visit->status->name }}
        - {{ $visit->subStatus->name }}</span>
       @access('rid.info.update')
       <br/>
       <a href="#" class="btn btn-link btn-sm pt-0 pb-0" data-toggle="modal" data-target="#StatusChange">
        Edit
       </a>
       @endif
      </div>
     </div>
    </div>
    <div class="col-md-5 col-lg-7 col-xl-6 mb-3">
     <div class="row">
      <div class="col-sm col-md-12 col-lg">
       <small class="upper d-block mb-xl-1">Assigned To</small>
       @if($visit->physician)
        <strong>{{$visit->physician->full_name}}</strong>
       @else
        <span class="text-muted">N/A</span>
       @endif
      </div>
      <div class="col-sm col-md-12 col-lg col-xl-auto">
       <small class="upper d-block mb-xl-1">Created On</small>
       <strong>{{ $visit->created_at->format(config('eac.date_format')) }}</strong>
      </div>
     </div>
    </div>
   </div>
  </div>
  @include('include.portal.modals.rid.status.edit')
 </div><!-- end .titleBar -->
 <div class="viewData">
  <div class="row">
   <div class="col-xl-9">
    @php
     if($warning == true && (url()->previous() == 'http://v2adev.earlyaccesscare.com/portal/dashboard' ) ){
      $alert_dismiss = view('layouts.alert-dismiss', ['type' => 'danger', 'message' => 'Please complete all required areas in the visit section']);
      echo $alert_dismiss;
     }
    @endphp
    @include('include.alerts')
    @php $visit_index = $visit->index; @endphp
    @if(false)
     <div role="alert" class="alert text-white {{$visit->requiredDocs()->count() == $visit->uploadedDocs()->count() ? 'bg-gradient-success border-success' : 'bg-gradient-danger border-danger'}} mb-0">
      <div class="row">
       <div class="col-auto">
        <h5 class="mb-0">
         <i class="{{ $visit->requiredDocs()->count() == $visit->uploadedDocs()->count() ? 'fas fa-check' : 'fas fa-exclamation-triangle'}}"></i>
         Additional Information {{$visit->requiredDocs()->count() == $visit->uploadedDocs()->count() ? 'complete' : 'required'}}
        </h5>
       </div>
       <div class="col-sm">
        @if($visit->shipment && !$visit->shipment->pharmacy_id)
         <a href="#" class="btn btn-dark mr-3" data-toggle="modal" data-target="#newPharmacyModal{{ $visit->shipment->id }}">
          Add Pharmacy
         </a>
        @endif
       </div>
      </div><!-- /.row -->
     </div><!-- end alert -->
    @endif
    <div class="actionBar mb-3">
     <a href="{{route('eac.portal.rid.show', $rid->id)}}" class="btn btn-light">
      View RID
     </a>
     <a href="{{route('eac.portal.rid.show', $rid->id)}}" class="ml-xl-auto btn btn-warning">
      <i class="fal fa-times"></i>
      Cancel
     </a>{{-- added per request RP --}}
    </div><!-- end .actionBar -->
    @access('rid.document.view')
     <div class="visitData">
      <div class="card">
       <div class="card-body">
        <div class="row">
         <div class="col-md mb-2">
          <h3 class="mb-0">
           Submitting Documents for Visit #{{$visit->index}}
           @if($visit->visit_date) ({{ \Carbon\Carbon::parse($visit->visit_date)->format(config('eac.date_format')) }}) @endif
          </h3>        
         </div>
         <div class="col-md-auto col-lg-3 mb-2 col-xl-auto text-lg-center">
          @if($visit->getDocStatus())
           <span class="badge badge-success ">
            <i class="fas fa-check"></i>
            Complete!
           </span>
          @else
           <span class="badge badge-danger ">
            <i class="fas fa-exclamation-triangle"></i>
            Incomplete
           </span>
          @endif
         </div>
         <div class="col col-md-auto col-lg-3 mb-2 col-xl-auto text-lg-center">
          <small class="upper d-block">Total</small>
          <strong>{{$visit->documents->count()}}</strong>
         </div>
         <div class="col col-md-auto col-lg-3 mb-2 col-xl-auto text-lg-center">
          <small class="upper d-block">Required</small>
          <strong>{{$visit->requiredDocs()->count()}}</strong>
         </div>
         <div class="col col-md-auto col-lg-3 mb-2 col-xl-auto text-lg-center">
          <small class="upper d-block">Uploaded</small>
          <strong>{{$visit->uploadedDocuments()->count()}}</strong>
         </div>
        </div>
       </div>       
       <div class="table-responsive">
        <table class="table table-striped SOint table-sm ">
         <thead>
         <tr>
          <th></th>
          <th>Form Type</th>
          <th colspan="3"></th>
         </tr>
         </thead>
         <tbody>
         @foreach($visit->documents as $visitDocument)
          <tr>
           <td class="text-center">
            @if($visitDocument->file_id)
             @if($visitDocument->redacted_file_id)
              <span class="text-success fas fa-check-circle fa-sm"></span>
             @else
              <span class="text-info fal fa-check fa-xs"></span>
             @endif
            @elseif($visitDocument->required())
             <span class="text-danger fas fa-exclamation-triangle fa-sm"></span>
            @endif
           </td>
           <td>
            {{ $visitDocument->type->name ?? ''}}
            @if($visitDocument->template_file_id)
             @include('include.portal.file-btns', ['id' => $visitDocument->template_file_id])
            @endif
           </td>
           <td class="text-center">
            @if($visitDocument->required())
             <span class="badge badge-outline-dark">Required</span>
            @else
             <span class="badge badge-outline-secondary">Periodic</span>
            @endif
           </td>
           <td class="text-right">
            @if(!$visitDocument->file_id)
             @access('rid.document.create')
             <a href="#" data-toggle="modal" class="" title="Upload File" data-target="#FileUploadModal{{ $visitDocument->id }}">
              <i class="@if(\Auth::user()->type->name == 'Physician') fas @else far @endif fa-upload"></i>
             </a>
            @endif
            @elseif(!$visitDocument->redacted_file_id)
             @access('rid.document.update')
             <a href="#" data-toggle="modal" class="" title="Upload Redacted File" data-target="#AddRedactedModal{{ $visitDocument->id }}">
              <i class="fas fa-upload text-primary"></i>
             </a>
            @endif
            @else
             <a href="#" data-toggle="modal" class="" title="Edit Uploaded Files" data-target="#DocumentEditModal{{ $visitDocument->id }}">
              <i class="far fa-fw fa-edit"></i>
             </a>
            @endif
           </td>
          </tr>
          @if(!$visitDocument->file_id)
           @include('include.portal.modals.rid.document.upload')
          @else
           @include('include.portal.modals.rid.document.redacted')
           @include('include.portal.modals.rid.document.edit')
          @endif
         @endforeach
         </tbody>
        </table>
       </div>       
       @php $drug = \App\DRUG::where('id','=',$rid->drug->id)->firstOrFail() @endphp
       @access('rid.document.update')
       <div class="card-footer d-flex justify-content-between flex-wrap">
        <button type="button" class="btn btn-primary window-btn" data-toggle="modal" data-target="#newDocumentModal">
         <i class="fal fa-plus"></i>
         New Form
        </button>
        @if($visit->getDocStatus())
         <a href="{{route('eac.portal.rid.show', $rid->id)}}" class="btn btn-success">
          <span class="fal fa-check"></span> Submit Documents
         </a>
        @else
         <a href="#" class="btn btn-success disabled">
          Submit Documents
         </a>
        @endif
       </div>
       @include('include.portal.modals.rid.document.new')
       @endif
      </div>
     </div>
    @endif
   </div>
   <div class="col-xl-3">
    <div class="row">
     <div class="col-lg col-xl-12">
      <div class="mb-3 pt-2 pl-3 pr-3 pb-2 alert-secondary">
       <ul class="mb-0 nav navbar-nav flex-row justify-content-between justify-content-xl-start flex-xl-column">
        @access('rid.info.update')
         <li class="nav-item">
          <a href="#" data-toggle="modal" data-target="#reassignRidModal" class="nav-link">
           <i class="fas fa-fw fa-exchange"></i>
           Reassign RID
          </a>
         </li>        
        @endif
        @access('rid.document.update')
         <li class="nav-item">
          <a href="#editReqForms" data-toggle="modal" class="nav-link">
           <i class="fas fa-fw fa-edit"></i>
           Edit Forms
          </a>
         </li>
        @endif
       </ul>
      </div>
      <div class="row">
       <div class="col-sm-6 col-lg col-xl-12 mb-3">
        <div class="card mb-0">
         <ul class="list-group list-group-flush mb-0">
          @access('rid.drug.view')
           <li class="list-group-item">
            <label class="d-block">Drug</label>
            @if(\Auth::user()->type->name == 'Early Access Care')
            <a href="{{ route('eac.portal.drug.show', $rid->drug->id) }}" class="mono">
             {{ $rid->drug->name }}
            </a> ({{$rid->drug->lab_name}})
            <div>
             <a href="{{ route('eac.portal.company.show', $rid->drug->company->id) }}">
              {{ $rid->drug->company->name }}
             </a>
            </div>
            @else
             <span class="mono">{{ $rid->drug->name }}</span> ({{$rid->drug->lab_name}})
             <div>
              {{ $rid->drug->company->name }}
             </div>
            @endif
           </li>
           <li class="list-group-item">
            <label class="d-block">Pre-Approval Required</label>
            @if($rid->drug->pre_approval_req)
             No
            @else
             Yes
            @endif
           </li>
          @endif
          @access('rid.info.view')
           <li class="list-group-item">
            <label class="d-block">Request Date</label>
            {{ \Carbon\Carbon::parse($rid->req_date)->format(config('eac.date_format')) }}
           </li>
           <li class="list-group-item">
            <label class="d-block">Requested By</label>
            @if(\Auth::user()->type->name == 'Early Access Care')
             <a href="{{route('eac.portal.user.show', $rid->physician->id)}}">
              {{ $rid->physician->full_name }}
             </a>
            @else
             {{ $rid->physician->full_name }}
            @endif
           </li>
           @if($rid->physician->address)
            @php 
             $country = $rid->physician->address->country;
            @endphp 
            <li class="list-group-item">
             <label class="d-block">Ship To</label>
             <a href="#" data-toggle="modal" data-target="#Modal{{$country->id}}" >
              {{ $country->name}}
             </a>
            </li>
           @endif
          @endif
         </ul>
        </div>
       </div>
       <div class="col-sm-6 col-lg col-xl-12 mb-3">
        @access('rid.patient.view')
         <div class="card mb-0">
          <ul class="list-group list-group-flush mb-0">
           @if(isset($rid->patient_dob))
            <li class="list-group-item">
             <div class="row">
              <div class="col ">
               <label class="d-block">Date of Birth</label>
               {{ $rid->patient_dob }}
              </div>
              <div class="col ">
               <label class="d-block">Age</label>
               {{ $rid->getPatientAge() }}
              </div>
             </div><!-- /.row -->
            </li>
            <li class="list-group-item">
             <div class="row">
              @if(isset($rid->patient_gender))
               <div class="col">
                <label class="d-block">Gender</label>
                {{ $rid->patient_gender }}
               </div>
              @endif
              {{-- @if(isset($rid->patient_weight)) --}}
               <div class="col">
                <label class="d-block">Weight</label>
                {{-- {{ $rid->patient_weight }}KG --}}
                123KG
               </div>
              {{-- @endif --}}
             </div><!-- /.row -->
            </li>
           @endif
           @if(isset($rid->ethnicity->name))
            <li class="list-group-item">
             <label class="d-block">Ethnicity</label>
             {{ $rid->ethnicity->name }}
            </li>
           @endif
           @if(isset($rid->race->name))
            <li class="list-group-item">
             <label class="d-block">Race</label>
             {{ $rid->race->name }}
            </li>
           @endif
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
        @endif
       </div>
      </div><!-- /.row -->
     </div>
     <div class="col-lg-4 col-xl-12 mb-3">
      <div class="card card-body mb-0 p-0">
       @access('rid.note.view')
        @if($visit->notes->count())
         <div class="table-responsive">
          <table class="notesTbl small table" data-page-length="5">
           <thead>
           <tr>
            <th>
             <strong>{{$visit->notes->count()}}</strong>
             Notes
            </th>
           </tr>
           </thead>
           <tbody>
            @foreach($visit->notes->sortByDesc('created_at') as $note)
             <tr>
              <td data-order="{{date('Y-m-d', strtotime($note->created_at))}}">
               <div class="row m-0 align-items-center">
                <div class="col p-0">
                 <div class="d-flex justify-content-between align-items-center">
                  <strong>{{ $note->author->full_name ?? 'N/A' }}</strong>
                  <div class="text-muted">
                   {{ $note->created_at->format('Y-m-d h:m A') }}
                  </div>
                 </div>
                </div>
                <div class="col-auto pl-1 pr-0">
                 <a href="{{ route('eac.portal.note.delete', $note->id) }}" class="text-danger small" title="Delete Note">
                  <i class="far fa-times"></i> <span class="sr-only">Delete</span>
                 </a>
                </div>
               </div>
               {{ $note->text }}
              </td>
             </tr>
            @endforeach
           </tbody>
          </table>
         </div>
        @else
         <div class="text-muted p-3">
          <span class="fad fa-info-square fa-lg"></span> No notes to display for this visit
         </div>
        @endif
        @access('rid.note.create')
         <div class="card-footer p-2">
          <a href="#" class="btn btn-success btn-block" data-toggle="modal" data-target="#NoteAdd">
           Add Note to Visit
          </a>
         </div>
        @endaccess
       @endif
      </div>
     </div>
    </div><!-- /.row -->
   </div>
  </div>
 </div><!-- /.viewData -->

 @access('rid.info.view')
  @if($rid->physician->address)
   @include('include.portal.modals.rid.country.available_country', $country)
  @endif
 @endif

 @access('rid.note.create')
  <div class="modal fade" id="NoteAdd" tabindex="-1" role="dialog" aria-hidden="true">
   <form method="post" action="{{ route('eac.portal.note.create') }}">
    {{ csrf_field() }}
    <input type="hidden" name="subject_id" value="{{$visit->id}}">
    <div class="modal-dialog modal-dialog-centered " role="document">
     <div class="modal-content">
      <div class="modal-header p-2">
       <h5 class="m-0">
        Add Note to <strong>Visit - {{ \Carbon\Carbon::parse($visit->visit_date)->format(config('eac.date_format')) }}</strong>
       </h5>
       <button type="button" class="close" data-dismiss="modal"
         aria-label="Close">
        <i class="fal fa-times"></i>
       </button>
      </div>
      <div class="modal-body p-3">
       @if(\Auth::user()->type->name == 'Early Access Care')
        <label class="d-block">
         <input name="physican_viewable" type="checkbox" value="1" /> Viewable by Physician
        </label>
       @else
        <input name="physican_viewable" type="hidden" value="1" />
       @endif
       <label
        class="d-block">{{ \Auth::user()->first_name }} {{ \Auth::user()->last_name }}
        <small>{{date('Y-m-d H:i')}}</small>
       </label>
       <textarea name="text" class="note_text form-control" rows="3"
           placeholder="Enter note..."></textarea>
      </div>
      <div class="modal-footer p-2 d-flex justify-content-between">
       <button type="button" class="btn btn-secondary"
         data-dismiss="modal" tabindex="-1">Cancel
       </button>
       <button type="submit" name="submit" class="btn btn-success"
         value="Add Note">Submit
       </button>
      </div>
     </div>
    </div>
   </form>
  </div>
 @endif

 @access('rid.info.update')
  @include('include.portal.modals.rid.reassign.physician')
 @endif
 @access('rid.document.update')
  <form method="post" action="{{ route('eac.portal.rid.document.required.update') }}">
   @csrf
   <div class="modal fade" id="editReqForms" tabindex="-1" role="dialog" aria-labelledby="editReqFormsLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
     <div class="modal-content">
      <div class="modal-header p-2">
       <h5 class="m-0">
        Edit Forms </h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <i class="fal fa-times"></i>
       </button>
      </div>
      <div class="modal-body p-3">
       <div class="table-responsive">
        <table class="table table-striped SOint table-sm ">
         <thead>
         <tr>
          <th class="text-center">Required</th>
          <th>Form Type</th>
         </tr>
         </thead>
         <tbody>
         @foreach($visit->documents as $document)
          <tr class="">
           <td class="text-center">
            <input type="hidden" name="doc[{{$document->id}}]" value="0"/>
            <input type="checkbox" name="doc[{{$document->id}}]" value="1" @if($document->required()) checked @endif />
           </td>
           <td>
            {{ $document->type->name }}
           </td>
          </tr>
         @endforeach
         </tbody>
        </table>
       </div>
      </div>
      <div class="modal-footer p-2 d-flex justify-content-between">
       <button type="button" class="btn btn-secondary" data-dismiss="modal" tabindex="-1">
        Cancel
       </button>
       <button type="submit" class="btn btn-success">
        Save
       </button>
      </div>
     </div>
    </div>
   </div>
  </form>
 @endif
 @include('include.portal.modals.rid.patient.ridlogin', $rid)
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
@endsection

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
