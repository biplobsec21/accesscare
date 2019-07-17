<h5 class="text-gold mb-2">Patient Information</h5>
@if(isset($rid->patient_dob))
<div class="mb-2">
	<label class="d-block">Patient Date of Birth</label>
	{{ $rid->patient_dob }} (age: {{ $rid->getPatientAge() }})
</div>
@endif

@if(isset($rid->patient_gender))
<div class="mb-2">
	<label class="d-block">Patient Gender</label>
	{{ $rid->patient_gender }}
</div>
@endif

@if(isset($rid->ethnicity->name))
<div class="mb-2">
	<label class="d-block">Patient Ethnicity</label>
	{{ $rid->ethnicity->name }}
</div>
@endif

@if(isset($rid->patient_weight))
<div class="mb-2">
	<label class="d-block">Patient Weight (KG)</label>
	{{ $rid->patient_weight }}
</div>
@endif

@if(isset($rid->patient_country))
<div class="mb-2">
	<label class="d-block">Country of Residence</label>
	{{ $rid->patient_country->name }}
</div>
@endif

@if(isset($rid->reason))
<div class="mb-2">
	<label class="d-block">Reason for Request</label>
	{{ $rid->reason }}
</div>
@endif