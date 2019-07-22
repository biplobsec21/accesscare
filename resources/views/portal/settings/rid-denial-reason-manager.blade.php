@extends('layouts.portal')

@section('title')
	Rid Denial Reasons Manager
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
						File Type
					</th>
					<th style="text-align:center">
						Template
					</th>
					<th style="text-align:center">
						Upload
					</th>
					<th>
						Origin [RID/Drug]
					</th>
					<th>
						Source
					</th>
					<th style="text-align:center">
						Country Specific
					</th>
					<th>
						actions
					</th>
				</tr>
				</thead>
				<tbody>
				<tr>
					<td style="text-align:center">
						<i class="far fa-check"></i>
					</td>
					<td>
						Ambien Named Patient Eligibility Form
					</td>
					<td style="text-align:center">
						<button type="button" class="btn text-success" data-toggle="modal" data-target="#tempInfo1">
							<i class="far fa-check"></i>
						</button>
					</td>
					<td>
					</td>
					<td>
						Ambien (zolpidem tartrate)
					</td>
					<td>
					</td>
					<td style="text-align:center">
						<button type="button" class="btn text-success" data-toggle="modal" data-target="#viewCountries1">
							<i class="far fa-check"></i>
						</button>
					</td>
					<td>
						[view]
					</td>
				</tr>
				<div class="modal fade" id="tempInfo1" tabindex="-1" role="dialog" aria-labelledby="tempInfo1Label"
						 aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="m-0" id="tempInfo1Label">
									<small>Ambien Named Patient Eligibility Form<br/></small>
									Template Details
								</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<ul class="list-group list-group-flush">
								<li class="list-group-item">
									<label class="d-block strong upper">
										Filename
									</label>
									drug_doc_file_1534879477_Ambien_Named_Patient_Eligibility_Form_v21Aug2018.pdf
								</li>
								<li class="list-group-item">
									<label class="d-block strong upper">
										Upload Date
									</label>
									2018-12-13
								</li>
								<li class="list-group-item">
									<label class="d-block strong upper">
										Uploaded By
									</label>
									Aisha Bigelow
								</li>
							</ul>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Dismiss</button>
							</div>
						</div>
					</div>
				</div>
				<div class="modal fade" id="viewCountries1" tabindex="-1" role="dialog" aria-labelledby="viewCountries1Label"
						 aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="m-0" id="viewCountries1Label">
									<small>Ambien Named Patient Eligibility Form<br/></small>
									Country Requirements
								</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<ul class="list-group list-group-flush">
								<li class="list-group-item p-10">
									<div class="row">
										<div class="col-sm">
											<strong>Argentina</strong>
										</div>
										<div class="col-sm">
           <span class="badge badge-warning">
            Always Required
           </span>
										</div>
									</div>
								</li>
								<li class="list-group-item p-10">
									<div class="row">
										<div class="col-sm">
											<strong>Brazil</strong>
										</div>
										<div class="col-sm">
           <span class="badge badge-success">
            Required for Initial Request
           </span>
										</div>
									</div>
								</li>
								<li class="list-group-item p-10">
									<div class="row">
										<div class="col-sm">
											<strong>Chile</strong>
										</div>
										<div class="col-sm">
           <span class="badge badge-warning">
            Always Required
           </span>
										</div>
									</div>
								</li>
								<li class="list-group-item p-10">
									<div class="row">
										<div class="col-sm">
											<strong>Egypt</strong>
										</div>
										<div class="col-sm">
           <span class="badge badge-success">
            Required for Initial Request
           </span>
										</div>
									</div>
								</li>
								<li class="list-group-item p-10">
									<div class="row">
										<div class="col-sm">
											<strong>New Zealand</strong>
										</div>
										<div class="col-sm">
           <span class="badge badge-primary">
            Required for Resupplies Only
           </span>
										</div>
									</div>
								</li>
								<li class="list-group-item p-10">
									<div class="row">
										<div class="col-sm">
											<strong>Peru</strong>
										</div>
										<div class="col-sm">
           <span class="badge badge-warning">
            Always Required
           </span>
										</div>
									</div>
								</li>
								<li class="list-group-item p-10">
									<div class="row">
										<div class="col-sm">
											<strong>Turkey</strong>
										</div>
										<div class="col-sm">
           <span class="badge badge-warning">
            Always Required
           </span>
										</div>
									</div>
								</li>
							</ul>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Dismiss</button>
							</div>
						</div>
					</div>
				</div>

				<tr>
					<td style="text-align:center">
						<i class="far fa-check"></i>
					</td>
					<td>
						Glomerular Filtration Rate (GFR or eGFR)
					</td>
					<td style="text-align:center">
						<button type="button" class="btn text-success" data-toggle="modal" data-target="#tempInfo2">
							<i class="far fa-check"></i>
						</button>
					</td>
					<td>
					</td>
					<td>
						Ambien (zolpidem tartrate)
					</td>
					<td>
					</td>
					<td style="text-align:center">
						<button type="button" class="btn text-success" data-toggle="modal" data-target="#viewCountries2">
							<i class="far fa-check"></i>
						</button>
					</td>
					<td>
						[view]
					</td>
				</tr>
				<div class="modal fade" id="tempInfo2" tabindex="-1" role="dialog" aria-labelledby="tempInfo2Label"
						 aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="m-0" id="tempInfo2Label">
									<small>Glomerular Filtration Rate (GFR or eGFR)<br/></small>
									Template Details
								</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<ul class="list-group list-group-flush">
								<li class="list-group-item">
									<label class="d-block strong upper">
										Filename
									</label>
									_drug_doc_file_1530877081_Ambien_Named_Patient_eGFR_v5Jul2018.pdf
								</li>
								<li class="list-group-item">
									<label class="d-block strong upper">
										Upload Date
									</label>
									2018-12-10
								</li>
								<li class="list-group-item">
									<label class="d-block strong upper">
										Uploaded By
									</label>
									Andrew Mellor
								</li>
							</ul>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Dismiss</button>
							</div>
						</div>
					</div>
				</div>
				<div class="modal fade" id="viewCountries2" tabindex="-1" role="dialog" aria-labelledby="viewCountries2Label"
						 aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="m-0" id="viewCountries2Label">
									<small>Glomerular Filtration Rate (GFR or eGFR)<br/></small>
									Country Requirements
								</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<ul class="list-group list-group-flush">
								<li class="list-group-item p-10">
									<div class="row">
										<div class="col-sm">
											<strong>Australia</strong>
										</div>
										<div class="col-sm">
           <span class="badge badge-success">
            Required for Initial Request
           </span>
										</div>
									</div>
								</li>
								<li class="list-group-item p-10">
									<div class="row">
										<div class="col-sm">
											<strong>Belgium</strong>
										</div>
										<div class="col-sm">
           <span class="badge badge-success">
            Required for Initial Request
           </span>
										</div>
									</div>
								</li>
								<li class="list-group-item p-10">
									<div class="row">
										<div class="col-sm">
											<strong>Canada</strong>
										</div>
										<div class="col-sm">
           <span class="badge badge-primary">
            Required for Resupplies Only
           </span>
										</div>
									</div>
								</li>
								<li class="list-group-item p-10">
									<div class="row">
										<div class="col-sm">
											<strong>Colombia</strong>
										</div>
										<div class="col-sm">
           <span class="badge badge-warning">
            Always Required
           </span>
										</div>
									</div>
								</li>
								<li class="list-group-item p-10">
									<div class="row">
										<div class="col-sm">
											<strong>Peru</strong>
										</div>
										<div class="col-sm">
           <span class="badge badge-primary">
            Required for Resupplies Only
           </span>
										</div>
									</div>
								</li>
								<li class="list-group-item p-10">
									<div class="row">
										<div class="col-sm">
											<strong>Romania</strong>
										</div>
										<div class="col-sm">
           <span class="badge badge-warning">
            Always Required
           </span>
										</div>
									</div>
								</li>
								<li class="list-group-item p-10">
									<div class="row">
										<div class="col-sm">
											<strong>Ukraine</strong>
										</div>
										<div class="col-sm">
           <span class="badge badge-warning">
            Always Required
           </span>
										</div>
									</div>
								</li>
							</ul>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Dismiss</button>
							</div>
						</div>
					</div>
				</div>

				<tr>
					<td style="text-align:center">
						<i class="far fa-check"></i>
					</td>
					<td>
						Ambien Named Patient Eligibility Form
					</td>
					<td>
					</td>
					<td style="text-align:center">
						<button type="button" class="btn text-success" data-toggle="modal" data-target="#docInfo3">
							<i class="far fa-check"></i>
						</button>
					</td>
					<td>
						QIS-10102018-9898ASQM
					</td>
					<td>
						Initial Request
					</td>
					<td style="text-align:center">
					</td>
					<td>
						[view]
					</td>
				</tr>
				<div class="modal fade" id="docInfo3" tabindex="-1" role="dialog" aria-labelledby="docInfo3Label"
						 aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="m-0" id="docInfo3Label">
									<small>Ambien Named Patient Eligibility Form<br/></small>
									Uploaded Document Details
								</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<ul class="list-group list-group-flush">
								<li class="list-group-item">
									<label class="d-block strong upper">
										Filename
									</label>
									_drug_doc_file_1530877081_Migalastat_Named_Patient_eGFR_v5Jul2018.pdf
								</li>
								<li class="list-group-item">
									<label class="d-block strong upper">
										Upload Date
									</label>
									2018-12-10
								</li>
								<li class="list-group-item">
									<label class="d-block strong upper">
										Uploaded By
									</label>
									Andrew Mellor
								</li>
							</ul>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Dismiss</button>
							</div>
						</div>
					</div>
				</div>

				</tbody>
			</table>
		</div>
	</div><!-- end .viewData -->
	<div class="rightSide">
		right side
	</div><!-- end .rightSide -->
@endsection
@section('scripts')@endsection
