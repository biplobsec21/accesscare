@extends('layouts.portal')

@section('title')
	Country Manager
@endsection
@section('styles')
	
	<style>
		.v-inactive {
			display: none;
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
			<i class="fas fa-flag-alt"></i>
			Add New
		</a>
		<a href="{{ route('eac.portal.settings.manage.country.indexes') }}" class="btn btn-info">
			<i class="fas fa-arrows-v"></i>
			Manage Indexes
		</a>
		<a href="{{ route('eac.portal.settings.manage.country.logcountry') }}" class="btn btn-secondary">
			<i class="fal fa-key"></i>
			Change Log
		</a>
	</div><!-- end .actionBar -->
	
	<div class="viewData">
  <div class="row"> 
   <div class="order-lg-2 col-lg-2 col-xl-3">
   </div>
   <div class="order-lg-1 col-lg-10 col-xl-9">
    <div class="card mb-1 mb-md-4">
  			<div class="d-flex justify-content-end p-3">
  				<div class="btn-group btn-group-toggle btn-group-sm" data-toggle="buttons">
  					<label class="btn btn-secondary active btn-sm " onclick="showactiveOrAll(1)">
  						<input type="radio" autocomplete="off">
  						View Active
  					</label>
  					<label class="btn btn-secondary   btn-sm" onclick="showactiveOrAll(0)">
  						<input type="radio" autocomplete="off" checked>
  						View All
  					</label>
  				</div>
  			</div>
     <div class="table-responsive">
  				<table class="table table-sm table-striped" id="countryTBL">
  					<thead>
  					<tr>
  						<th>Country Name</th>
  						<th>Abbr.</th>
  						<th>Avg. Days to Deliver</th>
  						<th class="no-search">Active</th>
  						<th>Last Update</th>
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
   let $url = "{{ route('eac.portal.settings.dataTables', 'Country') }}";
   // Data Tables
   $('#countryTBL').initDT({
    ajax: {
     url: $url,
     type: "post",
     fields: [
      {
       data: "name"
      },
      {
       data: "abbr"
      },
      {
       data: "avg_days_to_deliver_drug"
      },
      {
       data: "active"
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
