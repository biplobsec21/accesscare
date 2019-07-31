@extends('layouts.portal')

@section('title')
 Edit Dosage Form
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
     <a href="{{ route('eac.portal.settings.manage.drug.dosage.form.index') }}">Dosage Form Manager</a>
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
 <form method="post" action="{{ route($page['updateAction'],request()->route('id')) }}">
  {{ csrf_field() }}
  <div class="row">
   <div class="col-lg-8 col-xl-6">
    @include('include.alerts')
    <div class="actionBar">
     <a href="{{ route($page['cancelAction']) }}" class="btn btn-warning{{ $active == 'dosage' ? ' active after' : ''}}" >
      <i class="far fa-times"></i> Cancel
     </a>
     <button type="submit" href="{{ route($page['storeAction']) }}" class="btn btn-info">
      <i class="far fa-check"></i> Apply Changes
     </button>
     <div class="ml-auto d-flex-inline">
      <button type="button" class="btn btn-danger" onclick="ConfirmDoseDelete('{{$dosage['dosageForm'][0]->id}}')">
       <i class="far fa-ban"></i> Delete
      </button>
     </div>
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
         <label class="d-block">Form Label</label>
         <input name="name" type="text" value="{{ !empty($dosage['dosageForm']) ?  $dosage['dosageForm'][0]->name : old('name') }}" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}">
         <div class="invalid-feedback">
          {{ $errors->first('name') }}
         </div>
        </div>
        <div class="col-sm col-md-5 col-lg-4 mb-3">
         <label class="d-block">Concentration Required</label>
         <select class="form-control" name="concentration_req">
          <option disabled hidden selected value="">-- Select --</option>
          <option value="1" {{ !empty($dosage['dosageForm']) && ($dosage['dosageForm'][0]->concentration_req == '1' ) ? 'selected'  : '' }}>Yes</option>
          <option value="0" {{ !empty($dosage['dosageForm']) && ($dosage['dosageForm'][0]->concentration_req == '0' ) ? 'selected'  : '' }}>No</option>
         </select>
        </div>
       </div><!-- /.row -->
       <div class="row">
        <div class="col-sm mb-3">
         <label class="d-block">Dosage Route</label>
         <select class="form-control {{ $errors->has('route_id') ? ' is-invalid' : '' }}" name="route_id">
          <option disabled hidden selected value="">-- Select --</option>
          @if(!empty($dosage['dosageRoute']))
           @foreach($dosage['dosageRoute'] as $value)
           <option value="{{ $value->id}}" {{ !empty($dosage['dosageForm']) && ($dosage['dosageForm'][0]->route_id == $value->id) ? 'selected'  : '' }} >{{ $value->name}}</option>
           <option value="{{ $value->id }}" {{ !empty($dosage['dosageForm']) && ($dosage['dosageForm'][0]->route_id == $value->id ) ? 'selected'  : '' }}>{{ $value->name}}</option>
           @endforeach
          @endif
         </select>
         <div class="invalid-feedback">
          {{ $errors->first('route_id') }}
         </div>
        </div>
        <div class="col-sm-auto mb-3">
         <label class="d-block">Status</label>
         <input data-field="active" type="checkbox" data-toggle="toggle" data-off="Inactive" data-on="Active" data-onstyle="success" data-offstyle="primary" data-width="100" name="active" {{ !empty($dosage['dosageForm']) && ($dosage['dosageForm'][0]->active == '1' ) ? 'checked'  : '' }} />
        </div>
       </div><!-- /.row -->
       <div class="mb-3">
        <label class="d-block">Description</label>
        <textarea name="desc" class="form-control" rows="3">{{ !empty($dosage['dosageForm']) ?  $dosage['dosageForm'][0]->desc : old('desc') }}</textarea>
       </div>
      </div>
      <div class="card-footer d-flex justify-content-center">
       <button class="btn btn-success" type="submit" href="{{ route($page['storeAction']) }}">
        <i class="far fa-check"></i> Save Changes
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
            $.get("{{route('eac.portal.settings.manage.drug.dosage.formdelete')}}",
              {
               id: param
             });
            // return false;
          // swal.close();

          $(location).attr('href', '{{route('eac.portal.settings.manage.drug.dosage.form.index')}}') // <--- submit form programmatically
        });
      } else {
        swal("Cancelled", "Operation cancelled", "error");
      }
    })
  }
</script>
@endsection
