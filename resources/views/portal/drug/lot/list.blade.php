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
				<table class="table  table-sm table-striped table-hover" id="lotlist">
					<thead>
					<tr>
						<th>Lot Number</th>
						<th>Drug</th>
						<th>Dosage</th>
						<th>Depot</th>
						<th class="no-sort no-search">Stock</th>
						<th>Last Update</th>
						<th class="no-sort no-search"></th>
					</tr>
					</thead>
					<tfoot>
					<tr>
						<th>Lot Number</th>
						<th>Drug</th>
						<th>Dosage</th>
						<th>Depot</th>
						<th class="no-sort no-search">Stock</th>
						<th class="">Last Update</th>
						<th class="no-sort no-search"></th>
					</tr>
					</tfoot>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div><!-- end .viewData -->
@endsection

@section('scripts')
<script type="text/javascript">

  $(document).ready(function () {
   $('#lotlist tfoot th').each(function () {
     if ($(this).hasClass("no-search"))
     return;
     var title = $(this).text();
     $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" />');
   });

   var dataTable = $('#lotlist').DataTable({
     "paginationDefault": 10,
      "paginationOptions": [10, 25, 50, 75, 100],
     // "responsive": true,
     'order': [[0, 'asc']],
     "ajax": {
		url: "{{route('eac.portal.lot.ajaxlist')}}",
		type: "get"
     },
     "processing": true,
     "serverSide": true,
     "columns": [
     

     {
       "data": "number",
       "name": "number",
       searchable: true
     },
     // {
     //   "data": "route",
     //   "name": "route",
     //   searchable: true
     // },
     {
       "data": "drug",
       "name": "drug",
       searchable: true
     },
     {
       "data": "dosage",
       "name": "dosage",
        orderable: true,
       searchable: true   
      },
     
     {
       "data": "depot",
       "name": "depot",
       orderable: false,
       searchable: true
     },
     {
       "data": "stock",
       "name": "stock",
       orderable: false,
       searchable: false
     },
     {
       "data": "created_date",
       "name": "created_date",
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
