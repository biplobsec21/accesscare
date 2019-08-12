@extends('layouts.portal')
@SetTab('pharmacist')

@section('title')
	 Merge Pharmacist
@endsection

@section('content')
 <div class="titleBar">
  <nav aria-label="breadcrumb">
   <ol class="breadcrumb">
    <li class="breadcrumb-item">
     <a href="{{ route('eac.portal.getDashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
     <a href="{{route('eac.portal.pharmacist.list.all')}}">All Pharmacist</a>
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
 @php
  if(Session::has('alerts_merge')) {
   $alert = Session::get('alerts_merge');
   $alert_dismiss = view('layouts.alert-dismiss', ['type' => $alert['type'], 'message' => $alert['msg']]);
   echo $alert_dismiss;
  }
 @endphp
 <form method="post" action="{{ route('eac.portal.pharmacist.list.mergeselect') }}">
  {{ csrf_field() }}
 	<div class="actionBar">
   <a href="{{ route('eac.portal.pharmacist.list.all') }}" class="btn btn-success">
    <i class="fa-fw  fas fa-user-md"></i> List  Pharmacist
   </a>
   <button class="btn btn-primary" type="submit">
    <i class="far fa-check"></i> Merge Selected
   </button>
 	</div><!-- end .actionBar -->

 	<div class="viewData">
   <div class="card mb-1 mb-md-3">
    <div class="table-responsive">
     <table class="table  table-sm table-striped table-hover" id="pharmacistTBL">
      <thead>
      <tr>
        <th class="no-sort no-search">Primary</th>
        <th class="no-sort no-search">Merge</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Pharmacy</th>
        <th>Created At</th>
      </tr>
      </thead>
      <tbody>
      </tbody>
     </table>
    </div>
  	</div>
 	</div><!-- end .viewData -->
 </form>
@endsection

@section('scripts')
<script type="text/javascript">
     $(document).ready(function () {
   $('#pharmacistTBL tfoot th').each(function () {
    if ($(this).hasClass("no-search"))
     return;
    var title = $(this).text();
    $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" />');
    });

    var dataTable = $('#pharmacistTBL').DataTable({
     "paginationDefault": 10,
      "paginationOptions": [10, 25, 50, 75, 100],
     // "responsive": true,
     // 'order': [[6, 'desc']],
     'order': [[2, 'asc']],
     "ajax": {
     url: "{{route('eac.portal.pharmacist.ajaxlistmerge')}}",
      type: "get"
     },
     "processing": true,
     "serverSide": true,
     columnDefs: [{
     targets: 'no-sort',
     orderable: false,
     }],
     "columns": [
      {"data": "primary", 'name': 'primary'},
      {"data": "merge", 'name': 'merge'},
      {"data": "name", 'name': 'name'},
      {"data": "email", 'name': 'email'},
      {"data": "phone", 'name': 'phone'},
      {"data": "pharmacy", 'name': 'pharmacy'},
      {"data": "created_at",'name': 'created_at'},
     ]
    });

    dataTable.columns().every(function () {
    var that = this;

    $('input', this.footer()).on('keyup change', function () {
      if (that.search() !== this.value) {
       that
       .search(this.value)
       .draw();
      }
     });
    });

    $.fn.dataTable.ext.errMode = function (settings, helpPage, message) {
    swal({
     title: "Oh Snap!",
     text: "Something went wrong on our side. Please try again later.",
     icon: "warning",
    });
    };

   }); // end doc ready
   $(".alert").delay(2000).slideUp(200, function () {
    $(this).alert('close');
   });
</script>
@endsection
