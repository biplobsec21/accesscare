<div class="alert-light text-dark pt-3 pl-3 pr-3">
	<div class="row">
		<div class="col-md mb-3">
			<div class="row align-items-end">
				<div class="col-auto col-md-12 col-lg-auto">
					<small class="upper d-block">RID Number</small>
					<strong>{{ $rid->number }}</strong>
				</div>
				<div class="col-auto col-md-12 col-lg-auto">
					@if($rid->status)<span
						class="badge badge-{{$rid->status->badge}}">{{$rid->status->name}}</span>@endif
				</div>
			</div>
		</div>
		<div class="col-md mb-3">
			<div class="row">
				<div class="col col-md-12 col-lg">
					<small class="upper d-md-inline d-lg-block d-block">Request By<span
							class="d-none d-md-inline d-lg-none">:</span></small>
					<strong>{{ $rid->physician->full_name }}</strong>
				</div>
				<div class="col col-md-12 col-lg">
					<small class="upper d-md-inline d-lg-block d-block">Request Date<span
							class="d-none d-md-inline d-lg-none">:</span></small>
					<strong>{{ \Carbon\Carbon::parse($rid->req_date)->format(config('eac.date_format')) }}</strong>
				</div>
			</div>
		</div>
	</div>
</div>
