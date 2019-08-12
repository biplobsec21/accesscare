@extends('layouts.portal')
@SetTab('pharmacies')

@section('title')
	 Merge Pharmacy
@endsection

@section('content')
 <div class="titleBar">
  <nav aria-label="breadcrumb">
   <ol class="breadcrumb">
    <li class="breadcrumb-item">
     <a href="{{ route('eac.portal.getDashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
     <a href="{{route('eac.portal.pharmacy.list.all')}}">All Pharmacy</a>
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
 <form method="post" action="{{ route('eac.portal.pharmacy.list.mergeselect') }}">
  {{ csrf_field() }}
 	<div class="actionBar">
   <a href="{{ route('eac.portal.pharmacy.list.all') }}" class="btn btn-success">
    <i class="fa-fw fas fa-warehouse-alt"></i> List Pharmacy
   </a>
   <button class="btn btn-primary" type="submit">
    <i class="far fa-check"></i> Merge Selected
   </button>
 	</div><!-- end .actionBar -->

 	<div class="viewData">
   <div class="card mb-1 mb-md-3">
    <div class="table-responsive">
     <table class="table  table-sm table-striped table-hover" id="pharmacyList">
      <thead>
      <tr>
       <th class="no-sort no-search">Primary</th>
       <th class="no-sort no-search">Merge</th>
       <th>Name</th>
       <th>Physician</th>
       <th>Address</th>
       <th>Country</th>
       <th>Created At</th>
      </tr>
      </thead>
      <tfoot>
      <tr>
       <th class="no-sort no-search">Primary</th>
       <th class="no-sort no-search">Merge</th>
       <th>Name</th>
       <th>Physician</th>
       <th>Address</th>
       <th>Country</th>
       <th>Created At</th>
      </tr>
      </tfoot>
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
     $('#pharmacyList tfoot th').each(function () {
        if ($(this).hasClass("no-search")) {
          $(this).text("");
          return;
        }
        var title = $(this).text();
        $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" />');
      });

      var dataTable = $('#pharmacyList').DataTable({
        "paginationDefault": 10,
        "paginationOptions": [10, 25, 50, 75, 100],
        'order': [[2, 'asc']],
      columnDefs: [{
        targets: 'no-sort',
        orderable: false,
      }],
        "ajax": {
          url: "{{route('eac.portal.pharmacy.ajaxlistmerge')}}",
          type: "post"
        },
        "processing": true,
        "serverSide": true,
        "columns": [
          {"data": "primary", 'name': 'primary'},
          {"data": "merge", 'name': 'merge'},
          {"data": "name", 'name': 'name'},
          {"data": "physician_id", 'name': 'physician_id'},
          {"data": "address"},
          {"data": "country"},
          {"data": "created_at"},

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

      /*$('#drugListTBL tfoot th').each(function () {
       var title = $(this).text();
       $(this).html('<input class="form-control form-control-sm" name="column_search" type="text" placeholder="Search Column" />');
      });*/

      dataTable.columns().every(function () {
        var that = this;
        $('input', this.footer()).on('keyup change', function () {
          if (that.search() !== this.value) {
            that.search(this.value).draw();
          }
        });
      });

      $.fn.dataTable.ext.errMode = function (settings, helpPage, message) {
    swal({
     title: "Oh Snap!",
     text: "There was an error understanding this request. If this issue persists, <a href="mailto:{{site()->email}}">click her</a> to contact us.",
     icon: "warning",
    });
   };
</script>
@endsection
