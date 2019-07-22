@extends('layouts.portal')

@section('title')
	Supporting Content
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
     <li class="breadcrumb-item active" aria-current="page">
      @yield('title')
     </li>
    </ol>
    <div class="text-right">
     <button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#changeLog">
      Changelog
     </button>
    </div>
   </div>
  </div>
 </div><!-- end .titleBar -->
 <div class="viewData">
  <div class="row">
   <div class="col-md">
    <div class="row">
     <div class="col-sm-6 col-md-12">
      <div class="card display m-b-20">
       <div class="card-header">
        <h5 class="m-0">
         <i class="far fa-lock"></i>
         User Access
        </h5>
       </div>
       <ul class="list-group list-group-flush">
        <li class="list-group-item">
         <a href="{{ route('eac.portal.settings.manage.user.role') }}">
          Manage Roles
         </a>
        </li>
        <li class="list-group-item">
         <a href="{{ route('eac.portal.settings.manage.user.permission') }}">
          Manage Permissions
         </a>
        </li>
				 <li class="list-group-item">
					 <a href="{{ route('eac.portal.settings.manage.user.abilities') }}">
						 Manage Abilities
					 </a>
				 </li>
       </ul>
      </div>
     </div><!-- end permissions -->
     <div class="col-sm-6 col-md-12">
      <div class="card display m-b-20">
       <div class="card-header">
        <h5 class="m-0">
         <i class="far fa-file-prescription"></i>
         RIDs
        </h5>
       </div>
       <ul class="list-group list-group-flush">
        <li class="list-group-item">
         {{--<a href="{{ route('eac.portal.settings.denial-reason-mgmt') }}">--}}
          Manage RID Denial Reasons
         {{--</a>--}}
        </li>
        <li class="list-group-item">
         <a href="{{ route('eac.portal.settings.manage.rid.shipment.courier.index') }}">
          Manage Shipping Couriers
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
      <div class="card display m-b-20">
       <div class="card-header">
        <h5 class="m-0">
         <i class="far fa-prescription"></i>
         Drugs
        </h5>
       </div>
       <ul class="list-group list-group-flush">
        <li class="list-group-item">
         <a href="{{ route('eac.portal.settings.manage.drug.dosage.index') }}">
          Manage Dosage
         </a>
        </li>
        <li class="list-group-item">
         <a href="{{ route('eac.portal.settings.manage.drug.dosage.form.index') }}">
          Manage Dosage Forms
         </a>
        </li>
        <li class="list-group-item">
         <a href="{{ route('eac.portal.settings.manage.drug.dosage.strength.index') }}">
          Manage Dosage Strengths
         </a>
        </li>
        <li class="list-group-item">
         <a href="{{ route('eac.portal.settings.manage.drug.dosage.concentration.index') }}">
          Manage Dosage Concentrations
         </a>
        </li>
        <li class="list-group-item">
         <a href="{{ route('eac.portal.settings.manage.drug.dosage.route.index') }}">
          Manage Dosage Route
         </a>
        </li>
       </ul>
      </div>
     </div><!-- end drugs -->
     <div class="col-sm-6 col-md-12">
      <div class="card display m-b-20">
       <div class="card-header">
        <h5 class="m-0">
         <i class="far fa-file-medical"></i>
         Documents
        </h5>
       </div>
       <ul class="list-group list-group-flush">
        <li class="list-group-item">
         {{--<a href="{{ route('eac.portal.settings.document') }}">--}}
          Document Manager
         {{--</a>--}}
        </li>
        <li class="list-group-item">
         <a href="{{ route('eac.portal.settings.document.type') }}">
          Manage Document Types
         </a>
        </li>
       {{--  <li class="list-group-item">
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
      <div class="card display m-b-20">
       <div class="card-header">
        <h5 class="m-0">
         <i class="far fa-envelope-open-text"></i>
         Email Templates
        </h5>
       </div>
       <ul class="list-group list-group-flush">
        <li class="list-group-item">
         <a href="{{ route('eac.portal.settings.mail.notification-mail') }}">
          Manage Email Templates
         </a>
        </li>
       </ul>
      </div>
     </div><!-- end emails -->
     <div class="col-sm-6 col-md-12">
      <div class="card display m-b-20">
       <div class="card-header">
        <h5 class="m-0">
         <i class="far fa-globe"></i>
         Geographical
        </h5>
       </div>
       <ul class="list-group list-group-flush">
        <li class="list-group-item">
         <a href="{{ url('portal/settings/manage/countries') }}">
          Manage Countries
         </a>
        </li>
        <li class="list-group-item">
         <a href="{{ url('portal/settings/manage/states') }}">
          Manage States
         </a>
        </li>
       </ul>
      </div>
     </div><!-- end geographical -->
    </div>
    {{--<div class="row">--}}
      {{--<div class="col-sm-6 col-md-12">--}}
      {{--<div class="card display m-b-20">--}}
       {{--<div class="card-header">--}}
        {{--<h5 class="m-0">--}}
         {{--<i class="fas fa-database"></i>--}}
         {{--Data Import--}}
        {{--</h5>--}}
       {{--</div>--}}
       {{--<ul class="list-group list-group-flush">--}}
        {{----}}
        {{--<li class="list-group-item">--}}
         {{--<a href="{{ route('eac.portal.settings.manage.dataimport.index') }}">--}}
          {{--Manage Data Migration--}}
         {{--</a>--}}
        {{--</li>--}}
       {{--</ul>--}}
      {{--</div>--}}
     {{--</div>--}}
    {{--</div><!-- end data export -->--}}
   </div>
  </div>
 </div><!-- end .viewData -->

	<div class="modal fade" id="changeLog" tabindex="-1" role="dialog" aria-labelledby="changeLogLabel"
			 aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="">
					<div class="viewchangelog card">
						<div class="card-header bg-dark p-10">
							<div class="row">
								<div class="col">
									<h5 class="text-white m-0">
										Changelog
									</h5>
								</div>
								<div class="col-auto">
									<button class="btn btn-link text-white btn-sm" data-dismiss="modal" aria-label="Close">
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
							Changelog items related to "supporting content" only
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

@endsection
@section('scripts')@endsection
