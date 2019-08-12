@extends('layouts.portal')

@section('title')
 Website Content Manager
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
 @include('include.alerts')
 <div class="actionBar">
  <a href="{{ route($page['createButton']) }}" class="btn btn-success">
   <i class="fal fa-columns"></i> Add New Page
  </a>
  {{-- <a href="{{ route($page['logsr']) }}" class="btn btn-secondary"> --}}
  <a href="{{ route($page['logsr']) }}" class="btn btn-secondary">
   <i class="fal fa-key"></i> Change Log
  </a>
 </div><!-- end .actionBar -->

 <div class="viewData">
  <div class="card mb-1 mb-md-4">
    <div class="row mb-3">
                <div class="col">
                </div>

  <div class="col-auto">
    <div class="btn-group btn-group-toggle btn-group-sm" data-toggle="buttons">
      <label class="btn btn-secondary  btn-sm active" onclick="showactiveOrAll(1)">
        <input type="radio" name="show_active" value="1"
             autocomplete="off" > View Active
      </label>
      <label class="btn btn-secondary  btn-sm" onclick="showactiveOrAll(0)">
        <input type="radio" name="show_active"  value="0"
             autocomplete="off" checked>  View All
      </label>
    </div>
  </div>
</div>
   <div class="table-responsive">
    <table class="table table-sm table-striped table-hover" id="pageTbl">
     <thead>
      <tr>
       <th>Content Identifier</th>
       <th>Title</th>
       <th class="no-search no-sort">Menu Name</th>
       <th class="no-search">Active</th>
       <th class="no-search">Last Update</th>
       <th class="no-search"></th>
      </tr>
     </thead>
     <tbody></tbody>
     <tfoot>
      <tr>
       <th>Content Identifier</th>
       <th>Title</th>
       <th class="no-search no-sort">Menu Name</th>
       <th class="no-search">Active</th>
       <th class="no-search">Last Update</th>
       <th class="no-search"></th>
      </tr>
     </tfoot>
    </table>
     <script id="details-template" type="text/x-handlebars-template">
          <table class="table">
              <tr>
                  <td>Content :@{{content}}</td>
              </tr>
              <tr style="font-size:12px;background: #fddcb8;">
                  <td>Meta Description :[ @{{{meta_kewords}}} ] </td>
              </tr>
              <tr style="font-size:12px;background: #fddcb8;">
                  <td>Meta Keyword :[ @{{{meta_description}}} ] </td>
              </tr>


          </table>
      </script>
   </div>
  </div>
 </div><!-- end .viewData -->
@endsection

@section('scripts')
{{-- <script src="https://twitter.github.io/typeahead.js/js/handlebars.js"></script> --}}
 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
 <script>

  $(document).ready(function () {
   $('#pageTbl tfoot th').each(function () {
     if ($(this).hasClass("no-search"))
     return;
     var title = $(this).text();
     $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" />');
   });
  // var template = Handlebars.compile($("#details-template").html());
   var dataTable = $('#pageTbl').DataTable({
     "paginationDefault": 10,
     "paginationOptions": [10, 25, 50, 75, 100],
     // "responsive": true,
     columnDefs: [{
          targets: 'no-sort',
          orderable: false,
        }],
     'order': [[0, 'asc']],
     "ajax": {
     url: "{{ route('eac.portal.settings.manage.website.page.ajaxlist') }}",
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
     {
       "data": "title",
       "name": "title",
       searchable: true
     },
     {
       "data": "menu_name",
       "name": "menu_name",
       searchable: true
     },
     {
       "data": "active",
       "name": "active",
       searchable: false
     },
    {
       "data": "created_at",
       "name": "created_at",
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
