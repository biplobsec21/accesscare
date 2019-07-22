@extends('layouts.portal')

@section('title')
	Document Type Manager
@endsection

@section('content')
	<div class="titleBar">
		<div class="row justify-content-between">
			<div class="col-md col-lg-auto">
				<h4 class="m-0">Supporting Content:</h4>
				<h2 class="m-0">
					@yield('title')
				</h2>
				@if(!is_null(Auth::user()->last_seen))
					<h6>LAST LOGIN:
						<small>{{ \Carbon\Carbon::parse(Auth::user()->last_seen)->format(config('eac.date_format')) }}</small>
					</h6>
				@endif
			</div>
			<div class="col-md col-lg-auto ml-lg-auto">
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
				<div class="text-right">
					<button class="btn btn-secondary btn-sm" id="ShowRightSide" href="#">
						Changelog
					</button>
				</div>
			</div>
		</div>
	</div><!-- end .titleBar -->
<div class="actionBar">

    <div class="col-md-6 text-left">
        <a href="{{ route($page['listAll']) }}" class=" btn btn-primary" >
            <i class="fas fa-list-ul"></i> List all
        </a>
        <a href="{{ route($page['createButton']) }}" class="btn btn-success">
            <i class="far fa-file-medical"></i> Add New 
        </a>
        <a href="{{ route('eac.portal.settings.document.type.logs') }}" class="btn btn-secondary btn-sm">
            <i class="fal fa-key"></i> Change Log
        </a>
    </div>
    <div class="col-md-6 text-right">

    </div>  
</div><!-- end .actionBar -->
 @php
  if(Session::has('alerts')) {
   $alert = Session::get('alerts');
   $alert_dismiss = view('layouts.alert-dismiss', ['type' => $alert['type'], 'message' => $alert['msg']]);
   echo $alert_dismiss;
  }
 @endphp
	<div class="viewData">
		<div class="card">
			<table class="table table-sm SObasic dt-responsive" id="-datatble-">
				<thead>
				<tr>
					<th style="text-align:center">
						Active
					</th>
					<th>
						Name
					</th>
					<th>
						Template
					</th>
					<th>
						Description
					</th>
					<th>
						Actions
					</th>
				</tr>
				</thead>
				<tbody>
				@foreach($docTypes as $docType)
					<tr data-id="{{$docType->id}}" id="unique_{{$docType->id}}">
					<!--                 <form  action="{{ route('documentType.updateDB') }}" enctype="multipar/form-data" >-->
						<td style="text-align:center">
							<input data-field="active" type="checkbox" data-toggle="toggle" data-on="Active" data-off="Inactive"
										 data-onstyle="success" data-offstyle="primary"
										 data-width="100" {{ $docType->active == 1 ? 'checked' : '' }} />
							<input class="active_ck_{{ $docType->id }}" type="hidden" value="{{$docType->active }}">
						</td>
						<td>
							<span class="invisible" style="display:none">{{$docType->name}}</span>
							<input data-field="name" class="form-control" type="text" value="{{$docType->name}}"/>

						</td>
						<td>
							<input class="template_{{ $docType->id }}" type="hidden" value="{{$docType->template}}">
							<div class="{{$docType->id}}__123">
								@if($docType->template)
									<div class="{{ $docType->template }}_1">
                            <span onclick="show_hide('{{ $docType->template }}','1')">
                                <i class="far fa-edit fa-2x text-success"></i>
                            </span> &nbsp;
                            <a href="{{ url('uploads/templates/'.$docType->file->name) }}" target="_blank">
                                    <i class="far fa-file-pdf fa-3x"></i> {{ $docType->file->name }}
                            </a>
									</div>

									<div class="{{ $docType->template }}_2" style="display:none">
                             <span onclick="show_hide('{{ $docType->template }}','2')">
                                 <i class="far fa-times fa-2x text-danger"></i>
                             </span> &nbsp;
										<input type="file"/>
									</div>
								@else
									<input type="file">
								@endif
							</div>
							<div id="{{$docType->id}}__123"></div>

							<p data-hide-show="error_hide_show_{{$docType->id}}" class="error_hide_show_{{$docType->id}} hide ">Please
								upload pdf or docs </p>
						</td>
						<td>
							<span class="invisible" style="display:none">{{$docType->desc}}</span>
							<textarea data-field="desc" class="form-control">{{$docType->desc}}</textarea>
						</td>
						<td>
							<button type="button" class="btn p-0 m-0 text-danger" onclick="ConfirmDelete('{{$docType->id}}')">
								<i class="far fa-times"></i>
							</button>

							<!--                        <button class="btn btn-success btn-sm" type="submit">
																							<i class="fas fa-edit"></i> Update
																			 </button>-->
						</td>
						<!--                </form>-->
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
	</div><!-- end .viewData -->
	<div class="rightSide">
		right side
	</div><!-- end .rightSide -->
