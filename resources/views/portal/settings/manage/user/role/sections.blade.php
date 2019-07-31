@extends('layouts.portal')

@section('title')
	Manage Accessible Sections
@endsection

@section('styles')
	<style>
		#manage-role-table {
			width: 100%
		}

		#manage-role-table td {
			padding: 0;
		}

		#manage-role-table td div.checkmark {
			cursor: pointer;
			height: 35px;
			margin-top: -42px;
		}

		#manage-role-table input:checked ~ div.checkmark {
			background-color: #2196F3;
		}

		.table-container {
			padding: 0 8px;
		}

		.table-container > * {
			margin: 8px 0;
		}

		#manage-role-table td input {
			position: relative;
			opacity: 0;
			cursor: pointer;
			height: 35px;
			width: 100%;
		}


		#manage-role-table th {
			cursor: pointer;
			text-transform: uppercase;
			color: #268cd5;
			height: 35px;
			font-weight: 600;
			width: 20%;
			letter-spacing: 1px;
			border-bottom: 0;
			font-size: .7rem;
			text-align: center;
			background-color: rgb(230, 230, 230);
		}

		#manage-role-table thead th.table-title {
			text-transform: unset;
			color: black;
			font-weight: 400;
			line-height: inherit;
			font-size: 1.25rem;
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
				<li class="breadcrumb-item">
					<a href="{{ route('eac.portal.settings.manage.user.role') }}">Role Manager</a>
				</li>
				<li class="breadcrumb-item">
					<a href="{{ route('eac.portal.settings.manage.role.permission.areas', $role->id) }}">Manage Accessible Areas</a>
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
	<div class="viewData">
		<div class="card mb-1 mb-md-4" style="max-width: 991px">
			<div class="card-header">{{ucwords($role->type->name) . ': ' . ucwords($role->name)}}</div>
			<form method="post" action="{{ route('eac.portal.settings.manage.user.role.save') }}">
				@csrf
				<div class="table-container">
					@foreach($permissions as $area => $sections)
						<table class="table-bordered" id="manage-role-table">
							<thead>
							<tr>
								<th class="table-title">{{ucfirst($area)}}</th>
								<th data-col-control="view">View</th>
								<th data-col-control="update">Update</th>
								<th data-col-control="create">Create</th>
								<th data-col-control="delete">Delete</th>
							</tr>
							</thead>
							<tbody>
							@foreach($sections as $section => $values)
								<tr>
									<th data-row-control="{{$section}}">{{ucfirst($section)}}</th>
									<td>
										<input name="level[{{$area}}][{{$section}}][view]"
											   data-row="{{$section}}" data-col="view" value="1"
											   type="checkbox" {{$role->can([$area, $section, 'view']) ? 'checked' : ''}}>
										<div class="checkmark"></div>
									</td>
									<td>
										<input name="level[{{$area}}][{{$section}}][update]"
											   data-row="{{$section}}" data-col="update" value="1"
											   type="checkbox" {{$role->can([$area, $section, 'update']) ? 'checked' : ''}}>
										<div class="checkmark"></div>
									</td>
									<td>
										<input name="level[{{$area}}][{{$section}}][create]"
											   data-row="{{$section}}" data-col="create" value="1"
											   type="checkbox" {{$role->can([$area, $section, 'create']) ? 'checked' : ''}}>
										<div class="checkmark"></div>
									</td>
									<td>
										<input name="level[{{$area}}][{{$section}}][delete]"
											   data-row="{{$section}}" data-col="delete" value="1"
											   type="checkbox" {{$role->can([$area, $section, 'delete']) ? 'checked' : ''}}>
										<div class="checkmark"></div>
									</td>
								</tr>
							@endforeach
							</tbody>
						</table>
					@endforeach
				</div>
				<input type="hidden" name="role_id" value="{{$role->id}}"/>
				<button type="submit" class="btn btn-success w-100">Save</button>
			</form>
		</div><!-- /.card -->
	</div><!-- end .viewData -->
@endsection
@section('scripts')
	<script>
		$(document).on('click', '#manage-role-table th', function (e) {

			if ($(this).data('row-control')) {
				let boxes = $(this).parents('table').find('td input[data-row="' + $(this).data('row-control') + '"]');
				let boxCount = boxes.length;
				let checkCount = boxes.filter(':checked').length;

				if (checkCount === boxCount || checkCount === 0)
					boxes.click();
				else
					$(boxes).each(function () {
						if (!this.checked)
							$(this).click();
					});
			}

			if ($(this).data('col-control')) {
				let boxes = $(this).parents('table').find('td input[data-col="' + $(this).data('col-control') + '"]');
				let boxCount = boxes.length;
				let checkCount = boxes.filter(':checked').length;

				if (checkCount === boxCount || checkCount === 0)
					boxes.click();
				else
					$(boxes).each(function () {
						if (!this.checked)
							$(this).click();
					});
			}
		});
	</script>
@endsection
