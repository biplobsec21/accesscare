@extends('layouts.portal')

@section('title')
 Website Menu Manager
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
  <a href="{{ route($page['createButton']) }}" class="btn btn-success">
   <i class="fal fa-plus"></i> Add New
  </a>
  {{-- <a href="{{ route($page['logsr']) }}" class="btn btn-secondary"> --}}
  <a href="{{ route($page['logsr']) }}" class="btn btn-secondary">
   <i class="fal fa-key"></i> Change Log
  </a>
 </div><!-- end .actionBar -->

 <div class="viewData">
  <div class="row"> 
   <div class="order-lg-2 col-lg-2 col-xl-3">
   </div>
   <div class="order-lg-1 col-lg-10 col-xl-9">
    <div class="card mb-1 mb-md-4">
     <div class="table-responsive">
      <table class="table table-sm table-striped table-hover" id="dosageTBL">
       <thead>
        <tr>
         <th>Menu Name</th>
         {{-- <th>Route</th> --}}
         <th class="no-search">Sub Menu</th>
         <th class="no-search">Sequence</th>
         <th class="no-search">Active</th>
         <th>Last Update</th>
         <th class="no-search no-sort"></th>
        </tr>
       </thead>
       <tbody></tbody>
      </table>
     </div>
    </div>
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
     'order': [[5, 'desc']],
     "ajax": {
     url: "{{ route('eac.portal.settings.manage.website.menu.ajaxlist') }}",
     type: "post"
     },
     "processing": true,
     "serverSide": true,
     "columns": [
     

     {
       "data": "name",
       "name": "name",
       searchable: true
     },
     // {
     //   "data": "route",
     //   "name": "route",
     //   searchable: true
     // },
     {
       "data": "sub_menu",
       "name": "sub_menu",
       searchable: true
     },
     {
       "data": "sequence",
       "name": "sequence",
        orderable: false,
       searchable: false
      },
     
     {
       "data": "active",
       "name": "active",
       orderable: false,
       searchable: false
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
       $.get("{{route('eac.portal.settings.manage.website.menudelete')}}",
         {
           id: param
         });
       // return false;
       swal.close();

       $(location).attr('href', '{{route('eac.portal.settings.manage.website.menu.index')}}') // <--- submit form programmatically
     });
     } else {
     swal("Cancelled", "Operation cancelled", "error");
     }
   })
  }
 </script>
@endsection
