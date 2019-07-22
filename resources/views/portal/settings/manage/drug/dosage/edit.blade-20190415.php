@extends('layouts.portal')

@section('title')
Drug Dosage Manager
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
<!--     <button class="btn btn-secondary btn-sm" id="ShowRightSide" href="#">
      Changelog
     </button>-->
    </div>
   </div>
  </div>
</div><!-- end .titleBar -->

<!-- Tool bar -->

<div class="actionBar">

  <div class="col-md-6 text-left">
    <a href="{{ route($page['listAll']) }}" class=" btn btn-success " >
     <i class="fas fa-list-ul fa-fw"></i> List all
    </a>
    <a href="{{ route($page['createButton']) }}" class="btn btn-success">
     <i class="fa-fw far fa-file-medical"></i> Add New
    </a>
    <a href=" {{ route($page['editButton'],request()->route('id'))}}" class="btn btn btn-primary {{ $active == 'edit' ? 'active after' : ''}}">
     <i class="fa-fw far fa-edit"></i> Edit Form
    </a>
    <a href="{{ route($page['logsr']) }}" class="btn btn-secondary btn-sm">
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
 @php
  if(Session::has('alerts')) {
   $alert = Session::get('alerts');
   $alert_dismiss = view('layouts.alert-dismiss', ['type' => $alert['type'], 'message' => $alert['msg']]);
   echo $alert_dismiss;
  }
 @endphp
 <div class="viewData">
