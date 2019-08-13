@extends('layouts.portal')

@SetTab('depots')

@section('title')
 All Depots
@endsection
@section('styles')
 <style>
  .table thead td > .form-control, .table thead th .form-control, .table tbody td > .form-control, .table tbody th .form-control {
   width: 100% !important;
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
    <li class="breadcrumb-item active" aria-current="page">
     @yield('title')
    </li>
   </ol>
  </nav>
  <h2 class="m-0">
   @yield('title')
  </h2>
 </div><!-- end .titleBar -->
 
 <div class="actionBar">
  <a href="{{ route('eac.portal.depot.create') }}" class="btn btn-success">
   <i class="fa-fw fas fa-warehouse-alt"></i>
   Add Depot
  </a>
  <a href="{{ route('eac.portal.depot.list.merge') }}" class="btn btn-primary">
   <i class="fal fa-code-merge"></i>
   Merge Depots
  </a>
 </div><!-- end .actionBar -->
 
 <div class="viewData">
  <div class="card mb-1 mb-md-4">
   <div class="table-responsive">
    <table class="table  table-sm table-striped table-hover align-top " id="depotTBL">
     <thead>
     <tr>
      <th>Name</th>
      <th class="no-sort no-search">Lots</th>
      <th>Address</th>
      <th>Country</th>
      <th class="no-search">Created At</th>
      <th class="no-sort no-search"></th>
     </tr>
     </thead>
     <tbody></tbody>
    </table>
   </div>
  </div>
 </div><!-- end .viewData -->
@endsection

@section('scripts')
 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
 
 <script type="text/javascript">
  $(document).ready(function () {
   let $url = "{{ route('eac.portal.settings.dataTables', 'Depot') }}";
   // Data Tables
   $('#depotTBL').initDT({
    ajax: {
     url: $url,
     type: "post",
     fields: [
      {
       data: "name"
      },
      {
       data: "lots",
       type: "count",
      },
      {
       data: "address-display_short"
      },
      {
       data: "address-country-name"
      },
      {
       data: "created_at"
      },
      {
       data: "edit_route",
       type: "btn",
       classes: "btn btn-dark btn-sm",
       icon: '<i class="fad fa-edit"></i>',
       text: "Edit"
      },
     ],
    },
    order: [[0, 'asc']],
   });
  }); // end doc ready
 </script>
@endsection
