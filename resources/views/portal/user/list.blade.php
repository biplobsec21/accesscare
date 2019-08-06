@extends('layouts.portal')

@SetTab('users')

@section('title')
	{{$title}} Users
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
		<a href="{{ route('eac.portal.user.create') }}" class="btn btn-success">
			<i class="fa-fw fas fa-user-plus"></i> Add User
		</a>
		<a href="{{route('eac.portal.user.group.list')}}" class="btn btn-info">
			<i class="fa-fw fas fa-users"></i> User Groups
		</a>
		<a href="{{ route('eac.portal.user.list.merge') }}" class="btn btn-primary">
			<i class="fal fa-code-merge"></i> Merge Users
		</a>
	</div><!-- end .actionBar -->

	<div class="viewData">
		<div class="card mb-1 mb-md-4">
			<div class="table-responsive">
				<table class="table table-sm table-striped table-hover usertable" id="userListTBL">
					<thead>
					<tr>
						<th>Name</th>
						<th>Status</th>
						<th>Email</th>
						<th>Type</th>
						<th>Created At</th>
						<th class="no-sort no-search"></th>
					</tr>
					</thead>
					<tbody></tbody>
					<tfoot>
					<tr>
						<th>Name</th>
						<th>Status</th>
						<th>Email</th>
						<th>Type</th>
						<th>Created At</th>
						<th></th>
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
            let $url = "{{route('eac.portal.user.ajax.list')}}";
			// Data Tables
			$('#userListTBL').initDT({
				ajax: {
					url: $url,
					type: "post",
                    fields: [
                        {
                            data: "full_name",
                            type: "link",
                            href: "view_route"
                        },
                        {
                            data: "status",
                        },
                        {
                            data: "email",
                        },
                        {
                            data: "type-name",
                        },
                        {
                            data: "created_at"
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
