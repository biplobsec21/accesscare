<h5 class="mb-3">
	Patient Information </h5>
<div class="row">
	<div class="col-md-4 mb-3">
		<label class="d-block">Date of Birth</label>
		{{ \Carbon\Carbon::parse($rid->patient_dob)->format(config('eac.date_format')) }}
		<a href="#" class="btn btn-link btn-sm ml-2" data-toggle="modal" data-target="#DOBModal{{$rid->id}}">
			Edit
		</a>
	</div>
	<div class="col col-md-4 mb-3">
		<label class="d-block">Gender</label>
		<select name="patient_gender" class="form-control">
			<option value="male" @if($rid->patient_gender === 'Male') selected @endif>Male</option>
			<option value="female" @if($rid->patient_gender === 'Female') selected @endif>Female</option>
		</select>
	</div>
	<div class="col col-md-4 mb-3">
		<label class="d-block">Weight (KG)</label>
		<input type="text" class="form-control" name="patient_weight" value="{{ $rid->patient_weight }}"/>
	</div>
</div>
<div class="row">
	<div class="col-md-4 mb-3">
		<label class="d-block">Ethnicity</label>
		<select name="patient_ethnicity" class="select2 form-control">
			<option hidden value="">-- Select --</option>
			@foreach($ethnicities as $ethnicity)
				<option value="{{ $ethnicity->id }}" @if($rid->patient_ethnicity == $ethnicity->id) selected @endif>{{ $ethnicity->name }}</option>
			@endforeach
		</select>
	</div>
	<div class="col-md mb-3">
		<label class="d-block">Race (select all the apply)</label>
		<select multiple name="patient_race" id="patient_race" class="select2 form-control">
			@foreach(App\Race::all()->sortBy('name') as $race)
				<option value="{{ $race->id }}" @if($rid->race->contains($race)) selected @endif>{{ $race->name }}</option>
			@endforeach
		</select>
	</div>
</div>
<div class="mb-3">
	<label class="d-block">Diagnosis and Reason for Compassionate Use</label>
	<textarea name="reason" class="form-control" rows="4">{{ $rid->reason }}</textarea>
</div>
