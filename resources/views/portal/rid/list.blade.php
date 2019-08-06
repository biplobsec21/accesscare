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
			// Data Tables
			$('#ridListTBL').initDT({
				ajax: {
					url: $url,
					type: "post",
                    fields: [
                        {
                            data: "created_at",
                        },
                        {
                            data: "number",
                            type: "link",
                            href: "view_route"
                        },
                        {
                            data: "visits",
                            type: "count"
                        },
                        {
                            data: "status-name",
                        },
                        {
                            data: "physician-full_name",
                            type: "link",
                            href: "physician-view_route"
                        },
                        {
                            data: "drug-name"
                        },
                        {
                            data: "view_route",
                            type: "btn",
                            classes: "btn btn-info",
                            icon: '<i class="fal fa-fw fa-eye"></i>',
                            text: "View"
                        },
                    ],
				},
				order: [[0, 'asc']],
			});
		}); // end doc ready
	</script>
@endsection
