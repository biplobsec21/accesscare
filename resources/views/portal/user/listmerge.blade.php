@extends('layouts.portal')

@SetTab('users')

@section('title')
  Merge Users
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
<form method="post" action="{{ route('eac.portal.user.mergeselect') }}">
  {{ csrf_field() }}
  <div class="actionBar">
    <a href="{{ route("eac.portal.user.list") }}" class="btn btn-light">
    User List
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
        <table class="table table-sm table-striped table-hover usertable" id="userListTBL">
          <thead>
          <tr>
            <th class="no-search no-sort">Primary</th>
            <th class="no-search no-sort">Merge</th>
            <th>Full Name</th>
            <th>Status</th>
            <th>Email</th>
            <th>User Type</th>
          </tr>
          </thead>
          <tbody></tbody>
          <tfoot>
          <tr>
            <th class="no-search no-sort">Primary</th>
            <th class="no-search no-sort">Merge</th>
            <th>Full Name</th>
            <th>Status</th>
            <th>Email</th>
            <th>User Type</th>
          </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div><!-- end .viewData -->
</form>
@endsection

@section('scripts')
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script type="text/javascript">
    // Data Tables
    $(document).ready(function () {
      $('#userListTBL tfoot th').each(function () {
        if ($(this).hasClass("no-search"))
          return;
        var title = $(this).text();
        $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" />');
      });
      
      var url = "{{route('eac.portal.user.ajaxlistmerge')}}";
      var dataTable = $('#userListTBL').DataTable({
        "paginationDefault": 10,
        "paginationOptions": [10, 25, 50, 75, 100],
        // "responsive": true,
        'order': [[2, 'asc']],
         columnDefs: [{
        targets: 'no-sort',
        orderable: false,
      }],
        "ajax": {
          url: url,
          type: "post"
        },
        "processing": true,
        "serverSide": true,
        "columns": [
          {"data": "primary", 'name': 'primary'},

          {"data": "merge", 'name': 'merge'},
          {
            "data": "name",
            'name': 'name',
            searchable: true
          },

          {
            "data": "status",
            searchable: true
          },
          {
            "data": "email"
          },
          {
            "data": "user_type",
            searchable: true
          },
          // {
          //  "data": "created_at",
          // },
          
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
