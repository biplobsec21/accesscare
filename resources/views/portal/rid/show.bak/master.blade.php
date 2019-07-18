<div class="masterBox mb-3 mb-xl-5">
	<ul class="nav nav-tabs" id="RequestTabs" role="tablist">
		<li class="nav-item">
			<a class="nav-link active" id="master-tab" data-toggle="tab" href="#master" role="tab"
			   aria-controls="master"
			   aria-selected="true">
				Request Details
			</a>
		</li>
		@access('rid.user.view')
			<li class="nav-item">
				<a class="nav-link" id="users-tab" data-toggle="tab" href="#users" role="tab" aria-controls="users"
				   aria-selected="false">
					Assigned Groups
				</a>
			</li>
		@endif
		@access('rid.drug.view')
			<li class="nav-item">
				<a class="nav-link" id="drug-tab" data-toggle="tab" href="#drug" role="tab" aria-controls="drug"
				   aria-selected="false">
					Reference Documents
				</a>
			</li>
		@endif
	</ul>
	<div class="tab-content" id="RequestTabsContent">
		@access('rid.index.update')
			<div class="bg-gradient-primary text-white p-3">
				<div class="row">
					<div class="col-sm">
						<h5 class="mb-0 strong d-inline-block">Viewing RID: {{ $rid->number }}</h5>
						<a href="{{ route("eac.portal.rid.edit", $rid->id) }}" class="small"
						   style="color: var(--yellow)">
							[edit RID]
						</a>
					</div>
					<div class="col-sm col-lg-auto">
						<h5 class="mb-0 strong">Status: <span class="upper">{{$rid->status->name}}</span></h5>
					</div>
				</div>
			</div>
		@endif
		<div class="tab-pane fade active show" id="master" role="tabpanel" aria-labelledby="master-tab">
			<div class="card card-body mb-0 poppins">
				<div class="row">
					<div class="col-lg-6 col-xl-4">
						@access('rid.drug.view')
							<div class="mb-2">
								<strong>Drug:</strong>
								<a href="{{ route('eac.portal.drug.show', $rid->drug->id) }}">
									{{ $rid->drug->name }}
								</a> ({{$rid->drug->lab_name}})
								<span> -
									<a href="{{ route('eac.portal.company.show', $rid->drug->company->id) }}">
										{{ $rid->drug->company->name }}
									</a>
								</span>
							</div>
						@endif
						@access('rid.info.view')
							<div class="mb-2">
								<strong>Request Date:</strong>
								{{ \Carbon\Carbon::parse($rid->req_date)->format(config('eac.date_format')) }}
							</div>
							<div class="mb-2">
								<strong>Requested By:</strong>
								{{ $rid->physician->full_name }}
							</div>
							@if($rid->physician->address)
								<div class="mb-2">
									<strong>Ship To:</strong>
									@php
										$country = $rid->physician->address->country;
									@endphp
									{{ $country->name}}
									<a href="#" data-toggle="modal" data-target="#Modal{{$country->id}}">
										<span class="fal fa-info-circle"></span>
									</a>
									@include('include.portal.modals.rid.country.available_country', $country)
								</div>
							@endif
						@endif
						@access('rid.drug.view')
							@php
								$available_country = \App\Rid::where('rids.id','=', $rid->id)->Leftjoin('drug', 'drug.id', '=', 'rids.drug_id')->groupBy('rids.id')->select(['drug.countries_available as countries','drug.pre_approval_req as pre_approval_req'])->firstOrFail();
							@endphp
							@php $con = json_decode($available_country->countries, true); @endphp
							<div class="mb-2">
								<strong>Pre-Approval Req:</strong>
								@if($available_country->pre_approval_req == 0)
									NO
								@else
									YES
								@endif
							</div>
						@endif
					</div>
					<div class="col-lg-6 col-xl-4">
						@access('rid.patient.view')
							<div class="mb-2">
								<strong>Patient:</strong>
								{{ $rid->patient_gender }}, age {{ $rid->getPatientAge() }}
								({{ \Carbon\Carbon::parse($rid->patient_dob)->format(config('eac.date_format')) }})
							</div>
							@if(isset($rid->reason))
								<div class="mb-2">
									<strong>Reason for Request:</strong>
									{{ $rid->reason }}
								</div>
							@endif
							@if($rid->proposed_treatment_plan)
								<div class="mb-2">
									<strong>Proposed Treatment:</strong>
									{{ $rid->proposed_treatment_plan }}
								</div>
							@endif
						@endif
					</div>
					<div class="d-none d-xl-block col-xl-4">
						@access('rid.note.view')
							@if($rid->notes->count() > 0)
        <div id="noteSlider" class="carousel slide" data-ride="carousel">
         @php $i = 0; @endphp
         <div class="carousel-inner">
          @foreach($rid->notes as $note)
           @php $i++ @endphp
           <div class="carousel-item @if($i == 1) active @endif">
            <label class="d-block mb-2">
             @if($i == 1)
              Last Note:
             @endif
             {{ $note->created_at->format('d M, Y') }}
             ({{ $note->author->full_name ?? 'N/A' }})
            </label>
            <p class="m-0">{{ $note->text }}</p>
           </div>
          @endforeach
         </div>
         <div class="row">
          <div class="col-auto">
           <a class="" href="#noteSlider" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
            <
           </a>
          </div>
          <div class="col text-center">
           {{$rid->notes->count()}} Total Notes
          </div>
          <div class="col-auto">
           <a class="" href="#noteSlider" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
            >
           </a>
          </div>
         </div>
        </div>
							@else
								<p class="text-muted mb-0">No note to display</p>
							@endif
						@endif
					</div>
				</div><!-- /.row -->
				<div class="row d-none">
					<div class="col-sm-6 col-md-12 col-lg">
						@access('rid.info.view')
							@include('portal.rid.show.info')
						@endif
					</div>
					<div class="col-sm-6 col-md-12 col-lg">
						@access('rid.patient.view')
							<hr class="d-sm-none mt-2 mb-2"/>
							@include('portal.rid.show.patient')
						@endif
					</div>
					<div class="col-sm-6 col-md-12 col-lg">
						@access('rid.drug.view')
							@include('portal.rid.show.drug')
						@endif
					</div>
				</div>
			</div>
			<div class="bg-gradient-primary text-white p-3">
				<div class="{{-- actionBar --}}">
					<div class="row">
						<div class="col-sm-auto col-lg">
							<a href="{{ route("eac.portal.rid.list") }}" class="btn btn-light">
								RID List
							</a>
						</div>
						<div class="col-sm col-lg-auto ml-lg-auto">
							<a href="#" class="btn btn-success ml-xl-3" data-toggle="modal"
							   data-target="#RidNoteAdd">
								<i class="fa fa-plus"></i> Add Note
							</a>
							<a href="{{ route("eac.portal.rid.edit", $rid->id) }}" class="btn btn-info ml-xl-3">
								<i class="fa-fw fas fa-edit"></i> Edit RID Master
							</a>
							<a title="Schedule Dates"
							   class="btn btn-info ml-xl-3 @if(!$rid->visits->count()) disabled @endif"
							   href="{{route('eac.portal.rid.resupply', $rid->id)}}">
								<i class="fa-fw fas fa-redo"></i> Add Visits
							</a>
							@if(true)
								<a title="" href="{{route('eac.portal.rid.postreview', $rid->id)}}"
								   class="btn btn-info ml-xl-3">
									<i class="fa-fw fas fa-upload"></i> Post Approval Documents
								</a>
							@endif
						</div>
					</div><!-- /.row -->
				</div>
			</div>
		</div>
		@access('rid.drug.view')
			<div class="tab-pane fade" id="drug" role="tabpanel" aria-labelledby="drug-tab">
				<div class="card card-body mb-3">
					<h5 class="mb-3">Reference Documents</h5>
					@if($rid->drug->resources->count() > 0)
						<ul class="">
							@foreach($rid->drug->resources->sortBy('name') as $resource)
							@if($resource->active)
								<li class="">
									<a href="{{ route('eac.portal.file.download', $resource->file_id) }}" class="">
										{{ $resource->name }}
									</a>
									<p class="small mb-0">
										{{-- {{$resource->desc}} --}}
										{!! $resource->desc ? $resource->desc : '<br> ' !!}
									</p>
								</li>
								@endif
							@endforeach
						</ul>
					@else
						<p class="text-muted mb-0">Information unavailable</p>
					@endif
				</div>
			</div>
		@endif
		@access('rid.user.view')
			<div class="tab-pane fade" id="users" role="tabpanel" aria-labelledby="users-tab">
				<div class="card card-body">
					<h5 class="mb-3">Assigned Groups</h5>
					@if($rid->user_groups->count() > 0)
						@include('portal.rid.show.users')
					@else
						<p class="text-muted mb-0">Information unavailable</p>
					@endif
				</div>
			</div>
		@endif
	</div>
