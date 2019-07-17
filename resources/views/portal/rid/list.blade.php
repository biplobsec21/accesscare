@extends('layouts.portal')

@section('title')
	{{$title}} Requests
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
		<a href="{{ route('eac.portal.rid.create') }}" class="btn btn-success">
			<i class="fa-fw fas fa-medkit"></i> Initiate Request
		</a>
	</div><!-- end .actionBar -->

	<div class="viewData">
		<div class="card mb-1 mb-md-4">
			<div class="table-responsive">
				<table class="table table-sm table-striped table-hover" id="ridListTBL">
					<thead>
					<tr>
						<th>Request Date</th>
						<th>RID Number</th>
						<th class="no-search">Visits</th>
						<th class="no-search">Request Status</th>
						<th>Physician</th>
						<th>Drug Requested</th>
						<th class="no-search no-sort"></th>
					</tr>
					</thead>
					<tbody></tbody>
					<tfoot>
					<tr>
						<th>Request Date</th>
						<th>RID Number</th>
						<th class="no-search">Visits</th>
						<th class="no-search">Request Status</th>
						<th>Physician</th>
						<th>Drug Requested</th>
						<th class="no-search no-sort"></th>
					</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div><!-- end .viewData -->
@endsection

@section('scripts')
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

	<script type="text/javascript">
		$(document).ready(function () {
		    let $url = "{{route('eac.portal.rid.ajax.list')}}";
		    if('{{ $_GET['rid_status'] ?? '' }}') {
		        $url += "?rid_status=" + "{{$_GET['rid_status'] ?? null}}";
		    }
			// Data Tables
			$('#ridListTBL').initDT({
				ajax: {
					url: $url,
					type: "post"
				},
				order: [[0, 'desc']],
				columns: [
					"created_at",
					"number",
					"visits",
					"status",
					"physician",
					"drug",
					"btns",
				],
			});
		}); // end doc ready
	</script>
@endsection