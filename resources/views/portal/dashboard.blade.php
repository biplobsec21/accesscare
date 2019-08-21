@extends('layouts.portal')

@section('title')
	Dashboard
@endsection

@section('styles')
 <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
 <style>
  [class*=justify-content] > [class*=alert] {
   min-width: 70px;
  }
 </style>
@endsection

@section('content')
	<div class="d-flex justify-content-between align-items-center">
		<h3 class="mb-3 mb-xl-4">
			Welcome to your
			<strong>Dashboard,</strong>
			<span class="text-info">{{\Auth::user()->first_name}}</span>
		</h3>
  <span class="small pt-1 pb-1 pl-3 pr-3 bg-primary text-white d-none d-md-inline">{{\Auth::user()->type->name}} User</span>
	</div>
	@if(\Auth::user()->type->name == 'Physician')
  <div class="row">
   <div class="col-lg-9">
    <div class="dashCards">
   		<div class="row">
   			<div class="col-sm mb-3 mb-xl-5">
   				@include('portal.dashboard.rid-card')
   			</div>
   			<div class="col-sm mb-3 mb-xl-5">
   				@include('portal.dashboard.group-card')
   			</div>
     </div>
    </div>
  		<div class="viewData">
  			@include('portal.dashboard.rid-table')
  		</div>
   </div>
   <div class="col-lg-3">
    {{-- <h4 class="mb-3">Notes &amp; Correspondence</h4> --}}
 			@include('portal.dashboard.notes-card')
   </div>
  </div><!-- /.row -->
	@endif
	@if(\Auth::user()->type->name == 'Pharmaceutical')
  <div class="row">
   <div class="col-lg-9">
    <div class="dashCards">
     <div class="row">
      <div class="col-sm mb-3 mb-xl-5">
   				@include('portal.dashboard.drug-card')
   			</div>
      <div class="col-sm mb-3 mb-xl-5">
       @include('portal.dashboard.group-card')
      </div>
     </div>
    </div>
    <div class="viewData">
     @include('portal.dashboard.drug-table')
    </div>
   </div>
   <div class="col-lg-3">
  		@include('portal.dashboard.notes-card')
  	</div>
  </div><!-- /.row -->
	@endif
	@if(\Auth::user()->type->name == 'Early Access Care')
  <div class="dashCards">
 		<div class="row">
 			<div class="col-sm-6 col-xl mb-3 mb-xl-5">
 				@include('portal.dashboard.rid-card')
 			</div>
 			<div class="col-sm-6 col-xl mb-3 mb-xl-5">
 				@include('portal.dashboard.drug-card')
 			</div>
 			<div class="col-sm-6 col-xl mb-3 mb-xl-5">
 				@include('portal.dashboard.user-card')
 			</div>
    <div class="col-sm-6 col-xl mb-3 mb-xl-5">
     @include('portal.dashboard.group-card')
    </div>
 		</div>
  </div>
  <div class="row">
   <div class="col-lg-9">
  		<div class="viewData mt-0">
     <div class="table-responsive">
      @include('portal.dashboard.shipment-table')
     </div>
  		</div>
   </div>
   <div class="col-lg-3">
    @include('portal.dashboard.notes-card')
   </div>
  </div><!-- /.row -->
	@endif
@endsection

@section('scripts')
 <script type="text/javascript">
  $(document).ready(function () {
   function ridShipFormat($d) {
    return '<table>' +
     '<tr>' +
     '<td>Delivery By Date:</td>' +
     '<td>' + $d.deliver_by_date + '</td>' +
     '</tr>' +
     '<tr>' +
     '<td>Destination:</td>' +
     '<td>' + $d.destination + '</td>' +
     '</tr>' +
     '</table>';
   }
   
   let $url = "{{route('eac.portal.shipment.list')}}";
   // Data Tables
   let dataTable = $('#shipmentListTBL').initDT({
    ajax: {
     url: $url,
     type: "post",
     fields: [
      {
       data: "created_at",
      },
      {
       data: "rid-number",
       type: "link",
       href: "rid-view_route"
      },
      {
       data: "rid-drug-name"
      },
      {
       data: "ship_by_date",
      },
      {
       data: "rid-physician-full_name",
       type: "link",
       href: "rid-physician-view_route"
      },
      {
       data: "view_route",
       type: "btn",
       classes: "btn btn-primary btn-sm",
       icon: '<i class="far fa-sm fa-search"></i>',
       text: "View"
      },
     ],
    },
    order: [[1, 'asc']],
    dom: 't<"d-flex justify-content-between flex-wrap small p-2"ilp>'
   });
   $('#shipmentListTBL').on('click', 'td.details-control', function () {
    var tr = $(this).closest('tr');
    var row = dataTable.row(tr);

    if (row.child.isShown()) {
     // This row is already open - close it
     row.child.hide();
     tr.removeClass('shown');
    } else {
     // Open this row
     row.child(ridShipFormat(row.data())).show();
     tr.addClass('shown');
    }
   });
   $('.notesTbl').DataTable({
    "stateSave": true,
    "info": false,
    "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
    "searching": false,
    "order": [[0, 'desc']],
    "dom": 't<"d-flex justify-content-between flex-wrap small p-2"lp>'
   });
  });
</script>
@append
