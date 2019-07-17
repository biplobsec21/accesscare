@extends('layouts.portal')

@section('title')
Rid Shipping Courier Manager
@endsection

@section('content')
<div class="titleBar">
  <div class="row justify-content-between">
   <div class="col-md col-lg-auto">
    <h4 class="m-0">Supporting Content:</h4>
    <h2 class="m-0">
     @yield('title')
    </h2>
   </div>
   <div class="col-md col-lg-auto ml-lg-auto">
    <ol class="breadcrumb">
     <li class="breadcrumb-item">
      <a href="{{ route('eac.portal.getDashboard') }}">Dashboard</a>
     </li>
     <li class="breadcrumb-item">
      <a href="{{ route('eac.portal.settings') }}">Supporting Content</a>
     </li>
     <li class="breadcrumb-item active" aria-current="page">
      @yield('title')
     </li>
    </ol>
    <div class="text-right">
     <button class="btn btn-secondary btn-sm" id="ShowRightSide" href="#">
      Changelog
     </button>
    </div>
   </div>
  </div>
</div><!-- end .titleBar -->

<!-- Tool bar -->

<div class="actionBar">

  <div class="col-md-6 text-left">
    <a href="{{ route($page['listAll']) }}" class=" btn btn-success {{ $active == 'dosage' ? 'active after' : ''}}" >
     <i class="fas fa-list-ul fa-fw"></i> List all
    </a>
    <a href="{{ route($page['createButton']) }}" class="btn btn-primary">
     <i class="fa-fw far fa-file-medical"></i> Add New
    </a>
    <a href="{{ route($page['listAll']) }}" class="btn btn-secondary btn-sm">
     <i class="fal fa-key"></i> Change Log
    </a>
  </div>
  <div class="col-md-6 text-right">
    {{-- <a href="{{ route($page['storeAction']) }}" class=" btn btn-success {{ $active == 'dosage' ? 'active after' : ''}}" >
     <i class="far fa-save fa-fw"></i> Save
    </a>
    <a href="{{ route($page['cancelAction']) }}" class=" btn btn-danger {{ $active == 'dosage' ? 'active after' : ''}}" >
     <i class="far fa-times fa-fw"></i> Cancel
    </a> --}}
  </div> 
  

  

</div>
<!-- alert if any -->
<div class="row">
    <div class="col-md-12">
        <?php
            if( Session::has('alerts') ) {
                $alert = Session::get('alerts');
                $alert_dismiss = view('layouts.alert-dismiss', ['type' => $alert['type'], 'message' => $alert['msg']]);
                echo $alert_dismiss;
            }
        ?>       
    </div> 
</div>
 <div class="viewData">
<form method="post" action="{{ route($page['storeAction']) }}">
  {{ csrf_field() }}
  <!-- end .actionBar -->
  <div class="viewData">
   <div class="row">
    
    <div class="col-md-12 col-lg-12 col-xl-122">
     <div class="card m-b-30">
      <div class="card-header bg-secondary p-10">
       <h5>
       Shipping Courier Form
       </h5>
      </div>
      <div class="card-body">
       <div class="row h4styled">
        <div class="col-md-6">
         <div class="row m-b-10">
          <div class="col">
           <label>Name</label>
           <input name="name" type="text" value="{{ old('name') }}"
                  class="form-control m-b-10 {{ $errors->has('name') ? ' is-invalid' : '' }}">
           <div class="invalid-feedback">
            {{ $errors->first('name') }}
           </div>         
          </div>
         </div>
        </div>

        <div class="col-md-3">
         <div class="row ">
          <div class="col">
             <label>Is Active ?</label>
             <br>
           <input data-field="active" type="checkbox" data-toggle="toggle" data-off="Inactive" data-on="Active" 
                data-onstyle="success" data-offstyle="primary" data-width="100" name="active" checked />
          </div>

         </div>
        </div>

        
        
       </div>
       
    <div class="row h4styled">
      <div class="col-md-6 text-left">
        <button type="submit" href="{{ route($page['storeAction']) }}" class=" btn btn-success {{ $active == 'dosage' ? 'active after' : ''}}" >
         <i class="far fa-save fa-fw"></i> Save
        </button>
        <a href="{{ route($page['cancelAction']) }}" class=" btn btn-danger {{ $active == 'dosage' ? 'active after' : ''}}" >
         <i class="far fa-times fa-fw"></i> Cancel
        </a>
      </div> 
    </div>
      </div>
     </div>
    </div>
   </div>
  </div>
 </form>
 </div><!-- end .viewData -->
 <div class="rightSide">
  right side
 </div><!-- end .rightSide -->
@endsection
@section('scripts')
<script>
      $(".alert").delay(2000).slideUp(200, function() {
    $(this).alert('close');
}); 

  </script>
@endsection
