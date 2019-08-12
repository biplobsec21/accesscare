@extends('layouts.portal')

@section('title')
	@if(Auth::User()->id == $user->id)
		My Profile
	@else
		View User
	@endif
@endsection
@section('styles')
	<style>
		@media screen and (min-width: 1200px) {
   :root {
    --leftCol: 180px;
    --rightCol: 740px;
   }
   .actionBar, .viewData {
    max-width: calc(var(--leftCol) + var(--rightCol));
   }
   .viewData .row.thisone > [class*=col]:first-child {
    max-width: var(--leftCol);
    min-width: var(--leftCol);
   }
   .viewData .row.thisone > [class*=col]:last-child {
    max-width: var(--rightCol);
    min-width: var(--rightCol);
   }
		}
	</style>
@endsection

@section('content')
	<div class="titleBar">
		<nav aria-label="breadcrumb">
			<div class="row">
				<div class="col-sm-auto">
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<a href="{{ route('eac.portal.getDashboard') }}">Dashboard</a>
						</li>
						<li class="breadcrumb-item">
							<a href="{{ route('eac.portal.user.list') }}">All Users</a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">
							{{$user->full_name}}
						</li>
					</ol>
				</div>
			</div>
		</nav>
		<h6 class="title small upper m-0">
			@yield('title')
		</h6>
		<h2 class="m-0">
			{{$user->full_name}}
		</h2>
		<div class="small">
			@if($user->updated_at)
				<strong>Last Updated:</strong>
				{{$user->updated_at->setTimezone(Session::get('time-zone'))->format('Y/m/d h:i A')}}
			@endif
		</div>
	</div><!-- end .titleBar -->
	<div class="viewData">
		<div class="bg-dark text-white pt-2 pb-2 pr-3 pl-3 d-flex justify-content-between">
			<a href="{{ route("eac.portal.user.list") }}" class="btn btn-light">
				User List
			</a>
			<div>
    @access('user.emulate.view')
					<a href="{{ route('eac.auth.emu.init', $user->id) }}" class="btn btn-primary">
						<i class="fas fa-sign-in-alt" aria-hidden="true"></i>
						Sign In As User
					</a>
				@endif
				@access('user.index.update')
 				<a href="{{ route('eac.portal.user.edit', $user->id) }}" class="btn btn-info">
 					<i class="far fa-edit"></i>
 					Edit User
 				</a>
				@endif
			</div>
		</div>
  <div class="row thisone m-0 mb-xl-5">
   <div class="col-sm-3 col-xl-auto p-0 mb-2 mb-sm-0">
    <div class="wizardSteps symbols nav flex-row flex-sm-column mt-sm-3" id="tab" role="tablist" aria-orientation="vertical">
     <a class="nav-link complete active" id="xdetails-tab" data-toggle="pill" href="#xdetails" role="tab" aria-controls="xdetails" aria-selected="true">
						<span>Details</span>
					</a>
     @access('rid.info.view')
      <a class="nav-link @if($user->rids->count()) complete @endif" id="xassignedRIDs-tab" data-toggle="pill" href="#xassignedRIDs" role="tab" aria-controls="xassignedRIDs" aria-selected="false">
       <span>Assigned RIDs</span>
      </a>
     @endif
     @access('drug.info.view')
      <a class="nav-link @if($drugs->count()) complete @endif" id="xassignedDrugs-tab" data-toggle="pill" href="#xassignedDrugs" role="tab" aria-controls="xassignedDrugs" aria-selected="false">
       <span>Assigned Drugs</span>
      </a>
     @endif
					<a class="nav-link {{ $user->groups() ? 'complete' : '' }}" id="xgroups-tab" data-toggle="pill" href="#xgroups" role="tab" aria-controls="xgroups" aria-selected="false">
						<span>User Groups</span>
					</a>
					@access('user.note.view')
						<a class="nav-link @if($user->notes->count() > 0) complete @endif" id="xnotes-tab" data-toggle="pill" href="#xnotes" role="tab" aria-controls="xnotes" aria-selected="false">
							<span>User Notes</span>
						</a>
					@endif
				</div>
			</div>
   <div class="col-sm-9 col-xl p-0">
    <div class="tab-content wizardContent" id="tabContent">
     <div class="alert-light text-dark pt-3 pl-3 pr-3">
						<div class="row">
							<div class="col mb-3">
								<strong>{{ $user->full_name }}</strong>
								<span class="badge badge-{{ config('eac.user.availableStatus.' . $user->status) }}">
									{{ $user->status }}
								</span>
								<ul class="nav flex-row m-0">
									@if($user->phone && $user->phone->number)
										<li class="nav-item">
											<a href="tel:{{ $user->phone->number }}" class="small" data-toggle="tooltip" data-placement="bottom" title="Call {{ $user->phone->number }}">
												<i class="text-secondary fa-fw fas fa-phone fa-sm fa-rotate-90"></i>
											</a>
										</li>
									@endif
									@if(($user->phone && $user->phone->number) && ($user->email))
										<li class="nav-item pl-2 pr-2 d-none d-sm-block text-secondary">|</li>
									@endif
									@if($user->email)
										<li class="nav-item">
											<a target="_blank" href="mailto:{{ $user->email }}" class="small" data-toggle="tooltip" data-placement="bottom" title="Email {{ $user->email }}">
												<i class="text-secondary fa-fw fas fa-envelope fa-sm"></i>
											</a>
										</li>
									@endif
									@if($user->address)
										<li class="nav-item pl-2 pr-2 d-none d-sm-block text-secondary">|</li>
										<li class="nav-item">
											<a href="#" class="small" data-html="true" data-toggle="popover" data-content=" {!! $user->address->strDisplay() !!}" data-placement="bottom">
												<i class="text-secondary fa-fw fas fa-map-marker-alt fa-sm"></i>
											</a>
										</li>
									@endif
								</ul>
							</div>
							<div class="col-md mb-3">
								<small class="upper d-block">User Type</small>
								<strong>{{ $user->type->name }}</strong>
								@if($user->company)
									<span class="d-inline-block">
										(
										<a href="{{ route('eac.portal.company.show', $user->company->id) }}">{{ $user->company->name }}</a>
										)
									</span>
								@endif
							</div>
							<div class="col-auto mb-3">
								<small class="upper d-block">Created On</small>
								<strong>{{ $user->created_at->format(config('eac.date_format')) }}</strong>
							</div>
						</div>
					</div>
					<div class="tab-pane fade show" id="xdetails" role="tabpanel" aria-labelledby="xdetails-tab">
						<div class="card card-body">
							<div class="row">
								<div class="col col-sm-7 col-md-9 mb-3 mb-xl-2">
									<div class="mb-3 mb-xl-2">
										<strong>{{ $user->full_name }}</strong>
									</div>
									<ul class="nav flex-column flex-sm-row mb-0 mb-xl-1">
										@if($user->phone && $user->phone->number)
											<li class="nav-item">
												<a href="tel:{{ $user->phone->number }}" class="btn btn-link p-0" data-toggle="tooltip" data-placement="bottom" title="Call {{ $user->phone->number }}">
													<i class="text-secondary fa-fw fas fa-phone fa-rotate-90"></i>
													Phone
												</a>
											</li>
										@endif
										@if(($user->phone && $user->phone->number) && ($user->email))
											<li class="nav-item pl-2 pr-2 d-none d-sm-block">|</li>
										@endif
										@if($user->email)
											<li class="nav-item">
												<a target="_blank" href="mailto:{{ $user->email }}" class="btn btn-link p-0" data-toggle="tooltip" data-placement="bottom" title="Email {{ $user->email }}">
													<i class="text-secondary fa-fw fas fa-envelope"></i>
													Email
												</a>
											</li>
										@endif
									</ul>
								</div>
								<div class="col-auto col-sm-5 col-md-3 mb-3 mb-xl-2">
									<span class="badge badge-{{ config('eac.user.availableStatus.' . $user->status) }}">
										{{ $user->status }}
									</span>
								</div>
								<div class="col-sm-7 col-md-9">
									@if(isset($user->address))
										<div class="mb-2">
											{!! $user->address->strDisplay() !!}
										</div>
									@endif
									<div class="row">
										<div class="col-lg-5 mb-3 mb-lg-0">
											<label class="text-muted d-block">User Type</label>
											{{ $user->type->name }}
										</div>
										@if($user->company)
											<div class="col-lg mb-3 mb-sm-0">
												<label class="text-muted d-block">Company</label>
												<a href="{{ route('eac.portal.company.show', $user->company->id) }}">
													{{ $user->company->name }}
												</a>
											</div>
										@endif
									</div>
								</div>
								<div class="col-sm-5 col-md-3">
									<label class="text-muted d-block">Added</label>
									{{ $user->created_at->toDateString() }}
								</div>
							</div>
							@if($user->type->name == "Physician")
								<hr/>
								<h5 class="text-gold mb-2">Professional Documents</h5>
								@if($user->certificate)
									<ul class="m-0">
										@if($user->certificate->cv_file)
											<li>
												Curriculum Vitae/Resume
												@include('include.portal.file-btns', ['id' => $user->certificate->cv_file])
											</li>
										@endif
										@if($user->certificate->medicalLicense)
											<li>
												Medical License
												@include('include.portal.file-btns', ['id' => $user->certificate->license_file])
											</li>
										@endif
									</ul>
								@else
									<p class="text-info m-0">No professional documents to display</p>
								@endif
							@endif
						</div>
					</div><!-- /.tab-pane -->
     @access('rid.info.view')
      <div class="tab-pane fade " id="xassignedRIDs" role="tabpanel" aria-labelledby="xassignedRIDs-tab">
       <div class="card card-body">
        <h4 class="mb-3">
         <strong>Assigned RIDs</strong>
         @if($rids)
          <span class="badge badge-success">{{$user->rids->count()}}</span>
         @endif
        </h4>
        @if($user->rids->count())
         <div class="table-responsive">
          <table class="table table-sm SObasic w-100" id="ridsAssigned">
           <thead>
            <tr>
             <th>RID Number</th>
             <th>Date</th>
            </tr>
           </thead>
           <tbody>
            @foreach($user->rids as $rid)
             <tr>
              <td>
               <a href="{{$rid->view_route}}">{{$rid->number}}</a>
              </td>
              <td class="text-right">
               {{date('Y-m-d', strtotime($rid->created_at))}}
              </td>
             </tr>
            @endforeach
           </tbody>
          </table>
         </div>
        @else
         <p class="text-muted m-0">
          <i class="fal fa-info-circle"></i>
          No Accessible Rids
         </p>
        @endif
       </div>
      </div>
     @endif
     @access('drug.info.view')
      <div class="tab-pane fade " id="xassignedDrugs" role="tabpanel" aria-labelledby="xassignedDrugs-tab">
       <div class="card card-body">
        <h4 class="mb-3">
         <strong>Assigned Drugs</strong>
         @if($drugs)
          <span class="badge badge-success">{{$drugs->count()}}</span>
         @endif
        </h4>
        @if($drugs->count())
         <div class="table-responsive">
          <table class="table table-sm SObasic w-100" id="drugsAssigned">
           <thead>
            <tr>
             <th>Drug</th>
             <th>Date</th>
            </tr>
           </thead>
           <tbody>
            @foreach($drugs as $drug)
             <tr>
              <td>
               <a href="{{$drug->view_route}}">{{$drug->name}}</a>
              </td>
              <td class="text-right">
               {{date('Y-m-d', strtotime($drug->created_at))}}
              </td>
             </tr>
            @endforeach
           </tbody>
          </table>
         </div>
        @else
         <p class="text-muted m-0">
          <i class="fal fa-info-circle"></i>
          No Accessible Drugs
         </p>
        @endif
       </div>
      </div>
     @endif
					<div class="tab-pane fade " id="xgroups" role="tabpanel" aria-labelledby="xgroups-tab">
      <div class="card card-body">
       <h4 class="mb-3">
        <strong>User Groups</strong>
        @if($user->groups())
         <span class="badge badge-dark">{{$user->groups()->count()}}</span>
        @endif
       </h4>
       @if($user->groups()->count())
        <div class="row">
         @foreach($user->groups()->sortBy('name') as $userGroup)
          <div class="col-sm-6 mb-3">
           <div class="card border-light bs-no border">
            <div class="card-header p-2 text-sm-center">
             <div>
              <strong>{{$userGroup->name}}</strong> <small>({{$userGroup->type->name}} Group)</small>
             </div>
             @if($userGroup->parent())
              <div class="small ml-3 ml-sm-0">
               <a href="{{ route('eac.portal.user.show', $user->id) }}" class="btn btn-link btn-sm">
                {{$userGroup->parent->full_name}}
               </a>
               <small class="badge badge-success">Group Lead</small>
              </div>
             @endif
            </div>
            <div class="card-body p-2">
             <ul class="list-group list-group-flush mb-0">
              <!-- Group leader -->
             <!-- member -->
              @foreach($userGroup->users()->sortBy('first_name') as $user)
               @if($user)
                <li class="list-group-item">
                 <a href="{{ route('eac.portal.user.show', $user->id) }}" class="btn btn-link btn-sm">
                  {{$user->full_name}}
                 </a>
                 <small class="d-block">
                  {{$userGroup->roleInTeam($user->id)->name}}
                  @if($user->id == $userGroup->parent_user_id)
                   <span class="badge badge-success">Group Lead</span>
                  @endif
                 </small>
                </li>
               @endif
              @endforeach
             </ul>
            </div>
           </div>
          </div>
         @endforeach
        </div>
       @else
        <p class="text-muted m-0">
         <i class="fal fa-info-circle"></i>
         No information available
        </p>
       @endif
      </div>
					</div><!-- /.tab-pane -->
     @access('user.note.view')
 					<div class="tab-pane fade " id="xnotes" role="tabpanel" aria-labelledby="xnotes-tab">
 						<div class="card-body">
 							<h5 class="">
 								User Notes </h5>
 							@if($user->notes->count() > 0)
 								<ul class="list-group m-0 list-group-flush">
 									@foreach($user->notes->sortBy('created_at') as $note)
 										<li class="list-group-item pt-2 pl-0 pr-0 pb-2">
 											<label class="d-block">
 												<a href="{{ route('eac.portal.user.show', $note->author->id) }}">
 													{{ $note->author->full_name ?? 'N/A' }}
 												</a>
 												<small>{{ $note->created_at->format('Y-m-d  h:m A') }}</small>
 											</label>
 											<p class="m-0">{{ $note->text }}</p>
 										</li>
 									@endforeach
 								</ul>
 							@else
 								<p class="text-muted mb-0">
 									<i class="fal fa-info-circle"></i>
 									No information available
 								</p>
 							@endif
 						</div>
 					</div>
					@endif
				</div>
			</div>
		</div>
	</div><!-- /.viewData -->
@endsection
@section('scripts')
	<script type="text/javascript">
        // Data Tables
        $(document).ready(function () {
            $('#assocRidListTBL tfoot th').each(function () {
                if ($(this).hasClass("no-search")) {
                    $(this).text("");
                    return;
                }
                var title = $(this).text();
                $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" />');
            });


            var dataTable = $('#assocRidListTBL').DataTable({
                "paginationDefault": 10,
                "paginationOptions": [10, 25, 50, 75, 100],
// "responsive": true,
                'order': [[0, 'desc']],
                "ajax": {
                    url: "{{route('eac.portal.user.ajax.rid.list', $user->id)}}",
                    type: "post"  // method  , by default get
                },
                "processing": true,
                "serverSide": true,
                "columns": [
// {"data": "req_date"},
                    {"data": "number", "name": "number"},
// {"data": "visits"},
                    {"data": "status"},
                    {"data": "physician_name"},
                    {"data": "drug_name"},
                    {"data": "ops_btns", orderable: false},
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
     text: "There was an error understanding this request. If this issue persists, <a href="mailto:{{site()->email}}">click her</a> to contact us.",
     icon: "warning",
    });
   };

        }); // end doc ready
	</script>
@endsection
