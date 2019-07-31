
<div class="mb-2">
 <strong class="d-block">Patient</strong>
 @if(isset($rid->patient_gender)) {{ $rid->patient_gender }}, @endif 
 @if(isset($rid->patient_dob)) age {{ $rid->getPatientAge() }}
  ({{ $rid->patient_dob }})
 @endif
</div>
@if(isset($rid->patient_weight))
 <div class="mb-2">
  <strong class="d-block">Patient weight</strong>
  {{ $rid->patient_weight }}KG
 </div>
@endif
{{-- @if(isset($rid->ethnicity->name))
 <div class="mb-2">
  <strong class="d-block">Patient Ethnicity</strong>
  {{ $rid->ethnicity->name }}
 </div>
@endif --}}
@if(isset($rid->reason))
 <div class="mb-2">
  <strong class="d-block">Reason for Request</strong>
  {{ $rid->reason }}
 </div>
@endif
@if($rid->proposed_treatment_plan)
 <div class="mb-2">
  <strong class="d-block">Proposed Treatment</strong>
  {{ $rid->proposed_treatment_plan }}
 </div>
@endif

