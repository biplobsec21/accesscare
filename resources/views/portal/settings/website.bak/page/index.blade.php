@extends('layouts.portal')

@section('title')
 Website Content Manager
@endsection
@section('styles')

  <style>
    .v-inactive{
      display:none ;
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
  <a href="{{ route($page['createButton']) }}" class="btn btn-success">
   <i class="fal fa-columns"></i> Add New Page
  </a>
  {{-- <a href="{{ route($page['logsr']) }}" class="btn btn-secondary"> --}}
  <a href="{{ route($page['logsr']) }}" class="btn btn-secondary">
   <i class="fal fa-key"></i> Change Log
  </a>
 </div><!-- end .actionBar -->

 <div class="viewData">
  <div class="row">
      <div class="col-8">
      
      </div>
  </div>
 </div><!-- end .viewData -->
@endsection

@section('scripts')
@endsection
