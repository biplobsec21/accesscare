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

<div class="mb-2">
 <strong class="d-block">Request Date</strong>
 {{ \Carbon\Carbon::parse($rid->req_date)->format(config('eac.date_format')) }}
</div>
<div class="mb-2">
 <strong class="d-block">Requested By</strong>
 @if(\Auth::user()->type->name == 'Early Access Care')
  <a href="{{route('eac.portal.user.show', $rid->physician->id)}}">
   {{ $rid->physician->full_name }}
  </a>
 @else
  {{ $rid->physician->full_name }}
 @endif
</div>
@if($rid->physician->address)
 <div class="mb-2">
  <strong class="d-block">Ship To</strong>
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
@endif