<form method="post" action="{{ route($page['updateAction'],request()->route('id')) }}">
  {{ csrf_field() }}
  <!-- end .actionBar -->
  <div class="viewData">
   <div class="row">
    
    <div class="col-md-12 col-lg-12 col-xl-122">
     <div class="card m-b-30">
      <div class="card-header bg-secondary p-10">
       <h5>
       Drug Dosage  Form
       </h5>
      </div>
      <div class="card-body">
       <div class="row h4styled">
        <div class="col-md-12">
         <div class="row m-b-10">
          <div class="col">
           <label>Drug Name</label>
           <select class="custom-select {{ $errors->has('drug_id') ? ' is-invalid' : '' }}" name="drug_id">
            <option value="">--Select Drug--</option>
            @if(!empty($dosage['drug']))
              @foreach($dosage['drug'] as $value)
                <option value="{{ $value->id}}" {{ !empty($rows) && ($rows[0]->drug_id ==  $value->id) ? 'selected'  : '' }}>{{ $value->name}}</option>
                <option value="{{ $value->id }}" {{ !empty($rows) && ($rows[0]->drug_id ==  $value->id ) ? 'selected'  : '' }}>{{ $value->name}}</option>
              @endforeach
            @endif
          </select>
          <div class="invalid-feedback">
              {{ $errors->first('drug_id') }}
          </div>         
          </div>
          {{-- <div class="col">
           <label>Dosage Route</label>
           <select class="custom-select {{ $errors->has('route_id') ? ' is-invalid' : '' }}" name="route_id">
            <option value="">--Select Route--</option>
            @if(!empty($dosage['dosageRoute']))
              @foreach($dosage['dosageRoute'] as $value)
                <option value="{{ $value->id}}" {{ !empty($rows) && ($rows[0]->route_id ==  $value->id) ? 'selected'  : '' }}>{{ $value->name}}</option>
                <option value="{{ $value->id }}" {{ !empty($rows) && ($rows[0]->route_id ==  $value->id) ? 'selected'  : '' }}>{{ $value->name}}</option>
              @endforeach
            @endif
          </select>
          <div class="invalid-feedback">
              {{ $errors->first('route_id') }}
          </div>         
          </div> --}}

          <div class="col">
           <label>Dosage Form</label>
           <select class="custom-select {{ $errors->has('form_id') ? ' is-invalid' : '' }}" name="form_id">
            <option value="">--Select Form--</option>
            @if(!empty($dosage['dosageForm']))
              @foreach($dosage['dosageForm'] as $value)
                <option value="{{ $value->id}}" {{ !empty($rows) && ($rows[0]->form_id ==  $value->id) ? 'selected'  : '' }}>{{ $value->name}}</option>
                <option value="{{ $value->id }}" {{ !empty($rows) && ($rows[0]->form_id ==  $value->id) ? 'selected'  : '' }}>{{ $value->name}}</option>
              @endforeach
            @endif
          </select>
          <div class="invalid-feedback">
              {{ $errors->first('form_id') }}
          </div>         
          </div>

         </div>
        </div>        
        
       </div>
       <div class="row h4styled ">
        
        <div class="col-md-12">
         <div class="row m-b-10">
          <div class="col">
           <label>Dosage Strength</label>
           <select class="custom-select {{ $errors->has('strength_id') ? ' is-invalid' : '' }}" name="strength_id">
            <option value="">--Select Strength--</option>
            @if(!empty($dosage['dosageStrength']))
              @foreach($dosage['dosageStrength'] as $value)
                <option value="{{ $value->id}}" {{ !empty($rows) && ($rows[0]->strength_id ==  $value->id) ? 'selected'  : '' }}>{{ $value->name}}</option>
                <option value="{{ $value->id }}" {{ !empty($rows) && ($rows[0]->strength_id ==  $value->id) ? 'selected'  : '' }}>{{ $value->name}}</option>
              @endforeach
            @endif
          </select>
          <div class="invalid-feedback">
              {{ $errors->first('strength_id') }}
          </div>         
          </div>

          <div class="col">
           <label>Dosage Unit/Concentration</label>
           <select class="custom-select {{ $errors->has('unit_id') ? ' is-invalid' : '' }}" name="unit_id">
            <option value="">--Select Unit--</option>
            @if(!empty($dosage['dosageUnit']))
              @foreach($dosage['dosageUnit'] as $value)
                <option value="{{ $value->id}}" {{ !empty($rows) && ($rows[0]->unit_id ==  $value->id) ? 'selected'  : '' }}>{{ $value->name}}</option>
                <option value="{{ $value->id }}" {{ !empty($rows) && ($rows[0]->unit_id ==  $value->id) ? 'selected'  : '' }}>{{ $value->name}}</option>
              @endforeach
            @endif
          </select>
          <div class="invalid-feedback">
              {{ $errors->first('unit_id') }}
          </div>         
          </div>
          <div class="col">
             <label>Is Active ?</label>
             <br>
           <input data-field="active" type="checkbox" data-toggle="toggle" data-off="Inactive" data-on="Active" 
                data-onstyle="success" data-offstyle="primary" data-width="100" name="active" {{ !empty($rows) && ($rows[0]->active == '1' ) ? 'checked'  : '' }} />
          </div>
          

         </div>
        </div>
      </div>
      <div class="row h4styled">
        
        <div class="col-md-8">
         <div class="row m-b-10">
          <div class="col">
           <label>Temperature</label>
           <input name="temperature" type="text" value="{{ !empty($rows) ? $rows[0]->temperature : '' }}"
                  class="form-control m-b-10 {{ $errors->has('temperature') ? ' is-invalid' : '' }}">
           <div class="invalid-feedback">
            {{ $errors->first('temperature') }}
           </div>         
          </div>

           <div class="col">
           <label>Amount</label>
           <input name="amount" type="number" value="{{ !empty($rows) ? $rows[0]->amount : '' }}"
                  class="form-control m-b-10 {{ $errors->has('amount') ? ' is-invalid' : '' }}">
           <div class="invalid-feedback">
            {{ $errors->first('amount') }}
           </div>         
          </div>
          
         </div>
        </div>
      </div>

    <div class="row h4styled">
      <div class="col-md-6 text-left">

        <button type="submit" href="{{ route($page['storeAction']) }}" class=" btn btn-success " >
         <i class="far fa-save fa-fw"></i> Save
        </button>

        <button type="submit" href="{{ route($page['storeAction']) }}" class=" btn btn-primary" >
         <i class="fas fa-file-check fa-fw"></i> Apply Changes
        </button>

        <a href="{{ route($page['cancelAction']) }}" class=" btn btn-warning {{ $active == 'dosage' ? 'active after' : ''}}" >
         <i class="far fa-arrow-left fa-fw"></i> Cancel
        </a>

    
        <button type="button" class="btn btn-danger " onclick="ConfirmDoseDelete('{{$rows[0]->id}}')">
         <i class="far fa-times fa-fw"></i> Delete
         </button>

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
  function ConfirmDoseDelete(param)
  {
       
    swal({
      title: "Are you sure?",
      text: "Want to delete it",
      icon: "warning",
      buttons: [
        'No, cancel it!',
        'Yes, I am sure!'
      ],
      dangerMode: true,
    }).then(function(isConfirm) {
      if (isConfirm) {
        swal({
          title: 'Successfull!',
          text: 'Content deleted!',
          icon: 'success'
        }).then(function() {
            $.get("{{route('eac.portal.settings.manage.drug.dosagedelete')}}", 
              {
               id: param
             });
            // return false;
          // swal.close();

          $(location).attr('href', '{{route('eac.portal.settings.manage.drug.dosage.index')}}') // <--- submit form programmatically
        });
      } else {
        swal("Cancelled", "Operation cancelled", "error");
      }
    })
  }
</script>
@endsection
