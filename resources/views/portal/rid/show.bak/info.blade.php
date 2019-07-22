@php
 if($rid->status_id) { 
  $bColor = '';
  if($rid->status->name == 'New') {
   $bColor = 'light';
  } // endif
  if($rid->status->name == 'Reviewed') {
   $bColor = 'info';
  } // endif
  if($rid->status->name == 'Ongoing') {
   $bColor = 'success';
  } // endif
  if($rid->status->name == 'Completed') {
   $bColor = 'primary';
  } // endif
  if($rid->status->name == 'Discontinued') {
   $bColor = 'dark';
  } // endif
  if($rid->status->name == 'On Hold') {
   $bColor = 'danger';
  } // endif
 } // endif
@endphp

<h5 class="text-gold mb-2 d-none d-sm-block">RID Information</h5>
<div class="mb-2">
 <label class="d-block">RID Number</label>
 {{ $rid->number }}
</div>
<div class="mb-2">
 <label class="{{-- d-block --}} d-none">Status</label>
 @if($rid->status_id)<span class="badge badge-{{$bColor}}">{{$rid->status->name}}</span>@endif
</div>
<div class="mb-2">
 <label class="d-block">Requested By</label>
 {{ $rid->physician->full_name }}
</div>
<div class="mb-2">
 <label class="d-block">Request Date</label>
 {{ $rid->req_date }}
</div>
<div class="mb-2">
	<label class="d-block">Shipping To</label>
	@if($rid->physician->address)
	@php 
		$country = $rid->physician->address->country;
	@endphp 
	<a href="#" data-toggle="modal" data-target="#Modal{{$country->id}}" >
		{{ $country->name}}
	</a>
	@include('include.portal.modals.rid.country.available_country', $country)
	@else 
	No data available
	@endif
	
</div>
