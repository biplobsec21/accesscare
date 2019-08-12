@extends('layouts.portal')

@SetTab('pharmacist')

@section('title')
 All Pharmacists
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
 @php
  if(Session::has('alerts')) {
   $alert = Session::get('alerts');
   $alert_dismiss = view('layouts.alert-dismiss', ['type' => $alert['type'], 'message' => $alert['msg']]);
   echo $alert_dismiss;
  }
 @endphp
 <div class="actionBar">
  <a href="{{ route('eac.portal.pharmacist.create') }}" class="btn btn-success">
   <i class="fas fa-user-md fa-fw"></i>  New Pharmacist
  </a>
  <a href="{{ route('eac.portal.pharmacist.list.merge') }}" class="btn btn-primary">
   <i class="fal fa-code-merge fa-fw"></i> Merge Pharmacist
  </a>
 </div><!-- end .actionBar -->
 
 <div class="viewData">
  <div class="card mb-1 mb-md-4">
   <div class="d-flex justify-content-end p-3">
    <div class="btn-group btn-group-toggle btn-group-sm" data-toggle="buttons">
     <label class="btn btn-secondary btn-sm " onclick="showactiveOrAll(1)">
      <input type="radio"   autocomplete="off"  > View Active
     </label>
     <label class="btn btn-secondary  active btn-sm" onclick="showactiveOrAll(0)">
      <input type="radio"  autocomplete="off" checked> View All
     </label>
    </div>
   </div>
   <div class="table-responsive">
    <table class="table table-sm table-striped table-hover" id="pharmacistTBL">
     <thead>
     <tr>
      <th>Name</th>
      <th class="no-search">Status</th>
      <th>Pharmacy</th>
      <th>Last Update</th>
      <th class="no-sort no-search"></th>
     </tr>
     </thead>
     <tbody>
     </tbody>
    </table>
   </div>
  </div>
 </div><!-- end .viewData -->
@endsection

@section('scripts')
 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
 
 <script type="text/javascript">
  $(document).ready(function () {
   let $url = "{{ route('eac.portal.settings.dataTables', 'Pharmacist') }}";
   // Data Tables
   $('#pharmacistTBL').initDT({
    ajax: {
     url: $url,
     type: "post",
     fields: [
      {
       data: "name"
      },
      {
       data: "active"
      },
      {
       data: "pharmacy-name"
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
