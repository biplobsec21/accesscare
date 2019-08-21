@extends('layouts.portal')

@SetTab('lots')

@section('title')
 All Lots
@endsection

@section('content')
 <div class="titleBar">
  <nav aria-label="breadcrumb">
   <ol class="breadcrumb">
    <li class="breadcrumb-item">
     <a href="{{ route('eac.portal.getDashboard') }}">Dashboard</a>
    </li>
    {{-- <li class="breadcrumb-item">
     <a href="{{route('eac.portal.depot.list.all')}}">All Depots</a>
    </li> --}}
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
  <a href="{{ route('eac.portal.lot.create') }}" class="btn btn-success">
   <i class="fa-fw fas fa-container-storage"></i> Add Lot
  </a>
  <a href="{{ route('eac.portal.lot.list.merge') }}" class="btn btn-primary">
   <i class="fal fa-code-merge"></i> Merge Lot
  </a>
 </div><!-- end .actionBar -->
 @php
  if(Session::has('alerts')) {
   $alert = Session::get('alerts');
   $alert_dismiss = view('layouts.alert-dismiss', ['type' => $alert['type'], 'message' => $alert['msg']]);
   echo $alert_dismiss;
  }
 @endphp
 <div class="viewData">
  <div class="card mb-1 mb-md-4">
   <div class="table-responsive">
    <table class="table  table-sm table-striped table-hover" id="lotTBL">
     <thead>
     <tr>
      <th>Lot Number</th>
      <th>Drug</th>
      <th>Dosage</th>
      <th>Depot</th>
      <th class="no-sort no-search">Stock</th>
      <th>Created At</th>
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
   let $url = "{{ route('eac.portal.settings.dataTables', 'DrugLot') }}";
   // Data Tables
   $('#lotTBL').initDT({
    ajax: {
     url: $url,
     type: "post",
     fields: [
      {
       data: "number"
      },
      {
       data: "dosage-component-drug-name"
      },
      {
       data: "dosage-display_short"
      },
      {
       data: "depot-name"
      },
      {
       data: "stock"
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
