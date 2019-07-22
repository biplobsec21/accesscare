@extends('layouts.portal')

@section('title')
	Supporting Content
@endsection

@section('content')
	<div class="titleBar">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="{{ route('eac.portal.getDashboard') }}">Dashboard</a>
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

	<div class="viewData">
		<div class="row">
			<div class="col-md">
				<div class="row">
					<div class="col-sm-6 col-md-12">
						<div class="card card-body mb-3 mb-xl-5">
							<h5 class="mb-2">
								<i class="text-secondary fas fa-lock-alt"></i>
								User Access
							</h5>
							<ul class="list-unstyled ml-4 mb-0">
								<li class="p-1">
									<a href="{{ route('eac.portal.settings.manage.user.role') }}">
										Manage Roles/Permissions
									</a>
								</li>
							</ul>
						</div>
					</div><!-- end permissions -->
					<div class="col-sm-6 col-md-12">
						<div class="card card-body mb-3 mb-xl-5">
							<h5 class="mb-2">
								<i class="text-secondary fas fa-medkit"></i>
								RIDs
							</h5>
							<ul class="list-unstyled ml-4 mb-0">
								<li class="p-1">
									<a href="{{ route('eac.portal.settings.manage.rid.denial.reason.index') }}">
										RID Denial Reason Manager
									{{--</a>--}}
								</li>
								<li class="p-1">
									<a href="{{ route('eac.portal.settings.manage.rid.shipment.courier.index') }}">
										Shipping Courier Manager
									</a>
								</li>
							</ul>
						</div>
					</div><!-- end rids -->
				</div>
			</div>
			<div class="col-md">
				<div class="row">
					<div class="col-sm-6 col-md-12">
						<div class="card card-body mb-3 mb-xl-5">
							<h5 class="mb-2">
								<i class="text-secondary fas fa-prescription-bottle-alt"></i>
								Drugs
							</h5>
							<ul class="list-unstyled ml-4 mb-0">
								<li class="p-1">
									<a href="{{ route('eac.portal.settings.manage.drug.dosage.index') }}">
										Drug Dosage Manager
									</a>
								</li>
								<li class="p-1">
									<a href="{{ route('eac.portal.settings.manage.drug.dosage.form.index') }}">
										Dosage Form Manager
									</a>
								</li>
								<li class="p-1">
									<a href="{{ route('eac.portal.settings.manage.drug.dosage.strength.index') }}">
										Formulation Strength Manager
									</a>
								</li>
								<li class="p-1">
									<a href="{{ route('eac.portal.settings.manage.drug.dosage.concentration.index') }}">
										Concentration Unit Manager
									</a>
								</li>
								<li class="p-1">
									<a href="{{ route('eac.portal.settings.manage.drug.dosage.route.index') }}">
										Routes of Administration Manager
									</a>
								</li>
							</ul>
						</div>
					</div><!-- end drugs -->
					<div class="col-sm-6 col-md-12">
						<div class="card card-body mb-3 mb-xl-5">
							<h5 class="mb-2">
								<i class="text-secondary fas fa-folder-open"></i>
								Documents
							</h5>
							<ul class="list-unstyled ml-4 mb-0">
								<!-- <li class="p-1">
									{{--<a href="{{ route('eac.portal.settings.document') }}">--}}
									Document Manager
									{{--</a>--}}
								</li> -->
								<li class="p-1">
									<a href="{{ route('eac.portal.settings.document.type') }}">
										 Document Type Manager
									</a>
								</li>
								{{--  <li class="p-1">
                  <a href="{{ route('eac.portal.settings.document.resource.type.index') }}">
                   Manage Resource Types
                  </a>
                 </li> --}}
							</ul>
						</div>
					</div><!-- end document -->
				</div>
			</div>
			<div class="col-md">
				<div class="row">
					<div class="col-sm-6 col-md-12">
						<div class="card card-body mb-3 mb-xl-5">
							<h5 class="mb-2">
								<i class="text-secondary fas fa-envelope-open-text"></i>
								Email Templates
							</h5>
							<ul class="list-unstyled ml-4 mb-0">
								<li class="p-1">
									<a href="{{ route('eac.portal.settings.mail.notification-mail') }}">
										Email Template Manager
									</a>
								</li>
							</ul>
						</div>
					</div><!-- end emails -->
					<div class="col-sm-6 col-md-12">
						<div class="card card-body mb-3 mb-xl-5">
							<h5 class="mb-2">
								<i class="text-secondary fas fa-globe"></i>
								Geographical
							</h5>
							<ul class="list-unstyled ml-4 mb-0">
								<li class="p-1">
									<a href="{{ url('portal/settings/manage/countries') }}">
										Country Manager
									</a>
								</li>
								<li class="p-1">
									<a href="{{ url('portal/settings/manage/states') }}">
										State Manager
									</a>
								</li>
								<li class="p-1">
									<a href="{{ url('portal/settings/manage/ethnicity') }}">
										Ethnicity Manager
									</a>
								</li>
							</ul>
						</div>
					</div><!-- end geographical -->
					<div class="col-sm-6 col-md-12">
						<div class="card card-body mb-3 mb-xl-5">
							<h5 class="mb-2">
								{{--         <i class="text-secondary fas fa-folder-open"></i>
                 --}} <i class="text-secondary fas fa-browser"></i>
								Web site
							</h5>
							<ul class="list-unstyled ml-4 mb-0">
								<li class="p-1">
									<a href="{{ route('eac.portal.settings.manage.website.menu.index')}}">
										Menu management
									</a>
								</li>
								<li class="p-1">
									<a href="{{ route('eac.portal.settings.manage.website.page.index') }}">
										Website Content Manager
									</a>
								</li>
								<li class="p-1">
									<a href="{{ route('eac.portal.settings.manage.website.properties.index') }}">
										Website Properties
									</a>
								</li>
								{{--  <li class="p-1">
                  <a href="">
                   Manage Resource Types
                  </a>
                 </li> --}}
							</ul>
						</div>
					</div><!-- end website -->
				</div>
			</div>
		</div>
	</div><!-- end .viewData -->

@endsection
@section('scripts')@endsection
