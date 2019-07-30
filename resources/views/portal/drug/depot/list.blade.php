@extends('layouts.portal')

@SetTab('depots')

@section('title')
	All Depots
@endsection
@section('styles')
 <style>
  .table thead td > .form-control, .table thead th .form-control, .table tbody td > .form-control, .table tbody th .form-control {
   width: 100%!important;
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
			<i class="fa-fw fas fa-warehouse-alt"></i> Add Depot
		</a>
    <a href="{{ route('eac.portal.depot.list.merge') }}" class="btn btn-primary">
      <i class="fal fa-code-merge"></i> Merge Depots
    </a>
	</div><!-- end .actionBar -->

	<div class="viewData">
    <div class="card mb-1 mb-md-4">
      <div class="table-responsive">
        <table class="table  table-sm table-striped table-hover" id="depotlist">
          <thead>
          <tr>
            <th class="no-search">Name</th>
            <th class="no-sort no-search">Lots</th>
            <th class="no-search">Address</th>
            <th class="no-search">Country</th>
            <th class="no-search">Last Update</th>
            <th class="no-sort no-search"></th>
          </tr>
          </thead>
          <thead>
          <tr class="table-secondary">
            <th>Name</th>
            <th class="no-sort no-search"></th>
            <th>Address</th>
            <th>Country</th>
            <th class="no-search"></th>
            <th class="no-sort no-search"></th>
          </tr>
          </thead>
        </table>
      </div>
    </div>
  </div><!-- end .viewData -->
@endsection

@section('scripts')
<script type="text/javascript">

  $(document).ready(function () {
   $('#depotlist thead th').each(function () {
     if ($(this).hasClass("no-search"))
     return;
     var title = $(this).text();
     $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" />');
   });

   var dataTable = $('#depotlist').DataTable({
     "paginationDefault": 10,
      "paginationOptions": [10, 25, 50, 75, 100],
     // "responsive": true,
     // 'order': [[5, 'desc']],
     'order': [[0, 'asc']],
     "ajax": {
    url: "{{route('eac.portal.depot.ajaxlist')}}",
    type: "get"
     },
     "processing": true,
     "serverSide": true,
     "columns": [
     

     {
       "data": "name",
       "name": "name",
       orderable: true,
       searchable: true
     },
     // {
     //   "data": "route",
     //   "name": "route",
     //   searchable: true
     // },
     {
       "data": "lot",
       "name": "lot",
       orderable: true,
       searchable: true
     },
     {
       "data": "address",
       "name": "address",
        orderable: true,
       searchable: true   
      },
     
     {
       "data": "country",
       "name": "country",
       orderable: true,
       searchable: true
     },
     {
       "data": "created_at",
       "name": "created_at",
       orderable: true,
       searchable: true
     },
     {
       "data": "ops_btns",
       orderable: false,
       searchable: false
     }
     ]
   });

   dataTable.columns().every(function () {
     var that = this;

     $('input', this.footer()).on('keyup change', function () {
     if (that.search() !== this.value) {
       that
         .search(this.value)
         .draw();
     }
     });
   });

   $.fn.dataTable.ext.errMode = function (settings, helpPage, message) {
     swal({
     title: "Oh Snap!",
     text: "Something went wrong on our side. Please try again later.",
     icon: "warning",
     });
   };

  }); // end doc ready
  $(".alert").delay(2000).slideUp(200, function () {
   $(this).alert('close');
  });

  </script>
@endsection
