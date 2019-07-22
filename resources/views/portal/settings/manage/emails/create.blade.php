@extends('layouts.portal')

@section('title')
	Create Email Template
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
     <li class="breadcrumb-item">
      <a href="{{ route('eac.portal.settings.mail.notification-mail') }}">Email Template Manager</a>
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
	<form action="{{ route('eac.portal.settings.mail.create') }}" method="post">
		{{ csrf_field() }}
  <div class="row">
   <div class="col-lg-8 col-xl-6">
    @if(Session::has('success'))
     <div class="alert alert-info">{{ Session::get('success') }}</div>
    @endif
    @php
     if(Session::has('alerts')) {
      $alert = Session::get('alerts');
      $alert_dismiss = view('layouts.alert-dismiss', ['type' => $alert['type'], 'message' => $alert['msg']]);
      echo $alert_dismiss;
     }
    @endphp
    <div class="actionBar">
     <a href="{{route('eac.portal.settings.mail.notification-mail')}}" class="btn btn-warning" >
      <i class="far fa-times"></i> Cancel
     </a>
     <button type="submit" href="{{route('eac.portal.settings.mail.create')}}" class="btn btn-info" >
      <i class="far fa-check"></i> Apply
     </button>
    </div><!-- end .actionBar -->
   </div>
  </div><!-- /.row -->

  <div class="viewData">
   <div class="row">
    <div class="col-lg-8 col-xl-6">
     <div class="mb-3 mb-xl-4">
      <div class="card card-body mb-0">
       <div class="row">
        <div class="col-sm mb-3">
   						<label dusk="label-address" class="d-block">Template Name</label>
   						<input type="text" id="name" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}">
         <div class="invalid-feedback">
          {{ $errors->first('name') }}
         </div>
        </div>
        <div class="col-sm mb-3">
   						<label dusk="label-address" class="d-block">Subject</label>
   						<input type="text" id="subject" name="subject" class="form-control{{ $errors->has('subject') ? ' is-invalid' : '' }}" value="{{ old('subject') }}">
   						<div class="invalid-feedback">
          {{ $errors->first('subject') }}
         </div>
        </div>
       </div><!-- /.row -->
       <div class="row">
        <div class="col-sm mb-3">
         <label dusk="label-address" class="d-block">From Address</label>
         <input type="text" id="from_email" name="from_email" placeholder="ex: eacare&#64;earlyaccesscare.com" class="form-control{{ $errors->has('from_email') ? ' is-invalid' : '' }}" value="{{ old('from_email') }}">
         <div class="invalid-feedback">
          {{ $errors->first('from_email') }}
         </div>
        </div>
        <div class="col-sm mb-3">
   						<label dusk="label-address" class="d-block">From Name/Label</label>
   						<input type="text" id="from_name" name="from_name" placeholder="ex: Early Access Care" class="form-control{{ $errors->has('from_name') ? ' is-invalid' : '' }}" value="{{ old('from_name') }}">
   						<div class="invalid-feedback">
          {{ $errors->first('from_name') }}
         </div>
        </div>
       </div><!-- /.row -->
       <div class="row">
        <div class="col-sm mb-3">
   						<label dusk="label-address" class="d-block">Reply-To Address</label>
   						<input type="text" id="reply_to" name="reply_to" class="form-control{{ $errors->has('reply_to') ? ' is-invalid' : '' }}" value="{{ old('reply_to') }}">
   						<div class="invalid-feedback">
          {{ $errors->first('reply_to') }}
         </div>
        </div>
        <div class="col-sm mb-3">
   						<label dusk="label-address" class="d-block">CC <small>(Optional)</small></label>
   						<input type="text" id="cc" name="cc" class="form-control{{ $errors->has('cc') ? ' is-invalid' : '' }}" value="{{ old('cc') }}">
   						<div class="invalid-feedback">
          {{ $errors->first('cc') }}
         </div>
        </div>
        <div class="col-sm mb-3">
   						<label dusk="label-address" class="d-block">BCC <small>(Optional)</small></label>
   						<input type="text" id="bcc" name="bcc" class="form-control{{ $errors->has('bcc') ? ' is-invalid' : '' }}" value="{{ old('bcc') }}">
   						<div class="invalid-feedback">
          {{ $errors->first('bcc') }}
         </div>
        </div>
       </div><!-- /.row -->
       <div class="mb-3">
  						<label dusk="label-address" class="d-block">HTML Body</label>
  						<textarea class="form-control{{ $errors->has('html') ? ' is-invalid' : '' }} editor" rows="10" id="html" name="html" data-field="text">Dear Pharmaceutical User, <br> Resupply Request<br><br> {{ $user_title }}. {{$first_name}} {{$last_name}} has requested resupply for RID #{rid_num}.<br> Please click the link below to review:{url}<br><br> Thank you,<br> The Early Access Care Team</textarea>
        <div class="invalid-feedback">
         {{ $errors->first('html') }}
        </div>
       </div>

  					@if(isset($rolename))
        <div class="mb-3">
   						<label dusk="label-address" class="d-block">Notes</label>
   						<input type="text" id="note" name="note" class="form-control" rows="4" value="{{ old('note') }}">
        </div>
  					@endif
      </div>
      <div class="card-footer d-flex justify-content-center">
       <button class="btn btn-success" type="submit">
        <i class="far fa-check"></i> Submit
       </button>
      </div>
     </div>
    </div>
   </div><!-- /.row -->
  </div><!-- /.viewData -->		
	</form>
@endsection



@section('scripts')
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

	<script type="text/javascript">
		// Data Tables
		$(document).ready(function () {
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
						searchable: false
					},
					{
						"data": "from_email"
					},
					
					{
						"data": "reply_to",
						searchable: false
					},
					{
						"data": "cc",
					},
					{
						"data": "bcc",
					},
					{
						"data": "html",
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
@endsection


@section('scripts')
	<script>
		$(document).ready(function () {

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
