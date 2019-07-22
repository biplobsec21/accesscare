@extends('layouts.portal')

@section('title')
	Resource Type Manager
@endsection

@section('content')
	<div class="titleBar">
		<div class="row justify-content-between">
			<div class="col-md col-lg-auto">
				<h4 class="m-0">Supporting Content:</h4>
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
				<div class="text-right">
					<button class="btn btn-secondary btn-sm" id="ShowRightSide" href="#">
						Changelog
					</button>
				</div>
			</div>
		</div>
	</div><!-- end .titleBar -->

	<div class="viewData">
		<div class="card">
			<table class="table table-sm SObasic dt-responsive">
				<thead>
				<tr>
					<th style="text-align:center">
						Active
					</th>
					<th>
						Name
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
				@foreach($resTypes as $resType)
					<tr data-id="{{$resType->id}}">
						<td style="text-align:center">
							<input data-field="active" type="checkbox" data-toggle="toggle" data-on="Active" data-off="Inactive"
										 data-onstyle="success" data-offstyle="primary" data-width="100" checked/>
						</td>
						<td>
							<span class="invisible" style="display:none">{{$resType->name}}</span>
							<input data-field="name" class="form-control" type="text" value="{{$resType->name}}"/>
						</td>
						<td>
							<span class="invisible" style="display:none">{{$resType->desc}}</span>
							<textarea data-field="desc" class="form-control">{{$resType->desc}}</textarea>
						</td>
						<td>
							<button type="button" class="btn text-danger" data-toggle="modal" data-target="#tempInfo1">
								<i class="far fa-times"></i>
							</button>
						</td>
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
			$("input").change(function () {
				let id = $(this).closest("tr").attr('data-id');
				let field = $(this).attr('data-field');
				let val = $(this).val();
				$.ajax({
					url: "{{route('eac.portal.setting.document.resource.type.ajax.updateDB')}}",
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

			});
			$("textarea").on("change", function () {
				let id = $(this).closest("tr").attr('data-id');
				let field = $(this).attr('data-field');
				let val = $(this).val();
				$.ajax({
					url: "{{route('eac.portal.setting.document.resource.type.ajax.updateDB')}}",
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
			});
		});
	</script>
@endsection
