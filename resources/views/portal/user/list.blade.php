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
   <form>
    <div class="mb-2 ml-sm-2 mr-sm-2 mt-sm-2 d-flex justify-content-between btn-group-toggle novisual flex-wrap" data-toggle="buttons">
     <label class="btn btn-outline-primary m-1 flex-fill " onclick="$(this).find(':radio').prop('checked', true);this.form.submit()">
      <input type="radio" name="type" value="aFu1f1fYhq">
      <span class="small upper h6 m-0 d-flex align-items-center justify-content-center flex-wrap">
       <span class="d-none d-md-inline">Show</span> <span class="h4 m-0 ml-1 mr-1 poppins">
        EAC
       </span> Users
      </span>
     </label>
     <label class="btn btn-outline-primary m-1 flex-fill " onclick="$(this).find(':radio').prop('checked', true);this.form.submit()">
      <input type="radio" name="type" value="XdP0OKYrui">
      <span class="small upper h6 m-0 d-flex align-items-center justify-content-center flex-wrap">
       <span class="d-none d-md-inline">Show</span> <span class="h4 m-0 ml-1 mr-1 poppins">         
        Pharma
       </span> Users
      </span>
     </label>
     <label class="btn btn-outline-primary m-1 flex-fill " onclick="$(this).find(':radio').prop('checked', true);this.form.submit()">
      <input type="radio" name="type" value="bTHfo6PeGj">
      <span class="small upper h6 m-0 d-flex align-items-center justify-content-center flex-wrap">
       <span class="d-none d-md-inline">Show</span> <span class="h4 m-0 ml-1 mr-1 poppins">
        Physician
       </span> Users
      </span>
     </label>             
     <label class="btn btn-outline-primary m-1 flex-fill active" onclick="$(this).find(':radio').prop('checked', true);this.form.submit()">
      <input type="radio" name="type" value="all"> 
      <span class="small upper h6 m-0 d-flex align-items-center justify-content-center flex-wrap">
       <span class="d-none d-md-inline">Show</span> <span class="h4 m-0 ml-1 mr-1 poppins">All</span> Users
      </span>
     </label>
    </div>
   </form>
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
