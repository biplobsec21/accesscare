@extends('layouts.portal')

@section('title')
 Edit RID / Edit Visit (MOCKUP)
@endsection

@section('styles')
 <style>
   .stepPro {
    list-style: none;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    font-family: 'Poppins';
    margin: 0;
    padding: 0;
   }
   .stepPro > li:first-of-type, .stepPro > div:first-of-type {
    border-radius: 4px;
   }
   .stepPro > li, .stepPro > div {
    min-height: 80px;
    /*-ms-flex-align: center;*/
    align-items: center;
    /*-ms-flex-pack: center;*/
    justify-content: center;
    flex-direction: column;
    /*display: -ms-flexbox;*/
    display: flex;
    /*-ms-flex-preferred-size: 0;*/
    flex-basis: 0;
    /*-ms-flex-positive: 1;*/
    flex-grow: 1;
    padding-left: 1rem;
    padding-right: 1rem;
    text-align: center;
    padding: .4rem;
    position: relative;
    margin: .15rem 0;
   }
  @media screen and (min-width: 1500px) {
   .stepPro > li, .stepPro > div {
    padding: .4rem .4rem .4rem 25px;
   }
   .stepPro > li:after, .stepPro > div:after,
   .stepPro > li:not(:last-of-type):before, .stepPro > div:not(:last-of-type):before {
    content: '';
    position: absolute;
    display: block;
    height: 0;
    width: 0;
   }

   .stepPro > li:after, .stepPro > div:after {
    border: 40px solid transparent;
    border-right-width: 0;
    border-left-width: 20px;
    border-left-color: #F6F8FC;
    z-index: 2;
    right: -20px;
    top: 0;
   }
   /*
   .stepPro > li:not(:last-of-type):before, .stepPro > div:not(:last-of-type):before {
    border: 42px solid transparent;
    border-right-width: 0;
    border-left-width: 22px;
    border-left-color: #fff;
    z-index: 1;
    right: -22px;
    top: -2px;
   }
   */
   .stepPro > li.completed:after, .stepPro > div.completed:after {
    border-left-color: #dcf5ce;
   }

   .stepPro > li.inprogress:after, .stepPro > div.inprogress:after {
    border-left-color: #024e82;
   }
  }
  .stepPro small, .stepPro .small {
   display: block;
  }
  .stepPro strong, .stepPro .strong {
   font-size: 1.1rem;
   font-weight: 500;
  }
  .completed {
   background-color: #DCF5CE;
   color: #96C17E;
   position: relative;
  }
  .completed a:not(.btn) {color: #96C17E;}

  .inprogress {
   background-color: #024e82;
   color: #fff;
  }
  .inprogress a:not(.btn) {color: #fff;}
  .notavail {
   background-color: #F6F8FC;
   color: #BBBFD2;
  }
  .notavail a:not(.btn) {color: #BBBFD2;}
 </style>
@endsection

@php
 $bColor = $visit->status->badge;
@endphp

@section('content')
 <div class="titleBar">
  <div class="row">
   <div class="col">
    <h6 class="small upper m-0">
     Edit RID
    </h6>
    <h2 class="mb-0 mono">{{ $rid->number }}</h2>
   </div>
   <div class="col-auto">
    <div class="pt-1 pb-1 pl-2 pr-2 bg-gradient-dark text-white mb-0">
     <small>Status:</small>
     {{$rid->status->name}}
    </div>
   </div>
  </div>
 </div><!-- end .titleBar -->
 <div class="viewData">
  <div class="row">
   <div class="col-xl-9">
    <div class="actionBar mb-3">
     <a href="{{route('eac.portal.rid.show', $rid->id)}}" class="btn btn-light">
      View RID
     </a>
     <a href="{{route('eac.portal.rid.show', $rid->id)}}" class="ml-xl-auto btn btn-warning">
      <i class="fal fa-times"></i>
      Cancel
     </a>{{-- added per request RP --}}
    </div><!-- end .actionBar -->
    @access('rid.visit.view')
     @if($rid->shipments->count() > 0)
      <div class="accordion mb-xl-5" id="shipmentX">
       @php $shipment_index = 1; @endphp
       @foreach($rid->shipmentsSorted() as $shipment)
        <div class="border border-light mb-3">
         <div class="bg-light p-2 poppins" id="heading{{$shipment->id}}">
          <div class="row">
           <div class="col">
            <a data-toggle="collapse" data-target="#visit{{$shipment->id}}" href="#visit{{$shipment->id}}" aria-expanded="true" aria-controls="visit{{$shipment->id}}">
             Shipment {{$shipment_index}}
            </a>
           </div>
           <div class="col-auto">
            <a data-toggle="collapse" data-target="#visit{{$shipment->id}}" href="#visit{{$shipment->id}}" aria-expanded="true" aria-controls="visit{{$shipment->id}}" class="badge border-dark text-dark border">
             <span class="text-black-50 fal fa-link"></span> 
             <span class="text-warning">{{$shipment->visits->count()}}</span> 
             @if($shipment->visits->count() > 1)
              Visits
             @else
              Visit
             @endif
            </a>
           </div>
           <div class="col-sm-auto">
            @if(($shipment->delivery_date) || ($shipment->getTodo() === 'Ready'))
             <span class="badge badge-success">Complete</span>
            @else
             <span class="badge badge-secondary">Pending</span>
            @endif
           </div>
          </div><!-- /.row -->
          <div class="row">
           @access('rid.shipment.view')
            <div class="col-sm">
             <small class="upper d-block">Delivered On</small>
             @if($shipment->delivery_date)
              <strong>{{\Carbon\Carbon::parse($shipment->delivery_date)->format(config('eac.date_format'))}}</strong>
             @else
              <span>N/A</span>
             @endif
            </div>
           @endif
           @access('rid.regimen.view')
            <div class="col-sm">
             <small class="upper d-block">Components</small>
             {{$rid->drug->components->count()}}
            </div>
           @endif
           @access('rid.pharmacy.view')
            <div class="col-sm">
             <small class="upper d-block">Pharmacy</small>
             @if($shipment->pharmacy)
              <strong>{{$shipment->pharmacy->name}}</strong>
             @else
              <small class="text-muted">N/A</small>
             @endif
            </div>
           @endif
          </div><!-- /.row -->
         </div>
         @if($shipment->visits->count() > 0)
          <div id="visit{{$shipment->id}}" class="collapse @if($shipment_index == 1) show @endif" aria-labelledby="heading{{$shipment->id}}" data-parent="#shipmentX">
           <div class="border-top bg-light p-2">
            <div class="mb-2 d-flex justify-content-between flex-wrap">
             <h5 class="mb-0">Shipment Information</h5>
             <a class="btn btn-link" href="{{route('eac.portal.rid.shipment.edit', $shipment->id)}}">
              Edit Shipment
             </a>
            </div>

            <div class="HERE">                
             <div class="d-flex flex-wrap">
              @access('rid.regimen.view')
               <div class="border border-info flex-fill p-2">
                <div class="row align-items-center">
                 <div class="col-sm">
                  <div class="d-flex flex-wrap justify-content-between">
                   <h5 class="mb-0">
                    <strong>Regimen &amp; Frequency</strong>
                   </h5>
                   @if(!$shipment->regimensNeeded()->count())
                    <span class="badge badge-success ">
                     <i class="fas fa-check"></i> Complete!
                    </span>
                   @else
                    <span class="badge badge-danger">
                     <i class="fas fa-exclamation-triangle"></i> Incomplete
                    </span>
                   @endif
                  </div><!-- /.d-flex -->
                 </div>
                 <div class="col-sm">
                  <div class="row">
                   <div class="col text-center">
                    <div class="">
                     <small class="upper d-block">Components</small>
                     <strong>{{$rid->drug->components->count()}}</strong>
                    </div>
                   </div>
                   <div class="col text-center">
                    <div class="">
                     <small class="upper d-block">Regimens</small>
                     <strong>{{$shipment ? $shipment->regimen->count() : '0'}}</strong>
                    </div>
                   </div>
                  </div><!-- /.row -->
                 </div>
                </div>
                <ul class="list-group list-group-flush">
                 @foreach($rid->drug->components->sortBy('index') as $component)
                  <li class="list-group-item">
                    <span class="badge badge-outline-dark">{{$component->name}}</span>
                   @if($regimen = $shipment->regimenWithComponent($component->id))
                    @if($regimen->is_applicable == 1)
                      <strong class="d-block">
                       {{(int)$regimen->lot->dosage->amount * (int)$regimen->quantity}}{{$regimen->lot->dosage->unit->name}}
                       {{$regimen->lot->dosage->form->name}}
                      </strong>
                      taken every {{$regimen->frequency}}
                      for {{$regimen->length}}
                      <small>({{ $regimen->lot->dosage->strength->name }})</small>
                      @if($regimen->lot->depot)
                       <span class="d-block">{{ $regimen->lot->depot->name }}</span>
                      @endif
                      @if($regimen->lot->number)
                       <small>
                        Lot:
                        <span>{{ $regimen->lot->number }}</span>
                       </small>
                      @endif
                    @endif
                    @if($regimen->is_applicable == 0)
                     N/A
                    @endif
                   @else
                   @endif
                  </li>
                 @endforeach
                </ul>
               </div>
              @endif
              @access('rid.pharmacy.view')
               <div class="border border-info flex-fill p-2">
                <div class="row align-items-center">
                 <div class="col-sm">
                  <div class="d-flex flex-wrap justify-content-between">
                   <h5 class="mb-0">
                    <strong>Pharmacy</strong>
                   </h5>
                   @if($shipment->pharmacy && $shipment->pharmacist)
                    <span class="badge badge-success">
                     <i class="fas fa-check"></i> Complete!
                    </span>
                   @else
                    <span class="badge badge-danger">
                     <i class="fas fa-exclamation-triangle"></i> Incomplete
                    </span>
                   @endif
                  </div><!-- /.d-flex -->
                 </div>
                 <div class="col-sm">
                  <div class="row">
                   <div class="col text-center">
                    <div class="">
                     <small class="upper d-block">Pharmacy</small>
                     @if($shipment->pharmacy)
                      <strong>{{$shipment->pharmacy->name}}</strong>
                     @else
                      <small class="text-muted">N/A</small>
                     @endif
                    </div>
                   </div>
                   <div class="col text-center">
                    <div class="">
                     <small class="upper d-block">Pharmacist</small>
                     @if($shipment->pharmacist)
                      <strong>{{$shipment->pharmacist->name}}</strong>
                     @else
                      <small class="text-muted">N/A</small>
                     @endif
                    </div>
                   </div>
                  </div><!-- /.row -->
                 </div>
                </div>
                <div class="">
                 <div class="row">
                  <div class="col-sm-6 col-md-auto col-lg-4 mb-2">
                   <label class="d-block">Pharmacy</label>
                   @if($shipment->pharmacy)
                    <div class="small">
                     <span class="d-block font-italic">{{ $shipment->pharmacy->name }}</span>
                     {!! $shipment->pharmacy->address->strDisplay()!!}
                    </div>
                   @else
                    <span class="text-muted">N/A</span>
                   @endif
                  </div>
                  <div class="col-sm-6 col-md-auto col-lg-4 mb-2">
                   <label class="d-block">Pharmacist</label>
                   @if($shipment->pharmacist_id)
                    <span class="d-block font-italic">{{ $shipment->pharmacist->name }}</span>
                    <i class="fal fa-at"></i>
                    <a target="_blank" href="mailto:{{ $shipment->pharmacist->email }}">
                     {{ $shipment->pharmacist->email }}
                    </a><br/>
                    <i class="fal fa-phone"></i>
                    <a href="tel:{{ $shipment->pharmacist->getPhone() }}">
                     {{ $shipment->pharmacist->getPhone() }}
                    </a>
                   @else
                    <small class="text-muted">N/A</small>
                   @endif
                  </div>
                 </div>
                </div>
               </div>
              @endif
              @access('rid.shipment.view')
               <div class="border border-info flex-fill p-2">
                <div class="row align-items-center">
                 <div class="col-sm">
                  <div class="d-flex flex-wrap justify-content-between">
                   <h5 class="mb-0">
                    <strong>Shipping Details</strong>
                   </h5>
                   @if($shipment->ship_by_date && $shipment->deliver_by_date && $shipment->courier_id)
                    <span class="badge badge-success ">
                     <i class="fas fa-check"></i> Complete!
                    </span>
                   @else
                    <span class="badge badge-danger">
                     <i class="fas fa-exclamation-triangle"></i> Incomplete
                    </span>
                   @endif
                  </div><!-- /.d-flex -->
                 </div>
                 <div class="col-sm">
                  <div class="row">
                   <div class="col text-center">
                    <div class="">
                     <small class="upper d-block">Delivered On</small>
                     @if($shipment->delivery_date)
                      <strong>{{\Carbon\Carbon::parse($shipment->delivery_date)->format(config('eac.date_format'))}}</strong>
                     @else
                      <span>N/A</span>
                     @endif
                    </div>
                   </div>
                   <div class="col text-center">
                    <div class="">
                     <small class="upper d-block">Ship By</small>
                     @if($shipment->ship_by_date)
                      <strong>{{\Carbon\Carbon::parse($shipment->ship_by_date)->format(config('eac.date_format'))}}</strong>
                     @else
                      <span>N/A</span>
                     @endif
                    </div>
                   </div>
                   <div class="col text-center">
                    <div class="">
                     <small class="upper d-block"></small>
                    </div>
                   </div>
                  </div><!-- /.row -->
                 </div>
                </div>
                <div class="">
                 <div class="row ">
                  <div class="col text-center">
                  </div>
                  <div class="col text-center">
                   <small class="upper d-block text-muted">Ship By</small>
                   @if($shipment->ship_by_date)
                    <strong>{{\Carbon\Carbon::parse($shipment->ship_by_date)->format(config('eac.date_format'))}}</strong>
                   @else
                    <span>N/A</span>
                   @endif
                  </div>
                  <div class="col text-center">
                   <small class="upper d-block text-muted">Shipped On</small>
                   @if($shipment->shipped_on_date)
                    <strong>{{\Carbon\Carbon::parse($shipment->shipped_on_date)->format(config('eac.date_format'))}}</strong>
                   @else
                    <span>N/A</span>
                   @endif
                  </div>
                  <div class="col text-center">
                   <small class="upper d-block text-muted">Delivered On</small>
                   @if($shipment->delivery_date)
                    <strong>{{\Carbon\Carbon::parse($shipment->delivery_date)->format(config('eac.date_format'))}}</strong>
                   @else
                    <span>N/A</span>
                   @endif
                  </div>
                 </div>
                 <div class="mb-2">
                  <small class="upper d-block">Expected Delivery</small>
                  @if($shipment->deliver_by_date)
                   {{\Carbon\Carbon::parse($shipment->deliver_by_date)->format(config('eac.date_format'))}}
                  @else
                   <span class="text-muted">N/A</span>
                  @endif
                 </div>
                 <div class="mb-2">
                  <small class="upper d-block">Tracking Number</small>
                  @if($shipment->tracking_number)
                   {{ $shipment->tracking_number }}
                  @else
                   <span class="text-muted">N/A</span>
                  @endif
                 </div>
                 <div class="mb-2">
                  <small class="upper d-block">Courier</small>
                  @if($shipment->courier)
                   {{ $shipment->courier->name }}
                  @else
                   <span class="text-muted">N/A</span>
                  @endif
                 </div>
                </div>
               </div>
              @endif
             </div><!-- /.d-flex -->
            </div>
           </div>


              @foreach($shipment->visits->sortBy('index') as $visit)
               <div class="bg-white p-1">
                <div class="row align-items-center">
                 <div class="col-sm-auto col-lg col-xl-2 order-md-1">
                  <div class="p-3 poppins">
                   <div class="h5 mb-0 strong">Visit #{{$visit->index == 0 ? 1 : $visit->index}}</div>
                   <a href="#" class="btn btn-link btn-sm">
                    Edit Visit <span class="fal fa-angle-double-right"></span>
                   </a>
                   <br /><a class="mb-1 {{$visit->getDocStatus() ? 'complete' : ''}}" id="xdetailsT{{$visit->index}}" data-toggle="pill" href="#xdetails{{$visit->index}}" role="tab" aria-controls="xdetails{{$visit->index}}" aria-selected="false">
                    view panel
                   </a>
                  </div>
                 </div>
                 <div class="col-sm-auto col-lg col-xl-auto order-md-3 order-lg-2 order-xl-3">
                  <div class="d-flex justify-content-between poppins p-2">
                   <div class="flex-fill text-center pl-2 pr-2">
                    <h5 class="mb-0"><strong>{{$visit->requiredDocs()->count()}}</strong></h5>
                    <span class="d-block">Requested Forms</span>
                   </div>
                   <div class="border-left">&nbsp;</div>
                   <div class="flex-fill text-center pl-2 pr-2">
                    <h5 class="mb-0"><strong>{{$visit->uploadedDocuments()->count()}}</strong></h5>
                    <span class="d-block">Submitted</span>
                   </div>
                  </div><!-- /.d-flex -->
                 </div>
                 <div class="col-md col-lg-12 col-xl order-md-2 order-lg-3 order-xl-2">
                  <div class="stepPro">
                   <div class="completed">
                    <div class="h5 poppins mb-0">Visit Date</div>
                    <small>
                     @if($visit->visit_date) {{ $visit->visit_date }} @elseif($visit->visit_date > date('Y-m-d')) Future visit @else Information Unavailable @endif
                    </small>
                   </div>
                   <div class="{{$visit->getDocStatus() ? 'completed' : 'inprogress'}}">
                    <div class="h5 poppins mb-0">Submit Forms</div>
                    <small>Forms {{$visit->getDocStatus() ? 'have been submitted' : 'are requested'}} for this visit</small>
                   </div>
                   <div class="{{$visit->getDocStatus() ? 'completed' : 'notavail'}}">
                    <div class="h5 poppins mb-0">Completed</div>
                    <small>All requested forms have been submitted</small>
                   </div>
                  </div><!-- /.stepPro -->
                 </div>
                </div>
               </div>
              @endforeach

          </div>
         @endif
         @php $shipment_index ++; @endphp
        </div>
       @endforeach
      </div>
     @endif


       <div class="tab-content wizardContent" id="tabContent">
        @php $shipment_index = 1; @endphp
        @foreach($rid->visits->sortBy('index') as $visit)
         @include('portal.rid.show.visit')
        @endforeach
       </div>

    @endif
   </div>
   <div class="col-xl-3">
    <div class="row">
     <div class="col-lg col-xl-12">
      <div class="mb-3 pt-2 pl-3 pr-3 pb-2 alert-secondary">
       <ul class="mb-0 nav navbar-nav flex-row justify-content-between justify-content-xl-start flex-xl-column">
        @if(\Auth::user()->type->name == 'Early Access Care')
         @access('rid.document.update')
          @if(!$rid->visits->count())
           <li class="nav-item">
            <a href="{{route('eac.portal.rid.resupply', $rid->id)}}" class="nav-link">
             <i class="fas fa-fw fa-calendar-edit"></i>
             Manage Visits
            </a>
           </li>
          @endif
         @endif
        @endif
        @access('rid.index.update')
         <li class="nav-item">
         <a href="{{ route("eac.portal.rid.edit", $rid->id) }}" class="nav-link">
          <i class="fas fa-fw fa-edit"></i>
          Edit Request Details
         </a>
        </li>
        @endif
        @if(\Auth::user()->type->name == 'Early Access Care' || \Auth::user()->type->name == 'Physician')
         <li class="nav-item">
          <a class="nav-link" href="#ridLogin{{$rid->id}}" data-toggle="modal" data-target="#ridLogin{{$rid->id}}">
           <i class="fas fa-fw fa-lock-alt"></i> 
           Patient Password
          </a>
         </li>
        @endif
        @access('rid.user.create')
         <li class="nav-item">
          <a href="{{route('eac.portal.rid.edit', $rid->id)}}#xusergrpT" class="nav-link">
           <i class="fas fa-fw fa-users"></i>
           Assign User Group
          </a>
         </li>
        @endif
        @access('rid.document.update')
         <li class="nav-item">
          <a href="{{route('eac.portal.rid.postreview', $rid->id)}}" class="nav-link">
           <i class="fas fa-fw fa-upload"></i>
           Post Approval Documents
          </a>
         </li>
        @endif
       </ul>
      </div>
     </div>
     <div class="col-sm-6 col-lg col-xl-12">
      <ul class="nav nav-tabs" id="xYo" role="tablist">
       <li class="nav-item">
        <a class="nav-link active" id="xYoDets-tab" data-toggle="tab" href="#xYoDets" role="tab" aria-controls="xYoDets" aria-selected="true">
         <span class="d-sm-none d-md-inline">Patient</span> Details
        </a>
       </li>
       <li class="nav-item">
        <a class="nav-link" id="xYoEtc-tab" data-toggle="tab" href="#xYoEtc" role="tab" aria-controls="xYoEtc" aria-selected="false">
         Groups <span class="d-sm-none d-md-inline">Assigned</span>
        </a>
       </li>
      </ul>
      <div class="card mb-3">
       <div class="tab-content">
        <div class="tab-pane active" id="xYoDets" role="tabpanel" aria-labelledby="xYoDets-tab">
         <div class="card-header alert-info">
          <h5 class="mb-0 poppins">Patient Details</h5>
         </div>
         @access('rid.patient.view')
          <ul class="list-group list-group-flush mb-0">
           @if(isset($rid->patient_dob))
            <li class="list-group-item">
             <div class="row">
              <div class="col ">
               <label class="d-block">Date of Birth</label>
               {{ $rid->patient_dob }}
              </div>
              <div class="col col-sm-auto col-md ">
               <label class="d-block">Age</label>
               {{ $rid->getPatientAge() }}
              </div>
             </div><!-- /.row -->
            </li>
            <li class="list-group-item">
             <div class="row">
              @if(isset($rid->patient_gender))
               <div class="col">
                <label class="d-block">Gender</label>
                {{ $rid->patient_gender }}
               </div>
              @endif
              @if(isset($rid->patient_weight))
               <div class="col col-sm-auto col-md">
                <label class="d-block">Weight</label>
                {{ $rid->patient_weight }}KG
               </div>
              @endif
             </div><!-- /.row -->
            </li>
           @endif
           @if(isset($rid->ethnicity->name))
            <li class="list-group-item">
             <label class="d-block">Ethnicity</label>
             {{ $rid->ethnicity->name }}
            </li>
           @endif
           @if(isset($rid->race->name))
            <li class="list-group-item">
             <label class="d-block">Race</label>
             {{ $rid->race->name }}
            </li>
           @endif
           @if(isset($rid->reason))
            @php
             // strip tags to avoid breaking any html
             $string = strip_tags($rid->reason);
             if (strlen($string) > 75) {
              // truncate string
              $stringCut = substr($string, 0, 75);
              $endPoint = strrpos($stringCut, ' ');
              //if the string doesn't contain any space then it will cut without word basis.
              $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
              $string .= '... <a class="badge badge-primary float-right" title="Click to view reason for request" data-toggle="modal" data-target="#showWHOLEreason" href="#showWHOLEreason">Read More</a>';
             }
            @endphp
            <li class="list-group-item">
             <label class="d-block">Reason for Request</label>
             {!! $string !!}
            </li>
           @endif
           @if($rid->proposed_treatment_plan)
            @php
             // strip tags to avoid breaking any html
             $string = strip_tags($rid->proposed_treatment_plan);
             if (strlen($string) > 75) {
              // truncate string
              $stringCut = substr($string, 0, 75);
              $endPoint = strrpos($stringCut, ' ');
              //if the string doesn't contain any space then it will cut without word basis.
              $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
              $string .= '... <a class="badge badge-primary float-right" title="Click to view proposed treatment plan" data-toggle="modal" data-target="#showWHOLEplan" href="#showWHOLEplan">Read More</a>';
             }
            @endphp
            <li class="list-group-item">
             <label class="d-block">Proposed Treatment</label>
             {!! $string !!}
            </li>
           @endif
          </ul>
          @if(isset($rid->reason))
           <div class="modal fade" id="showWHOLEreason" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content">
              <div class="modal-header p-2">
               <h5 class="m-0">
                Reason for Request
               </h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="fal fa-times"></i>
               </button>
              </div>
              <div class="modal-body p-3">
               {{ $rid->reason }}
              </div>
              <div class="modal-footer p-2 d-flex justify-content-between">
               <button type="button" class="btn btn-secondary" data-dismiss="modal" tabindex="-1">Dismiss</button>
              </div>
             </div>
            </div>
           </div>
          @endif
          @if($rid->proposed_treatment_plan)
           <div class="modal fade" id="showWHOLEplan" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content">
              <div class="modal-header p-2">
               <h5 class="m-0">
                Proposed Treatment
               </h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="fal fa-times"></i>
               </button>
              </div>
              <div class="modal-body p-3">
               {{ $rid->proposed_treatment_plan }}
              </div>
              <div class="modal-footer p-2 d-flex justify-content-between">
               <button type="button" class="btn btn-secondary" data-dismiss="modal" tabindex="-1">Dismiss</button>
              </div>
             </div>
            </div>
           </div>
          @endif
         @endif
        </div>{{-- 
        @access('rid.user.view')
         <div class="tab-pane" id="xYoEtc" role="tabpanel" aria-labelledby="xYoEtc-tab">
          @if($rid->user_groups->count() > 0)
           <div class="card-header alert-info">
            <h5 class="mb-0 poppins"><strong>{{$rid->user_groups->count()}}</strong> Groups Assigned</h5>
           </div>
           <div class="list-group list-group-flush">
            @foreach($rid->user_groups->sortBy('name') as $userGroup)
             <div class="list-group-item p-2">
              <strong>{{$userGroup->name}}</strong>
              <div class="row ml-n1 mr-n1 align-items-center">
               <div class="col-sm pl-1 pr-1">
                <small class="upper text-black-50 d-block">{{$userGroup->type->name}} Group</small>
               </div>
               <div class="col-sm-auto pl-1 pr-1">
                <a class="badge p-0" data-toggle="collapse" title="Click to view group members" href="#exp{{$userGroup->id}}" role="button" aria-expanded="false" aria-controls="exp{{$userGroup->id}}">
                 {{$userGroup->users()->count()}} Members
                </a>
               </div>
              </div>
              <div class="pl-4">
               @if($userGroup->parent())
                <div class="small mb-1 d-flex flex-wrap justify-content-between">
                 <a href="{{ route('eac.portal.user.show', $userGroup->parent->id) }}" class="">
                  {{$userGroup->parent->full_name}}
                 </a>
                 <span class="badge badge-success">Group Lead</span>
                </div>
               @endif
               <div class="collapse" id="exp{{$userGroup->id}}">
                @foreach($userGroup->users()->sortBy('first_name') as $user)
                 @if(($user) && ($user->id != $userGroup->parent_user_id))
                  <div class="small mb-1 d-flex flex-wrap justify-content-between">
                   <a href="{{ route('eac.portal.user.show', $user->id) }}" class="">
                    {{$user->full_name}}
                   </a>
                   <span class="badge p-0">{{$userGroup->roleInTeam($user->id)->name}}</span>
                  </div>
                 @endif
                @endforeach
               </div>
              </div>
             </div>
            @endforeach
           </div>
          @else
           <p class="text-muted mb-0">Information unavailable</p>
          @endif
         </div>
        @endif --}}
       </div>
      </div><!-- /.card -->
     </div>
     <div class="col-sm-6 col-lg col-xl-12">
      <ul class="nav nav-tabs" id="aBc" role="tablist">
       <li class="nav-item">
        <a class="nav-link active" id="aBcDets-tab" data-toggle="tab" href="#aBcDets" role="tab" aria-controls="aBcDets" aria-selected="true">
         Drug <span class="d-sm-none d-md-inline">Details</span>
        </a>
       </li>
       <li class="nav-item">
        <a class="nav-link" id="aBcEtc-tab" data-toggle="tab" href="#aBcEtc" role="tab" aria-controls="aBcEtc" aria-selected="false">
         <span class="d-sm-none d-md-inline">Reference</span> Documents
        </a>
       </li>
      </ul>
      <div class="card mb-3">
       <div class="tab-content">
        <div class="tab-pane active" id="aBcDets" role="tabpanel" aria-labelledby="aBcDets-tab">
         <div class="card-header alert-info">
          <h5 class="mb-0 poppins">Drug Requested</h5>
         </div>
         <div class="list-group list-group-flush">
          @access('rid.drug.view')
           <div class="list-group-item p-2">
            {{-- <label class="d-block">Drug</label> --}}
            @if(\Auth::user()->type->name == 'Early Access Care')
            <a href="{{ route('eac.portal.drug.show', $rid->drug->id) }}" class="mono">
             {{ $rid->drug->name }}
            </a> ({{$rid->drug->lab_name}})
            <div>
             <a href="{{ route('eac.portal.company.show', $rid->drug->company->id) }}">
              {{ $rid->drug->company->name }}
             </a>
            </div>
            @else
             <span class="mono">{{ $rid->drug->name }}</span> ({{$rid->drug->lab_name}})
             <div>
              {{ $rid->drug->company->name }}
             </div>
            @endif
           </div>
           <div class="list-group-item">
            <label class="d-block">Pre-Approval Required</label>
            @if($rid->drug->pre_approval_req)
             No
            @else
             Yes
            @endif
           </div>
          @endif
          @access('rid.info.view')
           <div class="list-group-item">
            <label class="d-block">Request Date</label>
            {{ \Carbon\Carbon::parse($rid->req_date)->format(config('eac.date_format')) }}
           </div>
           <div class="list-group-item">
            <label class="d-block">Requested By</label>
            @if(\Auth::user()->type->name == 'Early Access Care')
             <a href="{{route('eac.portal.user.show', $rid->physician->id)}}">
              {{ $rid->physician->full_name }}
             </a>
            @else
             {{ $rid->physician->full_name }}
            @endif
           </div>
           @if($rid->physician->address)
            @php 
             $country = $rid->physician->address->country;
            @endphp 
            <div class="list-group-item">
             <label class="d-block">Ship To</label>
             <a href="#" data-toggle="modal" data-target="#Modal{{$country->id}}" >
              {{ $country->name}}
             </a>
            </div>
           @endif
          @endif
         </div>
        </div>
        <div class="tab-pane" id="aBcEtc" role="tabpanel" aria-labelledby="aBcEtc-tab">
         @access('rid.drug.view')
          <div class="card-header alert-info">
           <h5 class="mb-0 poppins">Drug Resources</h5>
          </div>
          @if($rid->drug->resources->count() > 0)
           <div class="list-group list-group-flush">
            @foreach($rid->drug->resources->sortBy('name') as $resource)
             @if($resource->active)
              <div class="list-group-item p-2">
               {{ $resource->name }}
               @include('include.portal.file-btns', ['id' => $resource->file_id])
               <p class="small mb-0">
                {!! $resource->desc ? $resource->desc : '' !!}
               </p>
              </div>
             @endif
            @endforeach
           </div>
          @else
           <div class="card-body p-2 text-muted">Information unavailable</div>
          @endif
         @endif
        </div>
       </div>
      </div><!-- /.card -->
     </div>
     @access('rid.note.view')
      <div class="col-lg-4 col-xl-12 mb-3">
       <div class="card card-body mb-0 p-0">
        @if($rid->notes->count() > 0)
         @php $i = 0; @endphp
         <div class="table-responsive">
          <table class="notesTbl small table" data-page-length="5">
           <thead>
           <tr>
            <th>
             <strong>{{$rid->notes->count()}}</strong>
             Notes
            </th>
           </tr>
           </thead>
           <tbody>
           @foreach($rid->notes as $note)
            @php
             // strip tags to avoid breaking any html
             $string = strip_tags($note->text);
             if (strlen($string) > 100) {
              // truncate string
              $stringCut = substr($string, 0, 100);
              $endPoint = strrpos($stringCut, ' ');
              //if the string doesn't contain any space then it will cut without word basis.
              $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
              $string .= '...<a data-toggle="modal" class="badge badge-info float-right" data-target="#dispNote'.$note->id.'" href="#dispNote{{$note->id}}">Read More</a>';
             }
            @endphp
            @php $i++ @endphp
            <tr>
             <td data-order="{{date('Y-m-d', strtotime($note->created_at))}}">
              <div class="d-flex justify-content-between align-items-center">
               <strong>{{ $note->author->full_name ?? 'N/A' }}</strong>
               <div class="text-muted">
                {{ $note->created_at->format('d M, Y') }}
               </div>
              </div>
              {!! $string !!}
             </td>
            </tr>
            @if (strlen($string) > 75)
             <div class="modal fade" id="dispNote{{$note->id}}" tabindex="-1" role="dialog" aria-labelledby="dispNote{{$note->id}}Label" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
               <div class="modal-content">
                <div class="modal-header p-2">
                 <h5 class="m-0">
                  View Note </h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <i class="fal fa-times"></i>
                 </button>
                </div>
                <div class="modal-body p-3">
                 <div class="d-flex justify-content-between align-items-center">
                  <strong>{{ $note->author->full_name ?? 'N/A' }}</strong>
                  <div class="text-muted">
                   {{ $note->created_at->format('d M, Y') }}
                  </div>
                 </div>
                 {{$note->text}}
                </div>
                <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
               </div>
              </div>
             </div>
            @endif
           @endforeach
           </tbody>
          </table>
         </div>
        @else
         <div class="text-muted p-3">
          <span class="fad fa-info-square fa-lg"></span> No notes to display
         </div>
        @endif
       </div>
       <div class="card-footer p-2">
        <a href="#" class="btn btn-success btn-block" data-toggle="modal" data-target="#RidNoteAdd">
         <i class="fad fa-comment-alt-plus"></i>
         Add Note
        </a>
       </div>
      </div>
     @endif
    </div><!-- /.row -->
   </div>
  </div>

 </div><!-- /.viewData -->

 @access('rid.info.view')
  @if($rid->physician->address)
   @include('include.portal.modals.rid.country.available_country', $country)
  @endif
 @endif

 @access('rid.note.create')
  <div class="modal fade" id="NoteAdd" tabindex="-1" role="dialog" aria-hidden="true">
   <form method="post" action="{{ route('eac.portal.note.create') }}">
    {{ csrf_field() }}
    <input type="hidden" name="subject_id" value="{{$visit->id}}">
    <div class="modal-dialog modal-dialog-centered " role="document">
     <div class="modal-content">
      <div class="modal-header p-2">
       <h5 class="m-0">
        Add Note to <strong>Visit - {{ \Carbon\Carbon::parse($visit->visit_date)->format(config('eac.date_format')) }}</strong>
       </h5>
       <button type="button" class="close" data-dismiss="modal"
         aria-label="Close">
        <i class="fal fa-times"></i>
       </button>
      </div>
      <div class="modal-body p-3">
       @if(\Auth::user()->type->name == 'Early Access Care')
        <label class="d-block">
         <input name="physican_viewable" type="checkbox" value="1" /> Viewable by Physician
        </label>
       @else
        <input name="physican_viewable" type="hidden" value="1" />
       @endif
       <label
        class="d-block">{{ \Auth::user()->first_name }} {{ \Auth::user()->last_name }}
        <small>{{date('Y-m-d H:i')}}</small>
       </label>
       <textarea name="text" class="note_text form-control" rows="3"
           placeholder="Enter note..."></textarea>
      </div>
      <div class="modal-footer p-2 d-flex justify-content-between">
       <button type="button" class="btn btn-secondary"
         data-dismiss="modal" tabindex="-1">Cancel
       </button>
       <button type="submit" name="submit" class="btn btn-success"
         value="Add Note">Submit
       </button>
      </div>
     </div>
    </div>
   </form>
  </div>
 @endif

 @access('rid.info.update')
  @include('include.portal.modals.rid.reassign.physician')
 @endif
 @access('rid.document.update')
  <form method="post" action="{{ route('eac.portal.rid.document.required.update') }}">
   @csrf
   <div class="modal fade" id="editReqForms" tabindex="-1" role="dialog" aria-labelledby="editReqFormsLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
     <div class="modal-content">
      <div class="modal-header p-2">
       <h5 class="m-0">
        Edit Forms </h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <i class="fal fa-times"></i>
       </button>
      </div>
      <div class="modal-body p-3">
       <div class="table-responsive">
        <table class="table table-striped SOint table-sm ">
         <thead>
         <tr>
          <th class="text-center">Required</th>
          <th>Form Type</th>
         </tr>
         </thead>
         <tbody>
         @foreach($visit->documents as $document)
          <tr class="">
           <td class="text-center">
            <input type="hidden" name="doc[{{$document->id}}]" value="0"/>
            <input type="checkbox" name="doc[{{$document->id}}]" value="1" @if($document->required()) checked @endif />
           </td>
           <td>
            {{ $document->type->name }}
           </td>
          </tr>
         @endforeach
         </tbody>
        </table>
       </div>
      </div>
      <div class="modal-footer p-2 d-flex justify-content-between">
       <button type="button" class="btn btn-secondary" data-dismiss="modal" tabindex="-1">
        Cancel
       </button>
       <button type="submit" class="btn btn-success">
        Save
       </button>
      </div>
     </div>
    </div>
   </div>
  </form>
 @endif
 @include('include.portal.modals.rid.patient.ridlogin', $rid)
 <div class="modal fade" id="RidNoteAdd" tabindex="-1" role="dialog" aria-hidden="true">
  <form method="post" action="{{ route('eac.portal.note.create') }}">
   {{ csrf_field() }}
   <input type="hidden" name="subject_id" value="{{$rid->id}}">
   <div class="modal-dialog modal-dialog-centered " role="document">
    <div class="modal-content">
     <div class="modal-header p-2">
      <h5 class="m-0">
       Add Note to
       <strong>RID: <span class="mono">{{ $rid->number }}</span></strong>
      </h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
       <i class="fal fa-times"></i>
      </button>
     </div>
     <div class="modal-body p-3">
      @if(\Auth::user()->type->name == 'Early Access Care')
       <label class="d-block">
        <input name="physican_viewable" type="checkbox" value="1"/>
        Viewable by Physician
       </label>
      @else
       <input name="physican_viewable" type="hidden" value="1"/>
      @endif
      <label class="d-block">{{ \Auth::user()->first_name }} {{ \Auth::user()->last_name }}
       <small>{{date('Y-m-d H:i')}}</small>
      </label>
      <textarea name="text" class="note_text form-control" rows="3" placeholder="Enter note..."></textarea>
     </div>
     <div class="modal-footer p-2 d-flex justify-content-between">
      <button type="button" class="btn btn-secondary" data-dismiss="modal" tabindex="-1">Cancel
      </button>
      <button type="submit" name="submit" class="btn btn-success" value="Add Note">Submit
      </button>
     </div>
    </div>
   </div>
  </form>
 </div>
@endsection

@section('scripts')
 <script>
  $(document).ready(function () {
   $('.notesTbl').DataTable({
    "stateSave": true,
    "info": false,
    "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
    "order": [[0, "desc"]],
    "searching": false,
    "dom": 't<"d-flex justify-content-between flex-wrap small p-2"lp>'
   });
  });
  function removeTemplateDocument($id, $e, $field_name) {
  console.log($field_name);
  $.ajax({
    url: "{{route('eac.portal.rid.modal.document.remove')}}",
    type: 'POST',
    data: {
     id: $id,
     field: $field_name,
    },
    success: function () {
   location.reload();
   // var labelUploaded_ = $field_name === 'upload_file' ? 'UPLOAD FILE' : ' Redacted file';
     // var labelUploaded = '<label class="d-block">Redacted File <small>({{config('eac.storage.file.type')}})</small></label>';
     //  $e.target.parentNode.parentNode.innerHTML = labelUploaded+' <input class="form-control" type="file" name="' + $field_name + '"/>'
    }
   });
  }

  $(function () {
   $("a.next").click(function () {
    let currentLink = $('.nav-link.active');
    setWizardStep(currentLink.index() + 1);
   });

   $("a.prev").click(function () {
    let currentLink = $('.nav-link.active');
    setWizardStep(currentLink.index() - 1);
   });

   let jumped = false;

   $(".tab-pane").each(function () {
    let errorCount = $(this).find('.is-invalid').length;
    if (errorCount > 0) {
     let link = $('a[aria-controls=' + $(this).attr('id') + ']');
     link.addClass('invalid');
     if (!jumped) {
      setWizardStep(link.index());
      jumped = true;
     }
    }
   });

   function setWizardStep(n) {
    $('.wizardSteps a.nav-link:nth-child(' + (n + 1) + ')').click();
   }
  });

  function removeTemplateDocument($id, $e, $field_name) {
   // $.ajax({
   //   url: "{{route('eac.portal.rid.modal.document.remove')}}",
   //   type: 'POST',
   //   data: {
   //     id: $id,
   //     field: $field_name,
   //   },
   //   success: function () {
   //     location.reload();

   //     // if($field_name == 'upload_file'){
   //     //   $e.target.parentNode.parentNode.parentNode.innerHTML = '<input class="form-control" type="file" name="' + $field_name + '" >';
   //     // }else{
   //     //   $e.target.parentNode.parentNode.innerHTML = '<input class="form-control" type="file" name="' + $field_name + '" >';
   //     // }
   //   }
   // });
   swal({
    title: "Are you sure?",
    text: "Want to delete it",
    icon: "warning",
    buttons: [
     'No, cancel it!',
     'Yes, I am sure!'
    ],
    dangerMode: true,
   }).then(function (isConfirm) {
    if (isConfirm) {
     swal({
      title: 'Successfull!',
      text: 'Content deleted!',
      icon: 'success'
     }).then(function () {
      $('.modal').modal('hide')
      $.ajax({
       url: "{{route('eac.portal.rid.modal.document.remove')}}",
       type: 'POST',
       data: {
        id: $id,
        field: $field_name,
       },
       success: function () {

       }
      });

      swal.close();

      location.reload();
     });

    } else {
     swal("Cancelled", "Operation cancelled", "error");
    }
   })
  }

  function removeTemplateDocument2($id, $e, $field_name) {
   $.ajax({
    url: "{{route('eac.portal.drug.modal.document.remove_file')}}",
    type: 'POST',
    data: {
     id: $id,
     field: $field_name,
    },
    success: function () {
     $e.target.parentNode.parentNode.innerHTML = '<input class="form-control" type="file" name="' + $field_name + '"/>'
    }
   });
  }

 </script>
@endsection
