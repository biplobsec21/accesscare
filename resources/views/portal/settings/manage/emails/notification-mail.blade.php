@extends('layouts.portal')

@section('title')
	Email Template Manager
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
 @if(Session::has('alerts')) {
   $alert = Session::get('alerts');
   $alert_dismiss = view('layouts.alert-dismiss', ['type' => $alert['type'], 'message' => $alert['msg']]);
   echo $alert_dismiss;
  }
 @endif
 <div class="actionBar">
		<a href="{{ route('eac.portal.settings.mail.create') }}" class="btn btn-success">
			<i class="far fa-bell"></i> Add New
		</a>
		<a href="{{route('eac.portal.settings.mail.logMail')}}" class="btn btn-secondary">
   <i class="fal fa-key"></i> Change Log
  </a>
	</div><!-- end .actionBar -->
 <div class="viewData">
  <div class="card mb-1 mb-md-4">
   <div class="table-responsive">
    <table class="table table-sm table-striped" id="mailListTBL">
 				<thead>
 				<tr>
 					<th>Name</th>
 					<th>Subject</th>
                    <th>Created At</th>
 					<th class="no-sort"></th>
 				</tr>
 				</thead>
 				<tbody></tbody>
 				<tfoot>
 				<tr>
 					<th>Name</th>
 					<th>Subject</th>
                    <th>Created At</th>
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
            let $url = "{{ route('eac.portal.settings.dataTables', 'Mailer') }}";
            // Data Tables
            $('#mailListTBL').initDT({
                ajax: {
                    url: $url,
                    type: "post",
                    fields: [
                        {
                            data: "name"
                        },
                        {
                            data: "subject"
                        },
                        {
                            data: "created_at"
                        },
                        {
                            data: "manage_route",
                            type: "btn",
                            styling: "btn btn-warning",
                            icon: '<i class="fal fa-fw fa-edit"></i>',
                            text: "Edit"
                        },
                    ],
                },
                order: [[0, 'desc']],
            });
        }); // end doc ready
    </script>
@endsection
