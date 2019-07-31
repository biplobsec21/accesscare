@extends('layouts.portal')

@section('title')
	Role Manager
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
		<a href="{{route('eac.portal.settings.manage.user.role.create')}}" class="btn btn-success">
			<i class="fal fa-lock-alt"></i> Add Role
		</a>
	</div><!-- end .actionBar -->
	<div class="viewData">
  <div class="d-flex justify-content-between">
   <a href="#" class="btn btn-outline-dark">
    Physician
   </a>
   <a href="#" class="btn btn-outline-dark">
    Pharmaceutical
   </a>
   <a href="#" class="btn btn-outline-dark">
    EAC
   </a>
  </div>
		<div class="card mb-1 mb-md-4" style="max-width: 991px">
			<div class="table-responsive">
				<table class="table table-sm table-striped">
					<thead>
					<tr>
						<th>
							Name
						</th>
						<th>
							Type
						</th>
						<th></th>
						<th class="no-sort"></th>
					</tr>
					</thead>
					<tbody>
					@foreach($roles->get()->sortBy('name') as $role)
						<tr data-id="{{$role->id}}">
							<td>
								{{$role->name}}
							</td>
							<td>
								{{$role->type->name}}
							</td>
							<td>
								<span class="badge badge-mw badge-outline-info"
									  title="{{json_encode($role->areas()->toArray())}}">
									{{$role->areas()->count()}}
								</span>
							</td>
							<td class="text-center">
								<a class="btn btn-dark btn-sm" href="{{route('eac.portal.settings.manage.user.role.edit', $role->id)}}">
									<i class="fas fa-key"></i> Manage Permissions
								</a>
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
		</div><!-- /.card -->
	</div><!-- end .viewData -->
@endsection
@section('scripts')
	<script>
		$(document).ready(function(){
			$('.table').DataTable();
		});
	</script>
@endsection
