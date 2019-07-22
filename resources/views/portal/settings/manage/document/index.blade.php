@extends('layouts.portal')

@section('title')
	Document Manager
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
			<table class="table table-sm SObasic">
				<thead>
				<tr>
					<th width="100px">
						Name
					</th>
					<th>
						Type
					</th>
					<th>
						File
					</th>
					<th>

					</th>
				</tr>
				</thead>
				<tbody>
				@foreach($docs as $doc)
					<tr data-id="{{ $doc->id }}">
						<td>
							<span class="invisible" style="display:none">{{ $doc->name }}</span>
							<input class="form-control" data-field="name" type="text" value="{{ $doc->name }}"/>
						</td>
						<td>
							{{ $doc->type }}
						</td>
						<td>
							<a href="#"><i class="far fa-download"></i> {{$doc->file->name}}.{{ $doc->file->extension }}</a>
						</td>
						<td>
							<button type="button" class="btn text-warning" data-toggle="modal" data-target="#tempInfo1">
								<i class="far fa-edit"></i>
							</button>
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
					url: "{{route('document.updateDB')}}",
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
