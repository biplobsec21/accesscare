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
	@include('include.alerts')
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




{{-- 
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
     </a><!-- added per request RP -->
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
     </div>
     <div class="col-sm-6 col-lg col-xl-12">
      <ul class="nav nav-tabs" id="VExYo" role="tablist">
       <li class="nav-item">
        <a class="nav-link active" id="VExYoDets-tab" data-toggle="tab" href="#VExYoDets" role="tab" aria-controls="VExYoDets" aria-selected="true">
         <span class="d-sm-none d-md-inline">Patient</span> Details
        </a>
       </li>
       <li class="nav-item">
        <a class="nav-link" id="VExYoEtc-tab" data-toggle="tab" href="#VExYoEtc" role="tab" aria-controls="VExYoEtc" aria-selected="false">
         Groups <span class="d-sm-none d-md-inline">Assigned</span>
        </a>
       </li>
      </ul>
      <div class="card mb-3">
       <div class="tab-content">
        <div class="tab-pane active" id="VExYoDets" role="tabpanel" aria-labelledby="VExYoDets-tab">
         <div class="card-header alert-info">
          <h5 class="mb-0 poppins">Patient Details</h5>
         </div>
         @access('rid.patient.view')
          <ul class="list-group list-group-flush mb-0">
           @if(isset($rid->patient_dob))
            <li class="list-group-item">
             <div class="row">
              <div class="col ">
               <label class="d-block">Date of Birth</label>
               {{ $rid->patient_dob }}
              </div>
              <div class="col col-sm-auto col-md ">
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
              @if(isset($rid->patient_weight))
               <div class="col col-sm-auto col-md">
                <label class="d-block">Weight</label>
                {{ $rid->patient_weight }}KG
               </div>
              @endif
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
            @php
             // strip tags to avoid breaking any html
             $string = strip_tags($rid->reason);
             if (strlen($string) > 75) {
              // truncate string
              $stringCut = substr($string, 0, 75);
              $endPoint = strrpos($stringCut, ' ');
              //if the string doesn't contain any space then it will cut without word basis.
              $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
              $string .= '... <a class="badge badge-primary float-right" title="Click to view reason for request" data-toggle="modal" data-target="#showWHOLEreason" href="#showWHOLEreason">Read More</a>';
             }
            @endphp
            <li class="list-group-item">
             <label class="d-block">Reason for Request</label>
             {!! $string !!}
            </li>
           @endif
           @if($rid->proposed_treatment_plan)
            @php
             // strip tags to avoid breaking any html
             $string = strip_tags($rid->proposed_treatment_plan);
             if (strlen($string) > 75) {
              // truncate string
              $stringCut = substr($string, 0, 75);
              $endPoint = strrpos($stringCut, ' ');
              //if the string doesn't contain any space then it will cut without word basis.
              $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
              $string .= '... <a class="badge badge-primary float-right" title="Click to view proposed treatment plan" data-toggle="modal" data-target="#showWHOLEplan" href="#showWHOLEplan">Read More</a>';
             }
            @endphp
            <li class="list-group-item">
             <label class="d-block">Proposed Treatment</label>
             {!! $string !!}
            </li>
           @endif
          </ul>
          @if(isset($rid->reason))
           <div class="modal fade" id="showWHOLEreason" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content">
              <div class="modal-header p-2">
               <h5 class="m-0">
                Reason for Request
               </h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="fal fa-times"></i>
               </button>
              </div>
              <div class="modal-body p-3">
               {{ $rid->reason }}
              </div>
              <div class="modal-footer p-2 d-flex justify-content-between">
               <button type="button" class="btn btn-secondary" data-dismiss="modal" tabindex="-1">Dismiss</button>
              </div>
             </div>
            </div>
           </div>
          @endif
          @if($rid->proposed_treatment_plan)
           <div class="modal fade" id="showWHOLEplan" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content">
              <div class="modal-header p-2">
               <h5 class="m-0">
                Proposed Treatment
               </h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="fal fa-times"></i>
               </button>
              </div>
              <div class="modal-body p-3">
               {{ $rid->proposed_treatment_plan }}
              </div>
              <div class="modal-footer p-2 d-flex justify-content-between">
               <button type="button" class="btn btn-secondary" data-dismiss="modal" tabindex="-1">Dismiss</button>
              </div>
             </div>
            </div>
           </div>
          @endif
         @endif
        </div>
        @access('rid.user.view')
         <div class="tab-pane" id="VExYoEtc" role="tabpanel" aria-labelledby="VExYoEtc-tab">
          @if($rid->user_groups->count() > 0)
           <div class="card-header alert-info">
            <h5 class="mb-0 poppins"><strong>{{$rid->user_groups->count()}}</strong> Groups Assigned</h5>
           </div>
           <div class="list-group list-group-flush">
            @foreach($rid->user_groups->sortBy('name') as $userGroup)
             <div class="list-group-item p-2">
              <strong>{{$userGroup->name}}</strong>
              <div class="row ml-n1 mr-n1 align-items-center">
               <div class="col-sm pl-1 pr-1">
                <small class="upper text-black-50 d-block">{{$userGroup->type->name}} Group</small>
               </div>
               <div class="col-sm-auto pl-1 pr-1">
                <a class="badge p-0" data-toggle="collapse" title="Click to view group members" href="#exp{{$userGroup->id}}" role="button" aria-expanded="false" aria-controls="exp{{$userGroup->id}}">
                 {{$userGroup->users()->count()}} Members
                </a>
               </div>
              </div>
              <div class="pl-4">
               @if($userGroup->parent())
                <div class="small mb-1 d-flex flex-wrap justify-content-between">
                 <a href="{{ route('eac.portal.user.show', $userGroup->parent->id) }}" class="">
                  {{$userGroup->parent->full_name}}
                 </a>
                 <span class="badge badge-success">Group Lead</span>
                </div>
               @endif
               <div class="collapse" id="exp{{$userGroup->id}}">
                @foreach($userGroup->users()->sortBy('first_name') as $user)
                 @if(($user) && ($user->id != $userGroup->parent_user_id))
                  <div class="small mb-1 d-flex flex-wrap justify-content-between">
                   <a href="{{ route('eac.portal.user.show', $user->id) }}" class="">
                    {{$user->full_name}}
                   </a>
                   <span class="badge p-0">{{$userGroup->roleInTeam($user->id)->name}}</span>
                  </div>
                 @endif
                @endforeach
               </div>
              </div>
             </div>
            @endforeach
           </div>
          @else
           <p class="text-muted mb-0">Information unavailable</p>
          @endif
         </div>
        @endif
       </div>
      </div><!-- /.card -->
     </div>
     <div class="col-sm-6 col-lg col-xl-12">
      <ul class="nav nav-tabs" id="VEaBc" role="tablist">
       <li class="nav-item">
        <a class="nav-link active" id="VEaBcDets-tab" data-toggle="tab" href="#VEaBcDets" role="tab" aria-controls="VEaBcDets" aria-selected="true">
         Drug <span class="d-sm-none d-md-inline">Details</span>
        </a>
       </li>
       <li class="nav-item">
        <a class="nav-link" id="VEaBcEtc-tab" data-toggle="tab" href="#VEaBcEtc" role="tab" aria-controls="VEaBcEtc" aria-selected="false">
         <span class="d-sm-none d-md-inline">Reference</span> Documents
        </a>
       </li>
      </ul>
      <div class="card mb-3">
       <div class="tab-content">
        <div class="tab-pane active" id="VEaBcDets" role="tabpanel" aria-labelledby="VEaBcDets-tab">
         <div class="card-header alert-info">
          <h5 class="mb-0 poppins">Drug Requested</h5>
         </div>
         <div class="list-group list-group-flush">
          @access('rid.drug.view')
           <div class="list-group-item p-2">
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
           </div>
           <div class="list-group-item">
            <label class="d-block">Pre-Approval Required</label>
            @if($rid->drug->pre_approval_req)
             No
            @else
             Yes
            @endif
           </div>
          @endif
          @access('rid.info.view')
           <div class="list-group-item">
            <label class="d-block">Request Date</label>
            {{ \Carbon\Carbon::parse($rid->req_date)->format(config('eac.date_format')) }}
           </div>
           <div class="list-group-item">
            <label class="d-block">Requested By</label>
            @if(\Auth::user()->type->name == 'Early Access Care')
             <a href="{{route('eac.portal.user.show', $rid->physician->id)}}">
              {{ $rid->physician->full_name }}
             </a>
            @else
             {{ $rid->physician->full_name }}
            @endif
           </div>
           @if($rid->physician->address)
            @php 
             $country = $rid->physician->address->country;
            @endphp 
            <div class="list-group-item">
             <label class="d-block">Ship To</label>
             <a href="#" data-toggle="modal" data-target="#Modal{{$country->id}}" >
              {{ $country->name}}
             </a>
            </div>
           @endif
          @endif
         </div>
        </div>
        <div class="tab-pane" id="VEaBcEtc" role="tabpanel" aria-labelledby="VEaBcEtc-tab">
         @access('rid.drug.view')
          <div class="card-header alert-info">
           <h5 class="mb-0 poppins">Drug Resources</h5>
          </div>
          @if($rid->drug->resources->count() > 0)
           <div class="list-group list-group-flush">
            @foreach($rid->drug->resources->sortBy('name') as $resource)
             @if($resource->active)
              <div class="list-group-item p-2">
               {{ $resource->name }}
               @include('include.portal.file-btns', ['id' => $resource->file_id])
               <p class="small mb-0">
                {!! $resource->desc ? $resource->desc : '' !!}
               </p>
              </div>
             @endif
            @endforeach
           </div>
          @else
           <div class="card-body p-2 text-muted">Information unavailable</div>
          @endif
         @endif
        </div>
       </div>
      </div><!-- /.card -->
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
               {!! $string !!}
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
 </div> --}}

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
			//	 id: $id,
			//	 field: $field_name,
			//   },
			//   success: function () {
			//	 location.reload();

			//	 // if($field_name == 'upload_file'){
			//	 //   $e.target.parentNode.parentNode.parentNode.innerHTML = '<input class="form-control" type="file" name="' + $field_name + '" >';
			//	 // }else{
			//	 //   $e.target.parentNode.parentNode.innerHTML = '<input class="form-control" type="file" name="' + $field_name + '" >';
			//	 // }
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
