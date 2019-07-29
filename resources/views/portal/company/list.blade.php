@extends('layouts.portal')

@section('title')
	All Companies
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

  @php
  if(Session::has('alerts')) {
   $alert = Session::get('alerts');
   $alert_dismiss = view('layouts.alert-dismiss', ['type' => $alert['type'], 'message' => $alert['msg']]);
   echo $alert_dismiss;
  }
 @endphp

 <div class="actionBar">
  <a href="{{ route('eac.portal.company.create') }}" class="btn btn-success">
   <i class="fa-fw fas fa-building"></i> Add Company
  </a>
	</div><!-- end .actionBar -->

	<div class="viewData">
  <div class="card mb-1 mb-md-4">
   <div class="table-responsive">
    <table class="table table-sm table-striped table-hover companytable" id="companyListTBL">
					<thead>
					<tr>
						<th>Company Name</th>
						<th class="no-search no-sort">Status</th>
						<th class="no-search no-sort">Drugs</th>
						<th class="no-search no-sort">Requests</th>
						<th class="no-search no-sort">Users</th>
						<th>Added</th>
						<th class="no-search no-sort"></th>
					</tr>
					</thead>
					<tbody></tbody>
					<tfoot>
					<tr>
						<th>Company Name</th>
						<th class="no-search no-sort">Status</th>
						<th class="no-search no-sort">Drugs</th>
						<th class="no-search no-sort">Requests</th>
						<th class="no-search no-sort">Users</th>
						<th>Added</th>
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
            let $url = "{{route('eac.portal.company.ajax.list')}}";
            // Data Tables
            $('#companyListTBL').initDT({
                ajax: {
                    url: $url,
                    type: "post"
                },
                order: [[0, 'desc']],
                columns: [
                    "name",
                    "status",
                    "drug_count",
                    "rid_count",
                    "user_count",
                    "created_at",
                    "btns",
                ],
            });
        }); // end doc ready
    </script>
@endsection