@endsection
@section('scripts')
	<script>
		$(document).ready(function () {

			$("#-datatble-").on("click", function () {


				$("input").change(function () {

					let id = $(this).closest("tr").attr('data-id');
					let template = $('.template_' + id).val();
					let val = $(this).val();

					if (template) {
						template = template;
					} else {
						template = "null";
					}

					let type = $(this).attr('type');

					if (type == 'file') { // input type
//                alert(val);
//                return false;
						var name = val;

						var form_data = new FormData();
						// check file type if wrong show message
						var ext = name.split('.').pop().toLowerCase();
						let attr = "error_hide_show_" + id;
						if (jQuery.inArray(ext, ['pdf', 'docs', 'docx', 'doc']) == -1) {
							$('.' + attr).show().addClass('text-danger');
							$(this).val('');
//                    alert(attr);
							return false;
						}

						// file size
						if (this.files[0].size > 2000000) {
							alert('file size should be less 2MB');
							$(this).val('');
							return false;
						}

						form_data.append("file_image", this.files[0]);
						form_data.append("document_type_id", id);
						form_data.append("template", template);
						form_data.append("id", id);

						const wrapperss = document.createElement('div');
						wrapperss.innerHTML = "<i class='fas fa-spinner fa-pulse'></i><label class='text-success'>  Image Uploading...</label>";

						$.ajax({
							cache: false,
							contentType: false,
							processData: false,
							headers: {
								'X-CSRF-Token': '{{ csrf_token() }}',
							},
							type: 'POST',
							url: "{{route('documentType.updateDB')}}",
							data: form_data,
							beforeSend: function () {

								swal({
									title: "",
									text: "Wait",
									content: wrapperss,
									button: {text: 'ok'}
								});

								$('.' + attr).show().html('<i class="fas fa-spinner fa-pulse"></i><label class="text-success">  Image Uploading...</label>');
							},
							success: function (data) {
								//alert(data);
//                        alert('success');
//                        alert(data.file_url);

								$('.' + attr).hide();

								$("#" + id + '__123').html('');
								$("." + id + '__123').remove();
								$("#" + id + '__123').html(data.html);
								$(this).val('');
								swal.close();

							},
							error: function (xhr, status, errorThrown) {
								//Here the status code can be retrieved like;
								xhr.status;

								//The message added to Response object in Controller can be retrieved as following.
								xhr.responseText;
								if (xhr.status === 0) {
									alert('Not connected.\nPlease verify your network connection.');
								} else if (xhr.status == 404) {
									alert('The requested page not found. [404]');
								} else if (xhr.status == 500) {
									alert('Internal Server Error [500].');
								} else if (exception === 'parsererror') {
									alert('Requested JSON parse failed.');
								} else if (exception === 'timeout') {
									alert('Time out error.');
								} else if (exception === 'abort') {
									alert('Ajax request aborted.');
								} else {
									alert('Uncaught Error.\n' + xhr.responseText);
								}
							}
						});
					} else {

						var form_data = new FormData();
						form_data.append("id", id);
						if (type == 'checkbox') {

							let active = 0;
							if ($(this).is(':checked')) {
								active = 1;
							} else {
								active = 0;
							}

							form_data.append("active_val", parseInt(active));
						}
						if (type == 'text') {
							form_data.append("name", val);
						}


						$.ajax({
							cache: false,
							contentType: false,
							processData: false,
							headers: {
								'X-CSRF-Token': '{{ csrf_token() }}',
							},
							type: 'POST',
							url: "{{route('documentType.updateDB')}}",
							data: form_data,
							beforeSend: function () {
								swal({
									title: "",
									text: "Request Successfull",
									button: {text: 'ok'}
								});
//                        $( '.'+ attr).show().html('  <i class="fas fa-spinner fa-pulse"></i><label class="text-success">  Image Uploading...</label>');
                    },
                    success: function(data)
                    {

                     setTimeout(function() {
                          swal.close();
                      },500);

                    },
                    error: function (xhr, status, errorThrown) {
                    //Here the status code can be retrieved like;
                      xhr.status;

                    //The message added to Response object in Controller can be retrieved as following.
                     xhr.responseText;
                    if (xhr.status === 0) {
                      alert ('Not connected.\nPlease verify your network connection.');
                    } else if (xhr.status == 404) {
                        alert ('The requested page not found. [404]');
                    } else if (xhr.status == 500) {
                        alert ('Internal Server Error [500].');
                    } else if (exception === 'parsererror') {
                        alert ('Requested JSON parse failed.');
                    } else if (exception === 'timeout') {
                        alert ('Time out error.');
                    } else if (exception === 'abort') {
                        alert ('Ajax request aborted.');
                    } else {
                        alert ('Uncaught Error.\n' + xhr.responseText);
                    }
                    }
                });

            }

        });

        $("textarea").on("change", function () {
            let id = $(this).closest("tr").attr('data-id');
            let val = $(this).val();

           const wrappersss = document.createElement('div');
            wrappersss.innerHTML = "<i class='fas fa-spinner fa-pulse'></i><label class='text-success'>Description Updating...</label>";


            $.ajax({
                url: "{{route('documentType.updateDB')}}",
                type: 'POST',
                data: {
                    'id': id,
                    'description': val
                },
                beforeSend:function(){

                       swal({
                        title: "",
                        text: "Description updated successfully",
                        showConfirmButton: false
                       });
                 },
                success: function (response) {
                    console.log(response);
                      setTimeout(function() {
                          swal.close();
                      },500);
                }
            });
        });
    });

    });
//    $("#-datatble-").on("click", function(){

        function show_hide(vari,par){
            if(par == 1){
                $("."+vari+'_'+par).hide();
                $("."+vari+'_2').show();

            }
            if(par == 2){
                $("."+vari+'_'+par).hide();
                $("."+vari+'_1').show();
            }

        }
        function ConfirmDelete(param)
        {

       swal({
      title: "Are you sure?",
      text: "You will not be able to recover !",
      icon: "warning",
      buttons: [
        'No, cancel it!',
        'Yes, I am sure!'
      ],
      dangerMode: true,
    }).then(function(isConfirm) {
      if (isConfirm) {
        swal({
          title: 'Successfull!',
          text: 'Content deleted!',
          icon: 'success'
        }).then(function() {
            $.post("{{route('documentType.ajaxDelete')}}", {
               id: param
             });
          $("#unique_"+param).remove(); // <--- submit form programmatically
        });
      } else {
        swal("Cancelled", "Operation cancelled", "error");
      }
    })

        }
//    });
</script>
@endsection

