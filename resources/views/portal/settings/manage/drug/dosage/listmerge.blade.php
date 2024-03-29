@extends('layouts.portal')

@section('title')
 Drug Dosage Manager
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
 <form method="post" action="{{ route('eac.portal.settings.manage.drug.dosage.mergeselect') }}">
  {{ csrf_field() }}
  <div class="actionBar">
   <a href="{{ route($page['logsr']) }}" class="btn btn-secondary">
    <i class="fal fa-key"></i> Change Log
   </a>
   <button class="btn btn-primary" type="submit">
    <i class="far fa-check"></i> Merge Selected
   </button>
  </div><!-- end .actionBar -->

  <div class="viewData">
   <div class="card mb-1 mb-md-4">
    <div class="d-flex justify-content-end p-3">
     <div class="btn-group btn-group-toggle btn-group-sm" data-toggle="buttons">
      <label class="btn btn-secondary btn-sm " onclick="showactiveOrAll(1)">
       <input type="radio"   autocomplete="off"  > View Active
      </label>
      <label class="btn btn-secondary  active btn-sm" onclick="showactiveOrAll(0)">
       <input type="radio"  autocomplete="off" checked> View All
      </label>
     </div>
    </div>
    <div class="table-responsive">
     <table class="table table-sm table-striped table-hover" id="dosageTBL">
      <thead>
       <tr>
        <th class="no-search no-sort">Primary</th>
        <th class="no-search no-sort">Merge</th>
        <th>Form</th>
        <th>Strength</th>
        <th>Unit</th>
        <th class="no-search">Status</th>
        <th>Created At</th>
       </tr>
      </thead>
      <tbody></tbody>
     </table>
    </div>
   </div>
  </div><!-- end .viewData -->
 </form>
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
    'order': [[2, 'asc']],
     columnDefs: [{
        targets: 'no-sort',
        orderable: false,
      }],
     "ajax": {
     url: "{{ route('eac.portal.settings.manage.drug.dosage.ajaxlistmerge') }}",
     type: "get"
     },
     "processing": true,
     "serverSide": true,
     "columns": [
     {
       "data": "primary",
       "name": "primary",
     },
      {
       "data": "merge",
       "name": "merge",
     },
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
     text: "There was an error understanding this request. If this issue persists, <a href="mailto:{{site()->email}}">click her</a> to contact us.",
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
