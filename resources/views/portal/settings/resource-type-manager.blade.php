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
				@foreach($rows as $row)
					<tr>
						<td style="text-align:center">
							<input type="checkbox" data-toggle="toggle" data-on="Active" data-off="Inactive" data-onstyle="success"
										 data-offstyle="primary" data-width="100" checked/>
						</td>
						<td>
							<span class="invisible" style="display:none">{{$row->name}}</span>
							<input type="text" value="{{$row->name}}"/>
						</td>
						<td>
							<span class="invisible" style="display:none">{{$row->desc}}</span>
							<textarea class="form-control">{{$row->desc}}</textarea>
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
@section('scripts')@endsection
