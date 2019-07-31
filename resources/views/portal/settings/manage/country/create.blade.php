@extends('layouts.portal')

@section('title')
 Create Country
@endsection

@section('content')
 <div class="titleBar">
  <nav aria-label="breadcrumb">
   <ol class="breadcrumb">
    <li class="breadcrumb-item">
     <a href="{{ route('eac.portal.getDashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
     <a href="{{ route('eac.portal.settings') }}">Supporting Content</a>
    </li>
    <li class="breadcrumb-item">
     <a href="{{ url('portal/settings/manage/countries') }}">Country Manager</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">
     @yield('title')
    </li>
   </ol>
  </nav>
  <h2 class="m-0">
   @yield('title')
  </h2>
 </div><!-- end .titleBar -->
 <form method="post" action="{{ route($page['storeAction']) }}">
  {{ csrf_field() }}
  <div class="row">
   <div class="col-lg-10 col-xl-9">
    @include('include.alerts')
    <div class="actionBar">
     <a href="{{ route($page['cancelAction']) }}" class="btn btn-warning{{ $active == 'dosage' ? ' active after' : ''}}" >
      <i class="far fa-times"></i> Cancel
     </a>
     <button type="submit" href="{{ route($page['storeAction']) }}" class=" btn btn-info" >
      <i class="far fa-check"></i> Apply
     </button>
    </div><!-- end .actionBar -->
   </div>
  </div><!-- /.row -->

  <div class="viewData">
   <div class="row">
    <div class="col-lg-10 col-xl-9">
     <div class="mb-3 mb-xl-4">
      <div class="card card-body mb-0">
       <div class="row">
        <div class="col-sm mb-3">
         <label class="d-block">Country Name</label>
         <input name="name" type="text" value="{{ old('name') }}" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}">
         <div class="invalid-feedback">
          {{ $errors->first('name') }}
         </div>
        </div>
        <div class="col col-sm-4 mb-3">
         <label class="d-block">Abbreviation</label>
         <input name="abbr" type="text" value="{{ old('abbr') }}" class="form-control {{ $errors->has('abbr') ? ' is-invalid' : '' }}">
         <div class="invalid-feedback">
          {{ $errors->first('abbr') }}
         </div>
        </div>
        <div class="col col-sm-3 mb-3">
         <label class="d-block">Status</label>
         <input data-field="active" type="checkbox" data-toggle="toggle" data-off="Inactive" data-on="Active" data-onstyle="success" data-offstyle="primary" data-width="100" name="active" checked />
        </div>
       </div><!-- /.row -->
       <div class="row">
        <div class="col-sm mb-3">
         <label class="d-block">Ethics Required</label>
         <select class="form-control {{ $errors->has('ethics_req') ? ' is-invalid' : '' }}" name="ethics_req">
          <option disabled hidden selected value="">-- Select --</option>
          <option value="1">Yes</option>
          <option value="0">No</option>
         </select>
         <div class="invalid-feedback">
          {{ $errors->first('ethics_req') }}
         </div>
        </div>
        <div class="col-sm mb-3">
         <label class="d-block">Ave. Days to Deliver</label>
         <input name="avg_days_to_deliver_drug" type="number" value="{{ old('avg_days_to_deliver_drug') }}" class="form-control {{ $errors->has('avg_days_to_deliver_drug') ? ' is-invalid' : '' }}">
        </div>
        {{-- <div class="col-sm-auto mb-3">
         <label class="d-block">Index</label>
         <input name="index" type="number" value="{{ old('index') }}" class="form-control {{ $errors->has('index') ? ' is-invalid' : '' }}">
         <div class="invalid-feedback">
          {{ $errors->first('index') }}
         </div>
        </div> --}}
        <div class="col-sm mb-3">
         <label class="d-block">HAA Required</label>
         <select class="form-control  {{ $errors->has('haa_prereq') ? ' is-invalid' : '' }}" name="haa_prereq">
          <option disabled hidden selected value="">-- Select --</option>
          <option value="1" {{ old("haa_prereq") == 1 ? "selected":"" }}>Yes</option>
          <option value="0" {{ old("haa_prereq") == 0 ? "selected":"" }}>No</option>
         </select>
         <div class="invalid-feedback">
          {{ $errors->first('haa_prereq') }}
         </div>
        </div>
       </div><!-- /.row -->
       <div class="mb-3">
        <label class="d-block">HAA Information</label>
        <!-- <textarea name="haa_info" class="form-control" rows="5">{{ old('haa_info') }}</textarea> -->
        <textarea class="form-control{{ $errors->has('haa_info') ? ' is-invalid' : '' }} basic-editor" rows="5" id="haa_info" name="haa_info" data-field="text"></textarea>
       </div>
       <div class="mb-3">
        <label>Notes</label>
        <!-- <textarea name="notes" class="form-control" rows="4">{{ old('notes') }}</textarea> -->
        <textarea class="form-control{{ $errors->has('notes') ? ' is-invalid' : '' }} basic-editor" rows="4" id="notes" name="notes" data-field="text"></textarea>
       </div>
      </div>
      <div class="card-footer d-flex justify-content-center">
       <button class="btn btn-success {{ $active == 'dosage' ? ' active after' : ''}}" type="submit" href="{{ route($page['storeAction']) }}">
        <i class="far fa-check"></i> Submit
       </button>
      </div>
     </div>
    </div>
   </div><!-- /.row -->
  </div><!-- end .viewData -->
 </form>

@endsection
@section('scripts')
<script>
      $(".alert").delay(2000).slideUp(200, function() {
    $(this).alert('close');
});

  </script>
@endsection
