@extends('layouts.portal')
<style>
  .label_required:after { 
   content:"*";
   color:red;
}
</style>
@section('title')
	Create Depot
@endsection

@section('content')
 <div class="titleBar">
  <nav aria-label="breadcrumb">
   <ol class="breadcrumb">
    <li class="breadcrumb-item">
     <a href="{{ route('eac.portal.getDashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
     <a href="{{route('eac.portal.depot.list.all')}}">All Depots</a>
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

	<form method="post" action="{{ route('eac.portal.depot.store') }}">
		{{ csrf_field() }}
		<input type="hidden" name="user_id" value="{{ \Auth::user()->id }}">
  <div class="actionBar">
   <a href="{{ url()->previous() }}" class="btn btn-light">
    <i class="far fa-angle-double-left"></i> Go back
   </a>
  </div><!-- end .actionBar -->
  
  <div class="viewData">
   <div class="row">
    <div class="col-lg-4 col-xl order-lg-2">
     <div class="instructions mb-3">
      Instructions
     </div>
    </div>
    <div class="col-lg-8 col-xl-7 order-lg-1">
     <div class="card card-body">
      <h5 class="text-gold mb-2 mb-xl-4">
       Depot Information
      </h5>
      <div class="mb-3">
       <label class="d-block label_required">Depot Name</label>
       <input type="text" name="depot_name" placeholder="Depot Name" class="form-control" required="required">
      </div>
      <div class="mb-3">
       <label class="d-block label_required">Street Address</label>
       <input type="text" name="depot_addr1" placeholder="Address Line 1" class="form-control mb-1" required="required">
       <input type="text" name="depot_addr2" placeholder="Address Line 2" class="form-control">
      </div>
      <div class="row">
       <div class="col-sm col-md-8 col-lg-12 col-xl-7 mb-3">
        <label class="d-block label_required">Country</label>
        <select name="depot_country_id" class="form-control" required="required" id="country_id">
         <option disabled hidden selected value="">-- Select --</option>
         @foreach($countries as $country)
          <option value="{{ $country->id }}">{{ $country->name }}</option>
         @endforeach
        </select>
       </div>
       <div class="col-sm col-md-4 col-lg-12 col-xl mb-3">
        <label class="d-block label_required">City</label>
       <input type="text" name="depot_city" placeholder="City" class="form-control" required="required">
       </div>
      </div>
      <div class="row mb-3">
       <div class="col-sm col-lg-7 mb-3" >
        <label class="d-block label_required" id="lbl">State</label>
        <select name="depot_state_province" class="form-control" required="required" id="state">
         <option disabled hidden selected value="">-- Select --</option>
         @foreach($states as $state)
          <option value="{{ $state->id }}">{{ $state->name }}</option>
         @endforeach
        </select>
       </div>
       <div class="col-sm col-lg-5 mb-3">
        <label class="d-block label_required">Zip</label>
        <input type="text" name="depot_zip" placeholder="ZIP Code" class="form-control " required="required">
       </div>
      </div><!-- /.row -->
      <div class="row">
       <div class="ml-auto mr-auto col-sm-10 col-md-8 col-lg-6">
        <button class="btn btn-success btn-block" type="submit">
         <i class="far fa-check"></i> Save Depot
        </button>
       </div>
      </div>
     </div>
    </div>
   </div>
  </div><!-- /.viewData -->
	</form>
@endsection

@section('scripts')
<script>
  $("#state").prop('required',false);
  $("#lbl").removeClass('label_required');
  $("#country_id").on('change',function(){
    if($("#country_id option:selected").text() == 'United States'){
      $("#state").prop('required',true);
      $("#lbl").addClass('label_required');
    }else{
      $("#state").prop('required',false);
      $("#lbl").removeClass('label_required');
    }

  });
</script>
@endsection



