@extends('layouts.portal')

@SetTab('lots')

@section('title')
 Merge Lots
@endsection

@section('content')
 <div class="titleBar">
  <nav aria-label="breadcrumb">
   <ol class="breadcrumb">
    <li class="breadcrumb-item">
     <a href="{{ route('eac.portal.getDashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
     <a href="{{route('eac.portal.lot.list.all')}}">All Lots</a>
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
 <form method="post" action="{{ route('eac.portal.lot.mergeselect') }}">
  {{ csrf_field() }}

  <div class="actionBar">
   <a href="{{ route('eac.portal.lot.list.all') }}" class="btn btn-success">
    <i class="fa-fw fas fa-container-storage"></i> All Lots
   </a>
   <button class="btn btn-primary" type="submit">
    <i class="far fa-check"></i> Merge Selected
   </button>
  </div><!-- end .actionBar -->
  @include('include.alerts')
  @php
   if(Session::has('alerts_merge')) {
   $alert = Session::get('alerts_merge');
   $alert_dismiss = view('layouts.alert-dismiss', ['type' => $alert['type'], 'message' => $alert['msg']]);
   echo $alert_dismiss;
   }
  @endphp
  <div class="viewData">
   <div class="card mb-1 mb-md-4">
    <div class="table-responsive">
     <table class="table table-sm table-striped table-hover" id="lotlist">
      <thead>
      <tr>
       <th class="no-sort no-search">Primary</th>
       <th class="no-sort no-search">Merge</th>
       <th>Lot Number</th>
       <th>Drug</th>
       <th>Dosage</th>
       <th>Depot</th>
       <th class="no-sort no-search">Stock</th>
       <th>Created At</th>
      </tr>
      </thead>
      <tfoot>
      <tr>
       <th class="no-sort no-search">Primary</th>
       <th class="no-sort no-search">Merge</th>
       <th>Lot Number</th>
       <th>Drug</th>
       <th>Dosage</th>
       <th>Depot</th>
       <th class="no-sort no-search">Stock</th>
       <th class="">Created At</th>
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
  // Data Tables
  $(document).ready(function () {
   $('#lotlist tfoot th').each(function () {
    if ($(this).hasClass("no-search")) {
     $(this).text("");
     return;
    }
    var title = $(this).text();
    $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" />');
   });

   var dataTable = $('#lotlist').DataTable({
    "paginationDefault": 10,
    "paginationOptions": [10, 25, 50, 75, 100],
    'order': [[5, 'desc']],
   columnDefs: [{
    targets: 'no-sort',
    orderable: false,
   }],
    "ajax": {
     url: "{{route('eac.portal.lot.ajaxlistmerge')}}",
     type: "get"
    },
    "processing": true,
    "serverSide": true,
    "columns": [
     {"data": "primary", 'name': 'primary'},
     {"data": "merge", 'name': 'merge'},
     {"data": "number", 'name': 'number'},
     {"data": "drug", 'name': 'drug'},
     {"data": "dosage"},
     {"data": "depot"},
     {"data": "stock"},
     {"data": "created_date"},

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
     text: "Something went wrong on our side. Please try again later.",
     icon: "warning",
    });
   };

  }); // end doc ready
 </script>
@endsection
