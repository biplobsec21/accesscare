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
 					<th>From Address</th>
 					<th class="no-sort"></th>
 				</tr>
 				</thead>
 				<tbody></tbody>
 				<tfoot>
 				<tr>
 					<th>Name</th>
 					<th>Subject</th>
 					<th>From Address</th>
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
		// Data Tables
		$(document).ready(function () {
			// $('.btn-del').click(function(){
			// 	console.log('asd');
			// });
			

			$('#mailListTBL tfoot th').each(function () {
				if ($(this).hasClass("no-search"))
					return;
				var title = $(this).text();
				$(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" />');
			});

			var dataTable = $('#mailListTBL').DataTable({
				"paginationDefault": 10,
        "paginationOptions": [10, 25, 50, 75, 100],
				// "responsive": true,
				'order': [[0, 'asc']],
				"ajax": {
					url: "{{ route('eac.portal.settings.mail.ajax.list') }}",
					type: "post"
				},
				"processing": true,
				"serverSide": true,
				"columns": [
					{
						"data": "name",
						'name': 'name',
						searchable: true
					},
					{
						"data": "subject",
						'name': 'subject',
						searchable: true
					},
					{
						"data": "from_email",
						'name': 'from_email',
						searchable: true

					},
					{
						"data": "ops_btns",
						orderable: false,
						searchable: false
					},
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
 <script>
  function ConfirmDelete(param) {
  // alert(param);
  //          var x = confirm("Are you sure you want to delete?");
  //          if (x){
  //            $.ajax({
  //                url: "{{route('documentType.ajaxDelete')}}",
  //                type: 'POST',
  //                data: {
  //                    'id': param
  //                },
  //                success: function (response) {
  //                    console.log(response);
  //                    if(response.result == 'Success'){
  //                        $("#unique_"+param).remove();
  //                    }
  ////                    $('#'+param').remove();
  //                }
  //            });
  //               return true;
  //          }else{
  //              return false;
  //          }      
  //        swal({
  //            title: "Are you sure?",
  //            text: "If you delete this content will be deleted permanently.",
  //            type: "warning",
  //            showCancelButton: true,
  //            closeOnConfirm: false,
  //            showLoaderOnConfirm: true,
  //            confirmButtonClass: "btn-danger",
  //            confirmButtonText: "Yes, delete it!",
  //       }).then(function() {
  //           $.post("{{route('documentType.ajaxDelete')}}", {
  //               id: param
  //             },
  //             function(data) {
  //               swal({
  //                 title: "Deleted!",
  //                 text: "Your content has been deleted.",
  //                 type: "success"
  //               }, );
  //               $("#unique_"+param).remove();
  //             }
  //           );
  //
  //       });
    swal({
     title: "Are you sure?",
     text: "You will not be able to recover !",
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
       $.post("{{route('mailType.ajaxDelete')}}", {
        id: param
       });
       $(location).attr('href','{{route('eac.portal.settings.mail.notification-mail')}}');
      });
     } else {
      swal("Cancelled", "Operation cancelled", "error");
     }
    })

  //       swal({
  //        title: "Are you sure?",
  //        text: "You will not be able to recover this data!",
  //        type: "warning",
  //        showCancelButton: true,
  //        confirmButtonColor: "#DD6B55",
  //        confirmButtonText: "Yes, delete it!",
  //        closeOnConfirm: false
  //    }, function (isConfirm) {
  //        if (!isConfirm) return;
  //        $.ajax({
  //            url: "{{route('documentType.ajaxDelete')}}",
  //            type: "POST",
  //            data: {
  //                'id': param
  //            },
  //            success: function (response) {
  //                if(response.result == 'Success'){
  //                        $("#unique_"+param).remove();
  //                        swal("Done!", "It was succesfully deleted!", "success");
  //                }
  //            },
  //            error: function (xhr, ajaxOptions, thrownError) {
  //                swal("Error deleting!", "Please try again", "error");
  //            }
  //        });
  //    });
   }

   //    });
 </script>
	<script>

		$(document).ready(function () {
			$( ".btn-del" ).on( "click", function() {
			  console.log( 'sdsad' );
			});

			$("input").change(function () {
				var id = $(this).closest(".card").attr('data-id');
				var field = $(this).attr('data-field');
				var val = $(this).val();
				writeToDB(id, field, val);
			});

			function writeToDB(id, field, val) {
				$.ajax({
					url: "{{route('eac.portal.settings.mail.notification-mail.ajax')}}",
					type: 'POST',
					data: {
						'id': id,
						'field': field,
						'val': val
					},
					success: function (response) {
						console.log(response);
					}
				});
			}

			$('.trumbo-e').trumbowyg().on('tbwchange', function () {
				var id = $(this).attr('data-id');
				var field = $(this).attr('data-field');
				var val = $(this).trumbowyg('html');
				writeToDB(id, field, val);
			});


		});
	</script>
@endsection
