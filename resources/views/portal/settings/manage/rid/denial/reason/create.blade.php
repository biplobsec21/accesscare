@extends('layouts.portal')

@section('title')
 Create New Denial Reason
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
     <a href="{{ route('eac.portal.settings.manage.rid.denial.reason.index') }}">Denial Reason Manager</a>
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
   <div class="col-lg-8 col-xl-6">
    @php
     if(Session::has('alerts')) {
      $alert = Session::get('alerts');
      $alert_dismiss = view('layouts.alert-dismiss', ['type' => $alert['type'], 'message' => $alert['msg']]);
      echo $alert_dismiss;
     }
    @endphp
    <div class="actionBar">
     <a href="{{ route($page['cancelAction']) }}" class="btn btn-warning {{ $active == 'dosage' ? 'active after' : ''}}" >
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
    <div class="col-lg-8 col-xl-6">
     <div class="mb-3 mb-xl-4">
      <div class="card card-body mb-0">
       <div class="row">
        <div class="col-sm mb-3">
         <label class="d-block">Name</label>
         <input name="name" type="text" value="{{ old('name') }}" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}">
         <div class="invalid-feedback">
          {{ $errors->first('name') }}
         </div>
        </div>
       </div>
        <div class="row">
        <div class="col-sm mb-3">
         <label class="d-block">Description</label>
         <textarea name="description"  class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}">{{ old('description') }}</textarea>
         <div class="invalid-feedback">
          {{ $errors->first('name') }}
         </div>
        </div>
          <div class="col-sm-auto mb-3">
         <label class="d-block">Status</label>
         <input data-field="active" type="checkbox" data-toggle="toggle" data-off="Inactive" data-on="Active" data-onstyle="success" data-offstyle="primary" data-width="100" name="active" checked />
        </div>
       </div>
      </div>
      <div class="card-footer d-flex justify-content-center">
       <button class="btn btn-success{{$active == 'dosage' ? ' active after' : ''}}" type="submit" href="{{ route($page['storeAction']) }}">
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
