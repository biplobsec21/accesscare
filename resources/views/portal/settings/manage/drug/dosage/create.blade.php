@extends('layouts.portal')

@section('title')
 Create Dosage
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
     <a href="{{ route('eac.portal.settings.manage.drug.dosage.index') }}">Drug Dosage Manager</a>
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
   <div class="col-lg-10 col-xl-8">
    @include('include.alerts')
    <div class="actionBar">
     <a href="{{ route($page['cancelAction']) }}" class="btn btn-warning">
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
    <div class="col-lg-9 col-xl-7">
     <div class="mb-3 mb-xl-4">
      <div class="card card-body mb-0">
       <div class="row">
        <div class="col-sm mb-3">
         <label class="d-block">Dosage Form</label>
         <select class="form-control {{ $errors->has('form_id') ? ' is-invalid' : '' }}" name="form_id">
          <option disabled hidden selected value="">-- Select --</option>
           @if(!empty($dosage['dosageForm']))
            @foreach($dosage['dosageForm'] as $value)
             <option value="{{ $value->id }}" {{ old('form_id') ==  $value->id  ? "selected" : "" }}>{{ $value->name}}</option>
            @endforeach
           @endif
         </select>
         <div class="invalid-feedback">
          {{ $errors->first('form_id') }}
         </div>
        </div>
        <div class="col-sm mb-3">
         <label class="d-block">Relevant Age Group</label>
         <select class="form-control {{ $errors->has('strength_id') ? ' is-invalid' : '' }}" name="strength_id">
          <option disabled hidden selected value="">-- Select --</option>
          @if(!empty($dosage['dosageStrength']))
           @foreach($dosage['dosageStrength'] as $value)
            <option value="{{ $value->id }}" {{ old('strength_id') ==  $value->id  ? "selected" : "" }}>{{ $value->name}}</option>
           @endforeach
          @endif
         </select>
         <div class="invalid-feedback">
          {{ $errors->first('strength_id') }}
         </div>
        </div>
       </div><!-- /.row -->
       <div class="row">
        <div class="col-sm col-md-3 col-lg-2 mb-3">
         <label class="d-block">Dose Strength</label>
         <input name="amount" type="number" value="{{ old('amount') }}" class="form-control {{ $errors->has('amount') ? ' is-invalid' : '' }}">
         <div class="invalid-feedback">
          {{ $errors->first('amount') }}
         </div>
        </div>
        <div class="col-sm-8 col-md-4 col-lg mb-3">
         <label class="d-block">Unit/Concentration</label>
         <select class="form-control {{ $errors->has('unit_id') ? ' is-invalid' : '' }}" name="unit_id">
          <option disabled hidden selected value="">-- Select --</option>
          @if(!empty($dosage['dosageUnit']))
           @foreach($dosage['dosageUnit'] as $value)
            <option value="{{ $value->id }}" {{ old('unit_id') ==  $value->id  ? "selected" : "" }}>{{ $value->name}}</option>
           @endforeach
          @endif
         </select>
         <div class="invalid-feedback">
          {{ $errors->first('unit_id') }}
         </div>
        </div>
        <div class="col-sm-8 col-md col-lg-3 mb-3">
         <label class="d-block">Temperature</label>
         <input name="temperature" type="text" value="{{ old('temperature') }}" class="form-control {{ $errors->has('temperature') ? ' is-invalid' : '' }}">
         <div class="invalid-feedback">
          {{ $errors->first('temperature') }}
         </div>
        </div>
        <div class="col-sm col-md-auto mb-3">
         <label class="d-block">Status</label>
         <input data-field="active" type="checkbox" data-toggle="toggle" data-off="Inactive" data-on="Active"  data-onstyle="success" data-offstyle="primary" data-width="100" name="active" checked />
        </div>
       </div><!-- /.row -->
      </div>
      <div class="card-footer d-flex justify-content-center">
       <button class="btn btn-success{{ $active == 'dosage' ? 'active after' : ''}}" type="submit" href="{{ route($page['storeAction']) }}">
        <i class="far fa-check"></i> Submit
       </button>
      </div>
     </div>
    </div>
   </div><!-- /.row -->
  </div><!-- /.viewData -->
 </form>

@endsection
@section('scripts')
<script>
$(".alert").delay(2000).slideUp(200, function() {
    $(this).alert('close');
});

  </script>
@endsection
