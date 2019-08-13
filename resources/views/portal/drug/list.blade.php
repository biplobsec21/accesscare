@extends('layouts.portal')

@section('title')
	{{$title}} Drugs
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
		<a href="{{ route('eac.portal.drug.create') }}" class="btn btn-success">
			<i class="fa-fw fas fa-capsules"></i> Add Drug
		</a>
	</div><!-- end .actionBar -->

	<div class="viewData">
  <div class="row"> 
   <div class="order-lg-2 col-lg-2 col-xl-3">
    <!-- show pie chart displaying companies and # of drugs -->
    <!-- display fulfillment stats -->
   </div>
   <div class="order-lg-1 col-lg-10 col-xl-9">
  		<div class="card mb-1 mb-md-4">
  			<div class="table-responsive">
  				<table class="table table-sm table-striped table-hover drugtable" id="drugListTBL">
  					<thead>
  					<tr>
  						<th>Drug Name</th>
  						<th>Company</th>
  						<th class="">Status</th>
  						<th>Submitted Date</th>
  						<th class="no-search no-sort"></th>
  					</tr>
  					</thead>
  					<tbody></tbody>
  				</table>
  			</div>
  		</div>
   </div>
  </div>
	</div><!-- end .viewData -->
@endsection

@section('scripts')
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

	<script type="text/javascript">
		$(document).ready(function () {
   let $url = "{{route('eac.portal.drug.ajax.list')}}";
			// Data Tables
			$('#drugListTBL').initDT({
				ajax: {
					url: $url,
					type: "post",
     fields: [
      {
       data: "name",
       type: "link",
       href: "view_route"
      },
      {
       data: "company-name",
      },
      {
       data: "status",
      },
      {
       data: "created_at"
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
				order: [[0, 'asc']],
			});
		}); // end doc ready
	</script>
@endsection
