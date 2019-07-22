@extends('layouts.portal')

@section('title')
 Drug Dosage Manager
@endsection
@section('styles')

  <style>
    .v-inactive{
      display:none ;
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
  <a href="{{ route($page['createButton']) }}" class="btn btn-success">
   <i class="fal fa-prescription"></i> Add New
  </a>
  <a href="{{ route($page['logsr']) }}" class="btn btn-secondary">
   <i class="fal fa-key"></i> Change Log
  </a>
  <a href="{{ route('eac.portal.settings.manage.drug.dosage.list.merge') }}" class="btn btn-primary">
      <i class="fal fa-code-merge"></i> Merge Dosages
    </a>
 </div><!-- end .actionBar -->

 <div class="viewData">
  <div class="card mb-1 mb-md-4">
   <div class="d-flex justify-content-end p-3">
    <div class="btn-group btn-group-toggle btn-group-sm" data-toggle="buttons">
     <label class="btn btn-secondary active btn-sm " onclick="showactiveOrAll(1)">
      <input type="radio"   autocomplete="off"  > View Active
     </label>
     <label class="btn btn-secondary   btn-sm" onclick="showactiveOrAll(0)">
      <input type="radio"  autocomplete="off" checked> View All
     </label>
    </div>
   </div>
   <div class="table-responsive">
    <table class="table table-sm table-striped table-hover" id="dosageTBL">
     <thead>
      <tr>
       <th>Form</th>
       <th>Strength</th>
       <th>Unit</th>
       <th class="no-search">Status</th>
       <th>Last Update</th>
       <th class="no-search"></th>
      </tr>
     </thead>
     <tbody></tbody>
     <tfoot>
      <tr>
       <th>Form</th>
       <th>Strength</th>
       <th>Unit</th>
       <th class="no-search">Status</th>
       <th>Last Update</th>
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
 <script>

  $(document).ready(function () {
   $('#dosageTBL tfoot th').each(function () {
     if ($(this).hasClass("no-search"))
     return;
     var title = $(this).text();
     $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" />');
   });

   var dataTable = $('#dosageTBL').DataTable({
     "paginationDefault": 10,
     "paginationOptions": [10, 25, 50, 75, 100],
     // "responsive": true,
    'order': [[0, 'asc']],
     "ajax": {
     url: "{{ route('eac.portal.settings.manage.drug.dosage.ajaxlist') }}",
     type: "post"
     },
     "processing": true,
     "serverSide": true,
     "columns": [
     

     {
       "data": "form",
       "name": "form",
       searchable: true
     },
     {
       "data": "strength",
       "name": "strength",
       searchable: true
     },
     {
       "data": "unit",
       "name": "unit",
       searchable: true
     },
     {
       "data": "active",
       "name": "active",
       searchable: true
     },
     {
       "data": "created_at",
       "name": "created_at",
       searchable: true
     },
     {
       "data": "ops_btns",
       orderable: false,
       searchable: false
     }
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

  function Confirm_Delete(param)
  {
   swal({
     title: "Are you sure?",
     text: "Want to delete it",
     icon: "warning",
     buttons: [
     'No, cancel it!',
     'Yes, I am sure!'
     ],
     dangerMode: true,
   }).then(function (isConfirm) {
     if (isConfirm) {
     swal({
       title: 'Successfull!',
       text: 'Content deleted!',
       icon: 'success'
     }).then(function () {
       $.get("{{route('eac.portal.settings.manage.drug.dosagedelete')}}",
         {
           id: param
         });
       // return false;
       swal.close();

       $(location).attr('href', '{{route('eac.portal.settings.manage.drug.dosage.index')}}') // <--- submit form programmatically
     });
     } else {
     swal("Cancelled", "Operation cancelled", "error");
     }
   })
  }
  function showactiveOrAll(param){
     
     if(param == 1){
      $('.v-active').show();
      $('.v-inactive').hide();
     }
     if(param == 0){
      $('.v-active').show();
      $('.v-inactive').show();
     }
    }
 </script>
@endsection
