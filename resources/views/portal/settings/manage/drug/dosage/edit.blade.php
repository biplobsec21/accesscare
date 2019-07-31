@extends('layouts.portal')

@section('title')
 Edit Dosage
@endsection
@section('styles')
 <style>
  @media screen and (min-width: 1200px) {
   :root {
    --leftCol: 230px;
    --rightCol: 750px;
   }
   .actionBar, .viewData {
    max-width: calc(var(--leftCol) + var(--rightCol));
   }
   .viewData .row.thisone > [class*=col]:first-child {
    max-width: var(--leftCol);
    min-width: var(--leftCol);
   }
   .viewData .row.thisone > [class*=col]:last-child {
    max-width: var(--rightCol);
    min-width: var(--rightCol);
   }
  }
 </style>
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
 <form method="post" action="{{ route($page['updateAction'],request()->route('id')) }}">
  {{ csrf_field() }}
  @include('include.alerts')
  <div class="viewData">
   <div class="bg-dark text-white pt-2 pb-2 pr-3 pl-3 d-flex justify-content-between">
    <a href="{{ route('eac.portal.settings.manage.drug.dosage.index') }}" class="btn btn-secondary">
     View Drug Dosage Manager
    </a>
    <div>
     <a href="{{ route($page['cancelAction']) }}" class="btn btn-warning{{ $active == 'dosage' ? ' active after' : ''}}" >
      <i class="far fa-times"></i> Cancel
     </a>
     <button type="submit" href="{{ route($page['storeAction']) }}" class="btn btn-info">
      <i class="far fa-check"></i> Apply Changes
     </button>
     <button type="button" class="btn btn-danger" onclick="ConfirmDoseDelete('{{$rows[0]->id}}')">
      <i class="far fa-ban"></i> Delete
     </button>
    </div>
   </div>
   <div class="row thisone m-0 mb-xl-5">
    <div class="col-sm-3 col-xl-auto p-0 mb-2 mb-sm-0">
     <div class="wizardSteps symbols nav flex-row flex-sm-column mt-sm-3" id="tab" role="tablist"
       aria-orientation="vertical">
      <a class="nav-link complete active" id="xdetails-tab" data-toggle="pill" href="#xdetails" role="tab"
         aria-controls="xdetails" aria-selected="true">
       <span>Details</span>
      </a>
     </div>
    </div>
    <div class="col-sm-9 col-lg-7 col-xl p-0">
     <div class="tab-content wizardContent" id="tabContent">
      <div class="alert-light text-dark pt-3 pl-3 pr-3">
       sticky
      </div>
      <div class="tab-pane fade show active" id="xdetails" role="tabpanel" aria-labelledby="xdetails-tab">
       <div class="card card-body mb-0">
        <div class="row">
         <div class="col-sm mb-3">
          <label class="d-block">Relevant Age Group</label>
          <select class="form-control {{ $errors->has('strength_id') ? ' is-invalid' : '' }}" name="strength_id">
           <option disabled hidden selected value="">-- Select --</option>
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
         <div class="col col-sm-4 mb-3">
          <label class="d-block">Dosage Form</label>
          <select class="form-control {{ $errors->has('form_id') ? ' is-invalid' : '' }}" name="form_id">
           <option disabled hidden selected value="">-- Select --</option>
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
         <div class="col col-sm-3 mb-3">
          <label class="d-block">Status</label>
          <input data-field="active" type="checkbox" data-toggle="toggle" data-off="Inactive" data-on="Active" data-onstyle="success" data-offstyle="secondary" data-width="100" name="active" {{ !empty($rows) && ($rows[0]->active == '1' ) ? 'checked'  : '' }} />
         </div>
        </div><!-- /.row -->
        <div class="row">
         <div class="col col-sm-3 mb-3">
          <label class="d-block">Dose Strength</label>
          <input name="amount" type="number" value="{{ !empty($rows) ? $rows[0]->amount : '' }}" class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}">
          <div class="invalid-feedback">
           {{ $errors->first('amount') }}
          </div>
         </div>
         <div class="col mb-3">
          <label class="d-block">Unit/Concentration</label>
          <select class="form-control {{ $errors->has('unit_id') ? ' is-invalid' : '' }}" name="unit_id">
           <option disabled hidden selected value="">-- Select --</option>
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
         <div class="col-sm mb-3">
          <label class="d-block">Temperature</label>
          <input name="temperature" type="text" value="{{ !empty($rows) ? $rows[0]->temperature : '' }}" class="form-control{{ $errors->has('temperature') ? ' is-invalid' : '' }}">
          <div class="invalid-feedback">
           {{ $errors->first('temperature') }}
          </div>
         </div>
        </div><!-- /.row -->
       </div>
       <div class="card-footer d-flex justify-content-center">
        <button class="btn btn-success" type="submit" href="{{ route($page['storeAction']) }}">
         <i class="far fa-check"></i> Save Changes
        </button>
       </div>
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
