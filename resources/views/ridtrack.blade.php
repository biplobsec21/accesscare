@extends("layouts.public_app")

@section('styles')
 <style>
  @media screen and (min-width: 769px) {
   #content {
    min-height: 80vh;
   }
  }
  .badge {
   font-size: 15px;
  }
 </style>
@endsection

@section('title')
 Track RID
@endsection

@section('content')
 <h2 class="mb-3 mb-xl-5">
  <small class="d-block">Viewing Request:</small>
  {{Session::get('userName')}}
  <span class="badge badge-info">
   {{ \App\RidStatus::where('id','=',$visit->status_id)->firstOrFail()->name }}
  </span>
 </h2>
 <div class="row">
  <div class="col-sm">
   <div class="card shadow card-body">
    <div class="row">
     <div class="col-sm mb-3 mb-sm-0">
      <h5 class="mb-3 text-gold">Request Information</h5>
      <ul class="list-unstyled mb-0">
       <li class=" d-none">
        <label class="d-block mb-0 text-muted small upper">Rid Number</label>
        {{$rid->number}}
       </li>
       <li class="mb-2">
        <label class="d-block mb-0 text-muted small upper">Requested By</label>
        {{ $rid->physician->full_name }}
       </li>
       <li class="mb-2">
        <label class="d-block mb-0 text-muted small upper">Requested Date</label>
        {{ $rid->req_date }}
       </li>
       {{-- 
        <li class="list-group-item">
         <label class="d-block mb-0 text-muted small upper">Assigned To</label>
       	 @foreach($rid->assignedUsers as $ridUser)	
    				 {{$ridUser->user->full_name}}			
    				 @endforeach
        </li>
       --}}
      </ul>
     </div>
     <div class="col-sm mb-3 mb-sm-0">
      <h5 class="mb-3 text-gold">Drug Requested</h5>
      <ul class="list-unstyled mb-0">
       <li class="mb-2">
        <label class="d-block mb-0 text-muted small upper">Drug Name</label>
        {{ $rid->drug->name }}
       </li>
       <li class="mb-2">
        <label class="d-block mb-0 text-muted small upper">Manufactured By</label>
        {{ $rid->drug->company->name }}
       </li>
      </ul>
     </div>
     <div class="col-sm mb-3 mb-sm-0">
      <h5 class="mb-3 text-gold">Regimen &amp; Frequency</h5>
      @if(!$visit)
        Not Available
      @elseif($visit->shipment)
       @if($visit->shipment->regimen->count() > 0)
        <ul class="list-unstyled mb-0">
         @php $regimen_index = 0; @endphp
         @foreach($visit->shipment->regimen as $regimen)
          <li class="mb-2">
           @php $regimen_index++; @endphp
           @if($regimen->lot)
            <div class="row m-0 align-items-center">
             <div class="col-auto p-0">
              <small class="upper text-info strong p-1 border border-info">{{$component->name}}</small>
             </div>
             <div class="col-md pr-0">
              {{$regimen->quantity}} {{$regimen->lot->dosage->form->name}}
              every {{$regimen->frequency}} for {{$regimen->length}}
             </div>
            </div>
           @endif
          </li>
         @endforeach
        </ul>
       @else
        <em class="text-muted">Not Available</em>
       @endif
      @endif
     </div>
    </div><!-- /.row -->
   </div>
  </div>
  <div class="col-sm-4">
   <div class="card card-body text-dark alert-light border-light mb-0 h-100">
    <h5 class="mb-3 text-gold">Shipping Information</h5>
    @php $visit_index = 1; @endphp
    @if(!$visit)
     <ul class="list-unstyled mb-0">
      <li class="mb-2">
       <label class="d-block mb-0 text-secondary small upper">Destination</label>
       @if($visit->shipment->depot)
        {!! $visit->shipment->depot->address->strDisplay()!!}
       @else
        <span class="text-muted">N/A</span>
       @endif
      </li>
      <li class="mb-2">
       <label class="d-block mb-0 text-secondary small upper">Courier</label>
   				@if($visit->shipment->depot)
   					@if($visit->shipment->courier_id)
   						{{ $visit->shipment->courier_id }}
        @else
         <span class="text-muted">N/A</span>
        @endif
   				@endif
      </li>
      <li class="mb-2">
       <label class="d-block mb-0 text-secondary small upper">Tracking Number</label>
   				@if($visit->shipment->depot)
   					@if($visit->shipment->tracking_number)
   						{{ $visit->shipment->tracking_number }}
        @else
         <span class="text-muted">N/A</span>
        @endif
   				@endif
      </li>
      <li class="mb-2">
       <label class="d-block mb-0 text-secondary small upper">Expected Delivery Date</label>
   				@if($visit->shipment->depot)
       	@if($visit->shipment->deliver_by_date)
   						{{ $visit->shipment->deliver_by_date }}
        @else
   						<span class="text-muted">N/A</span>
   					@endif
   				@endif
      </li>
     </ul>
    @php $visit_index ++; @endphp
    @else
     <em class="text-muted">Not Available</em>
    @endif
   </div>
  </div>
 </div><!-- /.row-->
@endsection
