@extends('layouts.portal')
@SetTab('depots')

@section('title')
	 Merge Dosages Selected
@endsection

@section('content')
 <div class="titleBar">
  <nav aria-label="breadcrumb">
   <ol class="breadcrumb">
    <li class="breadcrumb-item">
     <a href="{{ route('eac.portal.getDashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
     <a href="{{ route($page['listAll']) }}">All Dosages</a>
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
@include('include.alerts')
	<div class="actionBar">
		<a href="{{ url()->previous() }}" class="btn btn-light">
    <i class="far fa-angle-double-left"></i> Go back
    </a>

    <a href="{{ route('eac.portal.settings.manage.drug.dosage.list.merge') }}" class="btn btn-primary">
      <i class="fal fa-code-merge"></i> List Merge Dosages
    </a>
	</div><!-- end .actionBar -->

	<div class="viewData">
  <form method="post" action="{{ route('eac.portal.settings.manage.drug.dosage.list.mergepost') }}">
    {{ csrf_field() }}
   <div class="row col-md-10 col-lg-10 col-xl-10  mb-1 mb-md-3">

    <div class="col-md-6 col-lg-6 col-xl-6">
     <h4 class="p-15  m-0 conf-text strong text-right">
      Primary Record
     </h4>
    </div>

    <div class="col-md-6 col-lg-6 col-xl-6">
     @if($rowsPrimary->count() > 0)
       @foreach($rowsPrimary as $val)
         <div class="card card-body mb-1 pt-2">
          <p class="text-muted m-0">
           <span class="strong">Form:</span> {{ $val->form ? $val->form->name : 'N/A' }}
          </p>
           <p class="text-muted m-0">
           <span class="strong">Unit:</span> {{ $val->unit ? $val->unit->name : 'N/A' }}
          </p>
          <p class="text-muted m-0">
           <span class="strong">Strength:</span>  {{ $val->strength ? $val->strength->name : "N/A"  }}
           
          </p>
          <input type="hidden" name="primary_id" value="{{ $val->id}}">
          </div>
       @endforeach
      @endif
    </div>
   </div>

   <div class="row col-md-10 col-lg-10 col-xl-10  mb-1 mb-md-3">
    
    <div class="col-md-6 col-lg-6 col-xl-6">
     <h4 class="p-15  m-0 conf-text strong text-right">
      Record(s) to be merged
     </h4>
    </div>

    <div class="col-md-6 col-lg-6 col-xl-6">
    
      @if($rowsMerge->count() > 0)
      {{-- {{ $rowsMerge}} --}}
       @foreach($rowsMerge as $val)
         <div class="card card-body mb-1 pt-2">
           <p class="text-muted m-0">
           <span class="strong">Form:</span> {{ $val->form ? $val->form->name : 'N/A' }}
          </p>
           <p class="text-muted m-0">
           <span class="strong">Unit:</span> {{ $val->unit ? $val->unit->name : 'N/A' }}
          </p>
          <p class="text-muted m-0">
           <span class="strong">Strength:</span>  {{ $val->strength ? $val->strength->name : "N/A"  }}
           
          </p>
          <input type="hidden" name="merged_id[]" value="{{ $val->id}}">
          </div>

       @endforeach
      @endif
      
     
    </div>
   </div>
  <div class="col-md-12 col-lg-12 col-xl-12 mb-3">
    
     <h4 class="p-15  m-0 conf-text text-danger">
      By continuing, The merged records will be removed and all records that pertained to the
      merged records will now show The Primary Record Selected. This can not be undone.
     </h4>
    
   </div>

   <div class="ml-auto mr-auto col-sm-10 col-md-8 col-lg-6">
          <button class="btn btn-success btn-block" type="submit">
           <i class="far fa-check"></i> CONTINUE WITH MERGE
          </button>
    </div>
  </form>
	</div><!-- end .viewData -->
@endsection

@section('scripts')
@endsection
