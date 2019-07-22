@extends('layouts.portal')

@section('title')
 Reviewing RID Submission
@endsection

@section('content')
 <div class="titleBar">
  <div class="row justify-content-between">
   <div class="col-md col-lg-auto">
    <h4 class="m-0">Review RID Submission</h4>
   </div>
  </div>
 </div><!-- end .titleBar -->
 <div class="actionBar">
  <a href="{{ url()->previous() }}" class="btn btn-light">
   <i class="far fa-angle-double-left"></i> Go back
  </a>
 </div><!-- end .actionBar -->
 <div class="viewData">
  <h4 class="strong mb-3">
   Please review your RID submission then agree to confidentiality agreement<span class="d-xl-none"> below</span>.
  </h4>
  <div class="row">
   <div class="ml-xl-auto col-xl-4 mr-xl-auto">
    <div class="row">
     <div class="col-lg-12">
      <div class="card card-body p-10 mb-3 mb-xl-4">
       <h5>
        Patient Details
       </h5>
       <div class="ri mb-3">
        <label class="d-block">Date of Birth</label>
        {{ date('Y-m-d', strtotime($request['patient_dob'])) }}
       </div>
       <div class="ri mb-3">
        <label class="d-block">Gender</label>
        {{ $request['patient_gender'] }}
       </div>
       <div class="ri mb-3">
        <label class="d-block">Reason for Request</label>
        {{ $request['reason'] }}
       </div>
       <div class="ri mb-3">
        <label class="d-block">Attending Physician</label>
        {{ \App\User::where('id', $request['physician_id'])->first()->full_name }}
       </div>
      </div>
     </div>
     <div class="col-lg-12">
      <div class="card card-body p-10 mb-3 mb-xl-4">
       <h5>
        Requested Drug
       </h5>
       <div class="ri mb-3">
        <label class="d-block">Investigational Drug</label>
        {{ $drug->name }} <small>({{ $drug->lab_name }})</small>
       </div>
       <div class="ri">
        <label class="d-block">Proposed Treatment Plan</label>
        {{ $request['proposed_treatment_plan'] }}
       </div>
      </div>
     </div>
    </div>
   </div>
   <div class="ml-xl-auto col-xl-6 mr-xl-auto">
    <div class="alert alert-danger ">
     <h4 class="text-danger strong m-0 text-center">
      Confidentiality Agreement
     </h4>
     <p class="mb-3 conf-text text-dark strong p-xl-3 mb-xl-0">
      Confidential information specific to drug will be disclosed to you as supportive and instructional information. The information is confidential and is the sole property of the company. Except as otherwise agreed to in writing, and by accepting or reviewing documents provided for the sole purpose of use outside of a clinical trial, you agree to hold this information in confidence and not copy, distribute or disclose the information contained in the documents.
     </p>
     <form method="POST" action="{{ route('eac.portal.rid.store') }}">
      @csrf
      <div class="row align-items-center">
       <div class="col-sm text-sm-right pr-sm-0">
        <strong>Signature</strong>
       </div>
       <div class="col-sm">
        <input name="signature" type="text" id="signature" onkeypress="return isOnlyText(event)"  class="form-control" required>
       </div>
       <div class="col-sm">
        <button type="Submit" class="btn btn-danger" name="data" value="{{ json_encode($request) }}">
         Agree &amp; Initiate Request
        </button>
       </div>
      </div>
     </form>
    </div>
   </div>
  </div>


 </div>
@endsection

@section('scripts')

<script type="text/javascript">
  function isOnlyText(evt)
      {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 
        && (charCode < 48 || charCode > 57))
        return true;
        return false;
      } 
</script>>
@endsection
