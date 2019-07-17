@extends('layouts.portal')

@section('title')
 Edit Country
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
 <form method="post" action="{{ route($page['updateAction'],request()->route('id')) }}">
  {{ csrf_field() }}
  <div class="row">
   <div class="col-lg-10 col-xl-9">
    @php
     if(Session::has('alerts')) {
      $alert = Session::get('alerts');
      $alert_dismiss = view('layouts.alert-dismiss', ['type' => $alert['type'], 'message' => $alert['msg']]);
      echo $alert_dismiss;
     }
    @endphp
    <div class="actionBar">
     <a href="{{ route($page['cancelAction']) }}" class="btn btn-warning{{ $active == 'dosage' ? ' active after' : ''}}" >
      <i class="far fa-times"></i> Cancel
     </a>
     <button type="submit" href="{{ route($page['storeAction']) }}" class="btn btn-info">
      <i class="far fa-check"></i> Apply Changes
     </button>
     <div class="ml-auto d-flex-inline">
      <button type="button" class="btn btn-danger" onclick="ConfirmDoseDelete('{{$rows[0]->id}}')">
       <i class="far fa-ban"></i> Delete
      </button>
     </div>
    </div><!-- end .actionBar -->
   </div>
  </div><!-- /.row-->

  <div class="viewData">
   <div class="row">
    <div class="col-lg-10 col-xl-9">
     <div class="mb-3 mb-xl-4">
      <div class="card card-body mb-0">
       <div class="row">
        <div class="col-sm mb-3">
         <label class="d-block">Country Name</label>
         <input name="name" type="text" value="{{ !empty($rows) ? $rows[0]->name : '' }}" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}">
         <div class="invalid-feedback">
          {{ $errors->first('name') }}
         </div>
        </div>
        <div class="col col-sm-4 mb-3">
         <label class="d-block">Abbreviation</label>
         <input name="abbr" type="text" value="{{ !empty($rows) && old('abbr') ? old('abbr') :  $rows[0]->abbr }}" class="form-control {{ $errors->has('abbr') ? ' is-invalid' : '' }}">
         <div class="invalid-feedback">
          {{ $errors->first('abbr') }}
         </div>
        </div>
        <div class="col col-sm-3 mb-3">
         <label class="d-block">Status</label>
         <input data-field="active" type="checkbox" data-toggle="toggle" data-off="Inactive" data-on="Active" data-onstyle="success" data-offstyle="primary" data-width="100" name="active" {{ !empty($rows) && $rows[0]->active == 1 ? 'checked' : '' }} />
        </div>
       </div><!-- /.row -->
       <div class="row">
        <div class="col-sm mb-3">
         <label class="d-block">Ethics Required</label>
         <select class="form-control" name="ethics_req">
          <option disabled hidden selected value="">-- Select --</option>
          <option value="1" {{ !empty($rows) && $rows[0]->ethics_req == '1' ? 'selected' : '' }}>Yes</option>
          <option value="0" {{ !empty($rows) && $rows[0]->ethics_req == '0' ? 'selected' : '' }}>No</option>
         </select>
        </div>
        <div class="col-sm mb-3">
         <label class="d-block">Avg. Days to Deliver</label>
         <input name="avg_days_to_deliver_drug" type="number" value="{{ $rows[0]->avg_days_to_deliver_drug }}" class="form-control">
        </div>
        {{-- <div class="col-sm-auto mb-3">
         <label class="d-block">Index</label>
         <input name="index" type="number" value="{{ !empty($rows) ? $rows[0]->index : '' }}" class="form-control {{ $errors->has('index') ? ' is-invalid' : '' }}">
         <div class="invalid-feedback">
          {{ $errors->first('index') }}
         </div>
        </div> --}}
        <div class="col-sm mb-3">
         <label class="d-block">HAA Required</label>
         <select class="form-control" name="haa_prereq">
          <option disabled hidden selected value="">-- Select --</option>
          <option value="1" {{ !empty($rows) && $rows[0]->haa_prereq == '1' ? 'selected' : '' }}>Yes</option>
          <option value="0" {{ !empty($rows) && $rows[0]->haa_prereq == '0' ? 'selected' : '' }}>No</option>
         </select>
        </div>
       </div><!-- /.row -->
       <div class="mb-3">
        <label class="d-block">HAA Information</label>
        <!-- <textarea name="haa_info" class="form-control" rows="5">{{ !empty($rows) ? $rows[0]->haa_info : '' }}</textarea> -->
        <textarea class="form-control{{ $errors->has('haa_info') ? ' is-invalid' : '' }} basic-editor" rows="5" id="haa_info" name="haa_info" data-field="text">{{ !empty($rows) ? $rows[0]->haa_info : '' }}</textarea>
       </div>
       <div class="mb-3">
        <label>Notes</label>
        <!-- <textarea name="notes" class="form-control" rows="4">{{ !empty($rows) ? $rows[0]->notes : '' }}</textarea> -->
        <textarea class="form-control{{ $errors->has('notes') ? ' is-invalid' : '' }} basic-editor" rows="4" id="notes" name="notes" data-field="text">{{ !empty($rows) ? $rows[0]->notes : '' }}</textarea>
       </div>
      </div>
      <div class="card-footer d-flex justify-content-center">
       <button class="btn btn-success" type="submit" href="{{ route($page['storeAction']) }}" >
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
            $.get("{{route('eac.portal.settings.manage.countrydelete')}}", 
              {
               id: param
             });
            // return false;
          // swal.close();

          $(location).attr('href', '{{route('eac.portal.settings.manage.country.index')}}') // <--- submit form programmatically
        });
      } else {
        swal("Cancelled", "Operation cancelled", "error");
      }
    })
  }
</script>
@endsection