</div>

<div class="modal fade" id="RidNoteAdd" tabindex="-1" role="dialog" aria-hidden="true">
	<form method="post" action="{{ route('eac.portal.note.create') }}">
		{{ csrf_field() }}
		<input type="hidden" name="subject_id" value="{{$rid->id}}">
		<div class="modal-dialog modal-dialog-centered " role="document">
			<div class="modal-content">
				<div class="modal-header p-2">
					<h5 class="m-0">
						Add Note to <strong>RID
							: {{ $rid->number }}</strong>
					</h5>
					<button type="button" class="close" data-dismiss="modal"
							aria-label="Close">
						<i class="fal fa-times"></i>
					</button>
				</div>
				<div class="modal-body p-3">
					<label
						class="d-block">{{ \Auth::user()->first_name }} {{ \Auth::user()->last_name }}
						<small>{{date('Y-m-d H:i')}}</small>
					</label>
					<textarea name="text" class="note_text form-control" rows="3"
							  placeholder="Enter note..."></textarea>
				</div>
				<div class="modal-footer p-2 d-flex justify-content-between">
					<button type="button" class="btn btn-secondary"
							data-dismiss="modal" tabindex="-1">Cancel
					</button>
					<button type="submit" name="submit" class="btn btn-success"
							value="Add Note">Submit
					</button>
				</div>
			</div>
		</div>
	</form>
</div>
