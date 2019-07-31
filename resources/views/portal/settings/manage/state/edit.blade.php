@extends('layouts.portal')

@section('title')
 Edit State
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
     <a href="{{ url('portal/settings/manage/states') }}">State Manager</a>
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
      <button type="button" class="btn btn-danger" onclick="Confirm_Delete('{{$rows->id}}')">
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
         <label class="d-block">State Name</label>
         <input name="name" type="text" value="{{ $rows->name }}" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}">
         <div class="invalid-feedback">
          {{ $errors->first('name') }}
         </div>
        </div>
        <div class="col-sm col-md-5 col-lg-4 mb-3">
         <label class="d-block">Abbreviation</label>
         <input name="abbr" type="text" value="{{ $rows->abbr }}" class="form-control {{ $errors->has('abbr') ? ' is-invalid' : '' }}">
         <div class="invalid-feedback">
          {{ $errors->first('abbr') }}
         </div>
        </div>
       </div><!-- /.row -->
       <div class="row">
        <div class="col-sm mb-3">
         <label class="d-block">Country</label>
         <select class="form-control {{ $errors->has('country_id') ? ' is-invalid' : '' }}" name="country_id">
          <option disabled hidden selected value="">-- Select --</option>
          @foreach($allcountrylist as $cty)
            <option value="{{$cty->id}}" {{ $rows->country_id == $cty->id? 'selected' : ''  }}>{{$cty->name}}</option>
          @endforeach
         </select>
         <div class="invalid-feedback">
          {{ $errors->first('country_id') }}
         </div>
        </div>
        <div class="col-sm-auto mb-3">
         <label class="d-block">Index</label>
         <input name="index" type="number" value="{{ $rows->index }}" class="form-control {{ $errors->has('index') ? ' is-invalid' : '' }}">
         <div class="invalid-feedback">
          {{ $errors->first('index') }}
         </div>
        </div>
        <div class="col-sm-auto mb-3">
         <label class="d-block">Status</label>
        {{--  <input data-field="active" type="checkbox" data-toggle="toggle" data-off="Inactive" data-on="Active" data-onstyle="success" data-offstyle="primary" data-width="100" name="active" checked /> --}}
         <input data-field="active" type="checkbox" data-toggle="toggle" data-off="Inactive" data-on="Active" data-onstyle="success" data-offstyle="primary" data-width="100" name="active" {{ $rows->active == '1' ? 'checked'  : '' }} />
        </div>
       </div><!-- /.row -->
       <div class="mb-3">
        <label class="d-block">Notes</label>
        <textarea name="notes" class="form-control" rows="3">{{ $rows->notes }}</textarea>
       </div>
      </div>
      <div class="card-footer d-flex justify-content-center">
       <button class="btn btn-success{{ $active == 'dosage' ? ' active after' : ''}}" type="submit" href="{{ route($page['storeAction']) }}">
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

  function Confirm_Delete(param)
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
    }).then(function (isConfirm) {
        if (isConfirm) {
            swal({
                title: 'Successfull!',
                text: 'Content deleted!',
                icon: 'success'
            }).then(function () {
                $.get("{{route('eac.portal.settings.manage.statesdelete')}}",
                        {
                            id: param
                        });
                // return false;
                swal.close();

                $(location).attr('href', '{{route('eac.portal.settings.manage.states.index')}}') // <--- submit form programmatically
            });
        } else {
            swal("Cancelled", "Operation cancelled", "error");
        }
    })
}
</script>
@endsection
