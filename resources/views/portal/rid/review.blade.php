@extends('layouts.portal')

@section('title')
    Reviewing RID Submission
@endsection
@section('styles')
    <style>
        @media screen and (min-width: 750px) {
            .viewData {
                max-width: 750px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="titleBar">
        <h5 class="m-0">Review RID Submission</h5>
    </div><!-- end .titleBar -->
    <div class="actionBar">
        <a href="{{ url()->previous() }}" class="btn btn-light">
            <i class="far fa-angle-double-left"></i>
            Go back
        </a>
    </div><!-- end .actionBar -->
    <div class="viewData">
        <div class="alert mb-0 mb-sm-3 alert-info">
            <h5 class="m-0 strong">
                Please review your RID submission then agree to confidentiality agreement
                <span class="d-xl-none"> below</span>.
            </h5>
        </div>
        <div class="">
            <div class="row ml-n2 mr-n2">
                <div class="col-sm pl-2 pr-2 mb-sm-3">
                    <div class="card-header bg-light text-dark text-white p-2">
                        <span class="small strong upper">
                            Patient Details </span>
                    </div>
                    <ul class="list-group list-group-flush bg-white">
                        <li class="list-group-item">
                            <label class="d-block">Date of Birth</label>
                            <span class="mono">{{ date('Y-m-d', strtotime($request['patient_dob'])) }}</span>
                        </li>
                        <li class="list-group-item">
                            <label class="d-block">Gender</label>
                            {{ $request['patient_gender'] }}
                        </li>
                        <li class="list-group-item">
                            <label class="d-block">Reason for Request</label>
                            {{ $request['reason'] }}
                        </li>
                        <li class="list-group-item">
                            <label class="d-block">Attending Physician</label>
                            {{ \App\User::where('id', $request['physician_id'])->first()->full_name }}
                        </li>
                    </ul>
                </div>
                <div class="col-sm pl-2 pr-2 mb-sm-3">
                    <div class="card-header bg-light text-dark text-white p-2">
                        <span class="small strong upper">
                            Drug Requested </span>
                    </div>
                    <ul class="list-group list-group-flush bg-white">
                        <li class="list-group-item">
                            <label class="d-block">Investigational Drug</label>
                            <span class="mono">{{ $drug->name }}</span>
                            <small>({{ $drug->lab_name }})</small>
                        </li>
                        <li class="list-group-item">
                            <label class="d-block">Proposed Treatment Plan</label>
                            {{ $request['proposed_treatment_plan'] }}
                        </li>
                    </ul>
                </div>
            </div><!-- /.row -->
            @if(\Auth::user()->type->name === 'Physician')
                <div class="alert alert-danger mb-0 p-2">
                    <h4 class="text-danger strong m-0 text-center">
                        Confidentiality Agreement </h4>
                    <p class="mb-3 conf-text text-dark p-xl-3 mb-xl-0">
                        Confidential information specific to drug will be disclosed to you as supportive and instructional information. The information is confidential and is the sole property of the company. Except as otherwise agreed to in writing, and by accepting or reviewing documents provided for the sole purpose of use outside of a clinical trial, you agree to hold this information in confidence and not copy, distribute or disclose the information contained in the documents. </p>
                    <form method="POST" action="{{ route('eac.portal.rid.store') }}">
                        @csrf
                        <div class="d-sm-flex justify-content-sm-between align-items-sm-end">
                            <div class="flex-fill mb-2 mb-sm-0">
                                <label class="d-block small">
                                    Signature
                                </label>
                                <input name="signature" type="text" id="signature" onkeypress="return isOnlyText(event)" class="form-control" required>
                            </div>
                            <div class="text-center pl-2">
                                <button type="Submit" class="btn btn-danger" name="data" value="{{ json_encode($request) }}">
                                    Agree &amp; Initiate Request
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            @else
                <form method="POST" action="{{ route('eac.portal.rid.store') }}">
                    @csrf
                    <div class="d-sm-flex justify-content-sm-between align-items-sm-end">
                        <div class="text-center pl-2">
                            <button type="Submit" class="btn btn-success" name="data" value="{{ json_encode($request) }}">
                                Initiate Request
                            </button>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    
    </div>
@endsection

@section('scripts')
    
    <script type="text/javascript">
        function isOnlyText(evt) {
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode != 46 && charCode > 31
                && (charCode < 48 || charCode > 57))
                return true;
            return false;
        }
    </script>>
@endsection
