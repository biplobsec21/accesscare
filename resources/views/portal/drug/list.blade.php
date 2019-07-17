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
		<div class="card mb-1 mb-md-4">
			<div class="table-responsive">
				<table class="table table-sm table-striped table-hover drugtable" id="drugListTBL">
					<thead>
					<tr>
						<th>Drug Name</th>
						<th>Company</th>
						<th class="no-search">Status</th>
						<th>Submitted Date</th>
						<th class="no-search no-sort"></th>
					</tr>
					</thead>
					<tbody></tbody>
					<tfoot>
					<tr>
						<th>Drug Name</th>
						<th>Company</th>
						<th class="no-search">Status</th>
						<th>Submitted Date</th>
						<th class="no-search"></th>
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
            let $url = "{{route('eac.portal.drug.ajax.list')}}";
            if('{{$_GET['drug_status'] ?? '' }}') {
                $url += "?drug_status=" + "{{$_GET['drug_status'] ?? null}}";
            }
			// Data Tables
			$('#drugListTBL').initDT({
				ajax: {
					url: $url,
					type: "post"
				},
				order: [[0, 'asc']],
				columns: [
					"drug_name",
					"company_name",
					"status",
					"created_at",
					"btns",
				],
			});
		}); // end doc ready
	</script>
@endsection
