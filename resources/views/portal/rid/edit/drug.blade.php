<h5 class="mb-3">
 Requested <strong>drug</strong> information
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
<div class="row d-none">
	@php
		$available_country = \App\Rid::where('rids.id','=', $rid->id)->Leftjoin('drug', 'drug.id', '=', 'rids.drug_id')->groupBy('rids.id')->select(['drug.countries_available as countries','drug.pre_approval_req as pre_approval_req'])->firstOrFail();
		$con = json_decode($available_country->countries, true);
	@endphp
	@if($available_country->countries && $available_country->countries != '0' && $available_country->countries != 'null')
  <div class="col-lg-7 col-xl-8 mb-3">
   <label class="d-block">Available Countries</label>
 		@foreach($con as $key=>$cdata)
 			@php $country = \App\Country::where('id','=', $cdata)->first(); @endphp
 			@if($country)
     @if(($country->haa_info) || ($country->notes))
  				<span class="mr-1">
       <a href="#" class="" data-toggle="modal" data-target="#Modal{{$country->id}}">{{$country->name}}</a>,
      </span>
  				@include('include.portal.modals.rid.country.available_country', $country)
     @else
      <span class="mr-1">{{$country->name}},</span>
     @endif
 			@endif
 		@endforeach
  </div>
 @endif
 <div class="col-lg">
  <label class="d-block">Pre-Approval Required</label>
  @if($available_country->pre_approval_req == 0)
   <span class="badge p-0">
    NO
   </span>
  @else
   <span class="badge p-0">
    YES
   </span>
  @endif
 </div>
</div>

<div class="mb-2">
 <label class="d-block">Proposed Treatment Plan</label>
 <textarea name="proposed_treatment_plan" class="form-control">{{ $rid->proposed_treatment_plan }}</textarea>
</div>
