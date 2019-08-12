@extends('layouts.portal')

@SetTab('user_roles')
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
		<div class="card mb-1 mb-md-4" style="max-width: 991px">
   <form>
    <div class="mb-2 ml-sm-2 mr-sm-2 mt-sm-2 d-flex justify-content-between btn-group-toggle novisual flex-wrap" data-toggle="buttons">
    @if($types->count())	
     @foreach($types as $val)
	     <label class="btn btn-outline-primary m-1 flex-fill {{ Request()->type === $val->id ? 'active' : ''}}" onclick="$(this).find(':radio').prop('checked', true);this.form.submit()">
	      <input type="radio"  name="type" value="{{ $val->id }}" />
	      <span class="small upper h6 m-0 d-flex align-items-center justify-content-center flex-wrap">
	       <span class="d-none d-md-inline">Show</span> <span class="h4 m-0 ml-1 mr-1 poppins">
	       	{{ $val->name === 'Early Access Care' ? 'EAC' : ''  }}
	       	{{ $val->name === 'Pharmaceutical' ? 'Pharma' : ''  }}
	       	{{ $val->name === 'Physician' ? 'Physician' : ''  }}
	       </span> Users
	      </span>
	     </label>
     @endforeach
    @endif   	
     <label class="btn btn-outline-primary m-1 flex-fill {{ Request()->type === 'all' || !Request()->type ? 'active' : ''}}"  onclick="$(this).find(':radio').prop('checked', true);this.form.submit()">
      <input type="radio" name="type" value="all" > 
      <span class="small upper h6 m-0 d-flex align-items-center justify-content-center flex-wrap">
       <span class="d-none d-md-inline">Show</span> <span class="h4 m-0 ml-1 mr-1 poppins">All</span> Users
      </span>
     </label>
    </div>
   </form>
			<div class="table-responsive">
				<table class="table table-sm table-striped">
					<thead>
					<tr>
						<th>Name</th>
						<th>Type</th>
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
							<td class="text-right">
								<a class="btn btn-dark btn-sm" href="{{route('eac.portal.settings.manage.user.role.edit', $role->id)}}">
									<i class="fad fa-edit"></i> Edit
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
			$('.table').DataTable({
    columnDefs: [{
     targets: 'no-sort',
     orderable: false,
    }]
   });
		});
		function formSubmit(input){
			$(this).find(':radio').prop('checked', true);
		}
	</script>
@endsection
