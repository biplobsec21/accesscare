<h5 class="mb-3">
	Requested
	<strong>drug</strong>
	information
</h5>
<div class="row">
	<div class="col-lg mb-3">
		<label class="d-block">Drug Requested</label>
		<a href="{{ route('eac.portal.drug.show', $rid->drug->id) }}">
			{{ $rid->drug->name }}
		</a>
		({{$rid->drug->lab_name}})
	</div>
	<div class="col-lg mb-3">
		<label class="d-block">Manufactured By</label>
		<a href="{{ route('eac.portal.company.show', $rid->drug->company->id) }}">
			{{ $rid->drug->company->name }}
		</a>
	</div>
</div>

<div class="mb-2">
	<label class="d-block">Proposed Treatment Plan</label>
	<textarea name="proposed_treatment_plan" class="form-control">{{ $rid->proposed_treatment_plan }}</textarea>
</div>
