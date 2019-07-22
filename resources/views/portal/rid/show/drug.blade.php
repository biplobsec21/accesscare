<h5 class="text-gold mb-2">Drug Information</h5>
<div class="mb-2">
	<label class="d-block">Investigational Drug</label>
	<a href="{{ route('eac.portal.drug.show', $rid->drug->id) }}">
		{{ $rid->drug->name }}
	</a>
</div>
<div class="mb-2">
	<label class="d-block">Lab Name</label>
	{{ $rid->drug->lab_name}}
</div>
<div class="mb-2">
	<label class="d-block">Proposed Treatment Plan</label>
	{{ $rid->proposed_treatment_plan }}
</div>
<div class="mb-2">
	<label class="d-block">Manufactured By</label>
	<a href="{{ route('eac.portal.company.show', $rid->drug->company->id) }}">
		{{ $rid->drug->company->name }}
	</a>
</div>
<div class="mb-2">
	@php
		$countries = $rid->drug->countries;
	@endphp
	<label class="d-block">Available Countries</label>
	@if($countries)
		@foreach($countries as $key=>$cdata)
			@php $country = \App\Country::where('id','=', $cdata)->first(); @endphp
			@if($country)
				<a href="#" data-toggle="modal" data-target="#Modaldrug{{$country->id}}">
					{{$country->name}}
				</a>
				@include('include.portal.modals.drugs.country.available_country', $country)
			@endif
		@endforeach
	@else
		<small class="text-muted">N/A</small>
	@endif
</div>
<div class="mb-2">
	<label class="d-block">Pre-Approval Required</label>
	@if($rid->drug->pre_approval_req)
		<span class="badge badge-light">No</span>
	@else
		<span class="badge badge-dark">Yes</span>
	@endif
</div>
