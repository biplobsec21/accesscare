@extends('layouts.portal')

@SetTab('users')

@section('title')
	User Groups
@endsection

@section('content')
	<div class="titleBar">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="{{ route('eac.portal.getDashboard') }}">Dashboard</a>
				</li>
				<li class="breadcrumb-item">
					<a href="{{route('eac.portal.user.list')}}">All Users</a>
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
		<a href="{{ route('eac.portal.user.group.create') }}" class="btn btn-success">
			<i class="fa-fw fas fa-users-class"></i> Add User Group
		</a>
	</div><!-- end .actionBar -->

	<div class="viewData">
		<div class="card mb-1 mb-md-4">
			<div class="table-responsive">
				<table class="table table-sm table-striped table-hover" id="groupTBL">
					<thead>
					<tr>
						<th>Group Name</th>
						<th>Type</th>
						<th>Group Leader</th>
						<th class="no-search no-sort">Members</th>
						<th>Created At</th>
						<th class="no-search no-sort"></th>
					</tr>
					</thead>
					<tbody></tbody>
					<tfoot>
					<tr>
						<th>Group Name</th>
						<th>Type</th>
						<th>Group Leader</th>
						<th class="no-search no-sort">Members</th>
						<th>Created At</th>
						<th class="no-search no-sort"></th>
					</tr>
					</tfoot>
				</table>
			</div>
			{{--@include('include.portal.modals.usergroup.ViewModal')--}}
		</div>
	</div><!-- end .viewData -->
@endsection

@section('scripts')
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script type="text/javascript">
        $(document).ready(function () {
            let $url = "{{route('eac.portal.user.grouplist.ajaxlist')}}";
            // Data Tables
            $('#groupTBL').initDT({
                ajax: {
                    url: $url,
                    type: "post"
                },
                order: [[0, 'asc']],
                columns: [
                    "name",
                    "type",
                    "parent",
                    "members",
                    "created_at",
                    "btns",
                ],
            });
        }); // end doc ready
	</script>
@endsection
