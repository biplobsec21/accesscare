@extends('layouts.portal')
@section('styles')
	<link rel="stylesheet" href="{{ asset('/ui/trumbowyg.min.css') }}" type="text/css"/>
@endsection
@section('title')
	Registration Email Templates
@endsection
@section('content')
	<div class="titleBar">
		<div class="row justify-content-between">
			<div class="col-md col-lg-auto">
				<h2 class="m-0">
					@yield('title')
				</h2>

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
			</div>
		</div>
	</div><!-- end .titleBar -->
	<div class="actionBar">
		<a href="#" class="disabled btn btn-success"><!-- remove disabled from class once page has been established -->
			New Template
		</a>
		<button class="btn btn-light" id="ShowRightSide" href="#">
			Changelog
		</button>
	</div><!-- end .actionBar -->
	<div class="viewData">
		<div class="row">
			<div class="col-lg">
				@foreach ($templates as $template)
					<div class="row">
						<div data-id="{{ $template->id }}" class="card card-body">
							<div class="form-group m-b-10">
								<label for="">Name / Identifier</label>
								<input type="text" class="form-control" data-field="name" name="" placeholder=""
											 value="{{$template->name}}"/>
								<small class="form-text text-muted">Display help text here</small>
							</div>
							<div class="form-group m-b-10">
								<label for="">Subject</label>
								<input type="text" class="form-control" data-field="subject" name="" placeholder=""
											 value="{{$template->subject}}"/>
								<small class="form-text text-muted">Display help text here</small>
							</div>
							<div class="form-group m-b-10">
								<label for="">Email Body</label>
								<textarea class="form-control trumbo-e" rows="15" data-id="{{ $template->id }}" data-field="text">
        {{$template->text}}
       </textarea>
							</div>
						</div>
					</div>
				@endforeach
			</div>
			<div class="col-lg col-xl-4">
				<ul class="list-group bg-white">
					<li class="list-group-item bg-primary text-white">
						<h5 class="m-0">Available Tokens</h5>
					</li>
					@foreach ($tokens as $token)
						<li class="list-group-item small">
							<div class="row">
								<div class="col-sm col-lg-5 col-xl-4 text-sm-right">
									<strong>{{$token->syntax}}</strong>
								</div>
								<div class="col-sm">
									{{$token->example}}
								</div>
							</div>
						</li>
					@endforeach
				</ul>
			</div>
		</div>
	</div><!-- end .viewData -->
	<div class="rightSide">
		<div class="viewchangelog card">
			<div class="card-header bg-dark p-10">
				<div class="row">
					<div class="col">
						<h5 class="text-white m-0">
							Changelog
						</h5>
					</div>
					<div class="col-auto">
						<button class="btn btn-link text-white btn-sm" id="HideRightSide" href="#">
							<i class="far fa-times"></i>
						</button>
					</div>
				</div>
			</div>
			<div class="change_log">
				<ul class="list-group list-group-flush m-b-40">
					<li>
						<div class="date">
							2018-10-22
						</div>
						QIS Developer Aisha B. created this page
						<small class="badge badge-danger">SAMPLE</small>
					</li>
				</ul>
				Changelog items related to "Email Templates" only
			</div>
		</div>
	</div><!-- end .rightSide -->
@endsection
@section('scripts')
	<script type="application/javascript" src="{{ asset('/trumbowyg.min.js') }}"></script>

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
