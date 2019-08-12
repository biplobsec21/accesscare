@extends('layouts.portal')

@section('title')
 Website Properties Manager
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
  @if($rows_count == 0)
  <a href="{{ route($page['createButton']) }}" class="btn btn-success">
   <i class="fal fa-columns"></i> Add New
  </a>
  @endif
  {{-- <a href="{{ route($page['logsr']) }}" class="btn btn-secondary"> --}}
 <!--  <a href="#" class="btn btn-secondary">
   <i class="fal fa-key"></i> Change Log
  </a> -->
 </div><!-- end .actionBar -->

 <div class="viewData">
  <div class="card mb-1 mb-md-4">
   <div class="table-responsive">
    <table class="table table-sm table-striped table-hover" id="pageTbl">
     <thead>
      <tr>
       <th>Name</th>
       <th>City</th>
       <th>Phone</th>
       <th class="no-search">Email</th>
       <th class="no-search">Last Update</th>
       <th class="no-search"></th>
      </tr>
     </thead>
     <tbody></tbody>
    </table>
   
   </div>
  </div>
 </div><!-- end .viewData -->
@endsection

@section('scripts')
{{-- <script src="https://twitter.github.io/typeahead.js/js/handlebars.js"></script> --}}
 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
 <script>

  $(document).ready(function () {
  // var template = Handlebars.compile($("#details-template").html());
   var dataTable = $('#pageTbl').DataTable({
     "paginationDefault": 10,
     "paginationOptions": [10, 25, 50, 75, 100],
     // "responsive": true,
     'order': [[5, 'desc']],
     "ajax": {
     url: "{{ route('eac.portal.settings.manage.website.properties.ajaxlist') }}",
     type: "post"
     },
     "processing": true,
     "serverSide": true,
     "columns": [
     {
       "data": "name",
       "name": "name",
       searchable: true,
       orderable: true,
     },
     {
       "data": "city",
       "name": "city",
       searchable: true,
       orderable: true,
     },
     {
       "data": "phone1",
       "name": "phone1",
       searchable: true,
       orderable: true,
     },
     {
       "data": "email",
       "name": "email",
       searchable: true,
       orderable: false,
     },
    {
       "data": "created_at",
       "name": "created_at",
       orderable: false,
       searchable: false
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
  // $('#pageTbl tbody').on('click', 'td a.veiw_details', function () {

  //     // var tableId =  $(this).attr("data-id");
  //     // var logs =  $(this).attr("data-log");
  //     // $('#recentActvityModal').modal();
  //     var tr = $(this).closest('tr');
  //     var row = dataTable.row(tr);

  //     // console.log(JSON.parse(row.data().desc.replace(/&quot;/g,'"')));
  //     // var arr = JSON.parse(row.data().desc.replace(/&quot;/g,'"'));
  //     // string = "";
  //    //  $.each(arr, function(index, value) {
  //    //     // do your stuff here
  //    //     if(index == 'created_at' || index == 'updated_at' || index =='desc'){
  //    //     }else{
  //    //       string += "<strong>"+index +"</strong>:<i>"+value+"</i> &nbsp; &nbsp; &nbsp;";
  //    //     }
  //    // });

  //     // var array = {created_by: user, log_data: string};
  //     // console.log(array);
  //     // console.log(JSON.parse(JSON.stringify(convert(row.data().desc))));
  //     console.log(row.data());
  //     if ( row.child.isShown() )
  //     {
  //         row.child.hide();
  //         tr.removeClass('shown');
  //     }
  //     else
  //     {
  //         row.child(template(row.data())).show();
  //         tr.addClass('shown');
  //     }

  //   });
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
       $.get("{{route('eac.portal.settings.manage.website.pagedelete')}}",
         {
           id: param
         });
       // return false;
       swal.close();

       $(location).attr('href', '{{route('eac.portal.settings.manage.website.page.index')}}') // <--- submit form programmatically
     });
     } else {
     swal("Cancelled", "Operation cancelled", "error");
     }
   })
  }
 </script>
@endsection
