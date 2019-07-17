@extends('layouts.portal')

@section('title')
	Manage Email Templates
@endsection
@section('content')
	<div class="titleBar">
		<div class="row justify-content-between">
			<div class="col-md col-lg-auto">
				<h2 class="m-0">
					Manage Email Templates
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
						Email Templates
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
		<div class="alert alert-danger">This is sample data // hardcoded // changes will not save to record</div>
		<table class="table table-striped SOint">
			<thead>
			<tr>
				<th>
					Identifier
				</th>
				<th>
					Subject
				</th>
				<th>
					Amt. Used
				</th>
				<th>
					Status
				</th>
				<th></th>
			</tr>
			</thead>
			<tbody>
			<tr>
				<td>
					<a href="sitesettings_edit_ex1.htm">
						register_physician_user_to_eac
					</a>
				</td>
				<td>
					<a href="sitesettings_edit_ex1.htm">
						Physician Registration
					</a>
				</td>
				<td>
					<span class="badge badge-success">19</span>
				</td>
				<td>
     <span class="badge badge-success">
      Active
     </span>
				</td>
				<td>
					<a href="sitesettings_edit_ex1.htm" class="text-dark">
						<i class="far fa-edit"></i> <span class="sr-only">Edit</span>
					</a>
					<a href="#" class="text-dark" data-toggle="modal" data-target="#register_physician_user_to_eac">
						<i class="far fa-search-plus"></i> <span class="sr-only">View</span>
					</a>
					<div class="modal fade" id="register_physician_user_to_eac" tabindex="-1" role="dialog"
							 aria-labelledby="register_physician_user_to_eacLabel" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="register_physician_user_to_eacLabel">Physician Registration</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<p>Dear EAC,</p>
									<h2>Pending Physician Notification</h2>
									<p>Dr. {physician_user_fname} has been registered into the system as physician.</p>
									<p><strong>Please click the link below to review:</strong><br/><a href="{url}">{url}</a></p>
									<p>Thank you,<br/>The Early Access Care Team</p>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									<a href="sitesettings_edit_ex1.htm" class="btn btn-warning">
										<i class="far fa-edit"></i> <span class="sr-only">Edit</span>
									</a>
								</div>
							</div>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<a href="#" class="text-dark">
						register_physician_user
					</a>
				</td>
				<td>
					<a href="#" class="text-dark">
						Physician Registration
					</a>
				</td>
				<td>
					<span class="badge badge-danger">0</span>
				</td>
				<td>
     <span class="badge badge-dark">
      Archived
     </span>
				</td>
				<td>
					<a href="#" class="text-dark">
						<i class="far fa-edit"></i> <span class="sr-only">Edit</span>
					</a>
					<a href="#" class="text-dark">
						<i class="far fa-search-plus"></i> <span class="sr-only">View</span>
					</a>
				</td>
			</tr>

			<tr>
				<td>
					<a href="#" class="text-dark">
						register_eac_user
					</a>
				</td>
				<td>
					<a href="#" class="text-dark">
						EAC Registration
					</a>
				</td>
				<td>
					<span class="badge badge-success">11</span>
				</td>
				<td>
     <span class="badge badge-success">
      Active
     </span>
				</td>
				<td>
					<a href="#" class="text-dark">
						<i class="far fa-edit"></i> <span class="sr-only">Edit</span>
					</a>
					<a href="#" class="text-dark">
						<i class="far fa-search-plus"></i> <span class="sr-only">View</span>
					</a>
				</td>
			</tr>

			<tr>
				<td>
					<a href="#" class="text-dark">
						register_company_user
					</a>
				</td>
				<td>
					<a href="#" class="text-dark">
						Pharma Company User Registration
					</a>
				</td>
				<td>
					<span class="badge badge-success">8</span>
				</td>
				<td>
     <span class="badge badge-success">
      Active
     </span>
				</td>
				<td>
					<a href="#" class="text-dark">
						<i class="far fa-edit"></i> <span class="sr-only">Edit</span>
					</a>
					<a href="#" class="text-dark">
						<i class="far fa-search-plus"></i> <span class="sr-only">View</span>
					</a>
				</td>
			</tr>

			<tr>
				<td>
					<a href="#" class="text-dark">
						physician_user_registration_to_physician
					</a>
				</td>
				<td>
					<a href="#" class="text-dark">
						Physician Registration
					</a>
				</td>
				<td>
					<span class="badge badge-success">7</span>
				</td>
				<td>
     <span class="badge badge-success">
      Active
     </span>
				</td>
				<td>
					<a href="#" class="text-dark">
						<i class="far fa-edit"></i> <span class="sr-only">Edit</span>
					</a>
					<a href="#" class="text-dark">
						<i class="far fa-search-plus"></i> <span class="sr-only">View</span>
					</a>
				</td>
			</tr>

			<tr>
				<td>
					<a href="#" class="text-dark">
						physician_user_registration_to_eac
					</a>
				</td>
				<td>
					<a href="#" class="text-dark">
						Physician Registration
					</a>
				</td>
				<td>
					<span class="badge badge-warning">2</span>
				</td>
				<td>
     <span class="badge badge-dark">
      Archived
     </span>
				</td>
				<td>
					<a href="#" class="text-dark">
						<i class="far fa-edit"></i> <span class="sr-only">Edit</span>
					</a>
					<a href="#" class="text-dark">
						<i class="far fa-search-plus"></i> <span class="sr-only">View</span>
					</a>
				</td>
			</tr>
			</tbody>
		</table>
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
@section('scripts')@endsection
