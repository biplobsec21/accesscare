<div class="alert-light text-dark pt-3 pl-3 pr-3">
	<div class="row">
		<div class="col-md mb-3">
			<div class="row align-items-end">
				<div class="col">
					<small class="upper d-block mb-1 mb-md-0">Visit Date</small>
					@if($visit->visit_date)
						<strong>{{ \Carbon\Carbon::parse($visit->visit_date)->format(config('eac.date_format')) }}</strong>
					@else
						<span class="text-secondary">N/A</span>
					@endif
				</div>
				<div class="col">
					<span class="badge badge-{{$bColor}}">{{ $visit->status->name }}
						- {{ $visit->subStatus->name }}</span><br/>
					@access('rid.info.update')
					<a href="#" class="btn btn-link btn-sm pt-0 pb-0" data-toggle="modal" data-target="#StatusChange">
						Edit
					</a>
					@endif
				</div>
			</div>
		</div>
		<div class="col-md-5 col-lg-7 col-xl-6 mb-3">
			<div class="row">
				<div class="col-sm col-md-12 col-lg">
					<small class="upper d-block mb-xl-1">Assigned To</small>
					@if($visit->physician)
						<strong>{{$visit->physician->full_name}}</strong>
					@else
						<span class="text-muted">N/A</span>
					@endif
				</div>
				<div class="col-sm col-md-12 col-lg col-xl-auto">
					<small class="upper d-block mb-xl-1">Created On</small>
					<strong>{{ $visit->created_at->format(config('eac.date_format')) }}</strong>
				</div>
			</div>
		</div>
	</div>
</div>
@include('include.portal.modals.rid.status.edit')
