@extends('layouts.portal-alt')

@section('title')
 QuasarEsh's Testing Page
@endsection

@section('styles')
 <style>
  .nahttable {
   width: 100%;
   font-size: 95%;
  }
  .nahttable > thead > tr > th, .nahttable > tbody > tr > td {
   padding: .15rem .75rem;
  }


  .nahttable > thead > th {
   background-color: rgba(0,0,0,.05);

  }
  .nahttable > tbody > tr > td {
   border-color: rgba(0,0,0,.05);
   border-style: solid;
   border-width: 1px 0 0 0;
  }
  .nahttable > tbody > tr > td:first-of-type {
   border-width: 1px 0 0 1px;
  }
  .nahttable > tbody > tr > td:last-of-type {
   border-width: 1px 1px 0 0;
  }


  .nahttable > tbody > tr[aria-expanded] {cursor:pointer;}

  .nahttable > tbody > tr[aria-expanded=true] > td {
   color: #fff;
   background-color: #2D4161;
   border-color: #2D4161;
   border-width: 2px 0 0 0;
  }
  .nahttable > tbody > tr[aria-expanded=true] + tr > td {
   border-color: #2D4161;
   border-width: 0 2px 2px;
  }
  .nahttable > tbody > tr[aria-expanded=true] > td:first-of-type {
   border-width: 2px 0 0 2px;
  }
  .nahttable > tbody > tr[aria-expanded=true] > td:last-of-type {
   border-width: 2px 2px 0 0;
  }
  .nahttable > tbody > tr[aria-expanded=true] > td:first-of-type {
   background-color: #fff;
   color: #2D4161;
   font-weight: 600;
  }
 </style>
@endsection

@section('content')
 <div class="masterBox mb-3 mb-xl-5">
  <ul class="nav nav-tabs" id="RequestTabs" role="tablist">
   <li class="nav-item">
    <a class="nav-link active" id="master-tab" data-toggle="tab" href="#master" role="tab" aria-controls="master" aria-selected="true" style="pointer-events: auto;">
     Request Details
    </a>
   </li>
   <li class="nav-item">
    <a class="nav-link" id="notes-tab" data-toggle="tab" href="#notes" role="tab" aria-controls="notes" aria-selected="false" style="pointer-events: auto;">
     Notes
    </a>
   </li>
   <li class="nav-item">
    <a class="nav-link" id="users-tab" data-toggle="tab" href="#users" role="tab" aria-controls="users" aria-selected="false" style="pointer-events: auto;">
     Assigned Groups
    </a>
   </li>
   <li class="nav-item">
    <a class="nav-link" id="drug-tab" data-toggle="tab" href="#drug" role="tab" aria-controls="drug" aria-selected="false" style="pointer-events: auto;">
     Reference Documents
    </a>
   </li>
  </ul>
  <div class="tab-content" id="RequestTabsContent">
   <div class="bg-gradient-primary text-white p-3">
    <div class="row">
     <div class="col-sm">
      <h5 class="mb-0 strong d-inline-block">Viewing RID: BHV-20180627-9BG6J9B5</h5>
      <a href="http://v2adev.earlyaccesscare.com/portal/rid/edit/MNhSyEqZy8" class="small" style="color: var(--yellow)">
       [edit RID]
      </a>
     </div>
     <div class="col-sm col-lg-auto">
      <h5 class="mb-0 strong">Status: <span class="upper">Fulfillment</span></h5>
     </div>
    </div>
   </div>
   <div class="tab-pane fade active show" id="master" role="tabpanel" aria-labelledby="master-tab">
    <div class="card card-body mb-0 poppins">
     <div class="row">
      <div class="col-lg-6 col-xl-4">
       <div class="mb-2">
        <strong>Drug:</strong>
        <a href="http://v2adev.earlyaccesscare.com/portal/drug/show/VOfjkyWZOU">
         BHV-0223 
        </a> (Riluzole Zydis Sublingual)
        <span> -
         <a href="http://v2adev.earlyaccesscare.com/portal/company/show/PhItZOktTz">
          Biohaven Pharmaceuticals, Inc
         </a>
        </span>
       </div>
       <div class="mb-2">
        <strong>Request Date:</strong>
        2018-06-27
       </div>
       <div class="mb-2">
        <strong>Requested By:</strong>
        Richard Bedlack
       </div>
       <div class="mb-2">
        <strong>Ship To:</strong>
        United States
        <a href="#" data-toggle="modal" data-target="#ModalO56ryE0WL3">
         <span class="fal fa-info-circle"></span>
        </a>
       </div>
       <div class="mb-2">
        <strong>Pre-Approval Req:</strong>
        YES
       </div>
      </div>
      <div class="col-lg-6 col-xl-4">
       <div class="mb-2">
        <strong>Patient:</strong>
        Female, age 49
        (1969-12-31)
       </div>
       <div class="mb-2">
        <strong>Reason for Request:</strong>
        ALS
       </div>
      </div>
      <div class="d-lg-none d-xl-block col-xl-4">
       <img src="/images/placeholder.jpg" class="img-fluid">
      </div>
     </div><!-- /.row -->
    </div>
    <div class="bg-gradient-primary text-white p-3">
     <div class="">
      <div class="row">
       <div class="col-sm-auto col-lg">
        <a href="http://v2adev.earlyaccesscare.com/portal/rid/list" class="btn btn-light">
         <i class="fa-fw fas fa-arrow-left"></i> Return to RID List
        </a>
       </div>
       <div class="col-sm col-lg-auto ml-lg-auto">
        <a href="http://v2adev.earlyaccesscare.com/portal/rid/edit/MNhSyEqZy8" class="btn btn-info">
         <i class="fa-fw fas fa-edit"></i> Edit RID Master
        </a>
        <a title="Schedule Dates" class="btn btn-info ml-xl-3 mr-xl-3 " href="http://v2adev.earlyaccesscare.com/portal/rid/resupply/MNhSyEqZy8">
         <i class="fa-fw fas fa-redo"></i> Add Visits
        </a>
        <a title="" href="http://v2adev.earlyaccesscare.com/portal/rid/post/review/MNhSyEqZy8" class="btn btn-info">
         <i class="fa-fw fas fa-upload"></i> Post Approval Documents
        </a>
       </div>
      </div><!-- /.row -->
     </div>
    </div>
   </div>
  </div>
 </div>
 <div class="card mb-5">
  <table class="nahttable" id="tryMe">
   <thead>
    <tr>
     <th>
      <small class="text-muted upper">Shipment</small>
     </th>
     <th>
      <small class="text-muted upper">Shipped On</small>
     </th>
     <th>
      <small class="text-muted upper">Visits</small>
     </th>
     <th>
      <small class="text-muted upper">Status</small>
     </th>
    </tr>
   </thead>
   <tbody>
    <tr data-toggle="collapse" data-target="#showme6" aria-expanded="false" aria-controls="showme6">
     <td>
      Shipment #6
     </td>
     <td>
      N/A
     </td>
     <td>
      <div class="p-1 small border border-light d-inline-block">
       Visit #7
      </div>
     </td>
     <td>
      <span class="badge badge-secondary">In Process</span>
     </td>
    </tr>
    <tr id="showme6" class="collapse" data-parent="#tryMe">
     <td colspan="4" class="p-3">
      <table class="table table-sm m-0">
       <thead>
        <tr>
         <th>Status</th>
         <th>Visit Date</th>
         <th>Assigned To</th>
         <th>Delivered On</th>
        </tr>
       </thead>
       <tbody>
        <tr>
         <td>
          <span class="badge badge-success">Fulfillment: <small>Withdrew Consent</small></span>
         </td>
         <td>
          2018-07-06
         </td>
         <td>
          Daragh Heitzman
         </td>
         <td>
          2018-06-28
         </td>
        </tr>
       </tbody>
      </table>
     </td>
    </tr>
    <tr data-toggle="collapse" data-target="#showme5" aria-expanded="false" aria-controls="showme5">
     <td>
      Shipment #5
     </td>
     <td>
      2019-04-16
     </td>
     <td>
      <div class="p-1 small border border-success alert-success d-inline-block">
       Visit #6
      </div>
     </td>
     <td>
      <span class="badge badge-dark">Fulfilled</span>
     </td>
    </tr>
    <tr id="showme5" class="collapse" data-parent="#tryMe">
     <td colspan="4" class="p-3">
      <table class="table table-sm m-0">
       <thead>
        <tr>
         <th>Status</th>
         <th>Visit Date</th>
         <th>Assigned To</th>
         <th>Delivered On</th>
        </tr>
       </thead>
       <tbody>
        <tr>
         <td>
          <span class="badge badge-success">Fulfillment: <small>Withdrew Consent</small></span>
         </td>
         <td>
          2018-07-06
         </td>
         <td>
          Daragh Heitzman
         </td>
         <td>
          2018-06-28
         </td>
        </tr>
       </tbody>
      </table>
     </td>
    </tr>
    <tr data-toggle="collapse" data-target="#showme4" aria-expanded="false" aria-controls="showme4">
     <td>
      Shipment #4
     </td>
     <td>
      2019-01-24
     </td>
     <td>
      <div class="p-1 small border border-success alert-success d-inline-block">
       Visit #5
      </div>
     </td>
     <td>
      <span class="badge badge-dark">Fulfilled</span>
     </td>
    </tr>
    <tr id="showme4" class="collapse" data-parent="#tryMe">
     <td colspan="4" class="p-3">
      <table class="table table-sm m-0">
       <thead>
        <tr>
         <th>Status</th>
         <th>Visit Date</th>
         <th>Assigned To</th>
         <th>Delivered On</th>
        </tr>
       </thead>
       <tbody>
        <tr>
         <td>
          <span class="badge badge-success">Fulfillment: <small>Withdrew Consent</small></span>
         </td>
         <td>
          2018-07-06
         </td>
         <td>
          Daragh Heitzman
         </td>
         <td>
          2018-06-28
         </td>
        </tr>
       </tbody>
      </table>
     </td>
    </tr>
    <tr data-toggle="collapse" data-target="#showme3" aria-expanded="false" aria-controls="showme3">
     <td>
      Shipment #3
     </td>
     <td>
      2018-10-17
     </td>
     <td>
      <div class="p-1 small border border-success alert-success d-inline-block">
       Visit #4
      </div>
     </td>
     <td>
      <span class="badge badge-dark">Fulfilled</span>
     </td>
    </tr>
    <tr id="showme3" class="collapse" data-parent="#tryMe">
     <td colspan="4" class="p-3">
      <table class="table table-sm m-0">
       <thead>
        <tr>
         <th>Status</th>
         <th>Visit Date</th>
         <th>Assigned To</th>
         <th>Delivered On</th>
        </tr>
       </thead>
       <tbody>
        <tr>
         <td>
          <span class="badge badge-success">Fulfillment: <small>Withdrew Consent</small></span>
         </td>
         <td>
          2018-07-06
         </td>
         <td>
          Daragh Heitzman
         </td>
         <td>
          2018-06-28
         </td>
        </tr>
       </tbody>
      </table>
     </td>
    </tr>
    <tr data-toggle="collapse" data-target="#showme2" aria-expanded="false" aria-controls="showme2">
     <td>
      Shipment #2
     </td>
     <td>
      2018-08-10
     </td>
     <td>
      <div class="p-1 small border border-success alert-success d-inline-block">
       Visit #2
      </div>
      <div class="p-1 small border border-success alert-success d-inline-block">
       Visit #3
      </div>
     </td>
     <td>
      <span class="badge badge-dark">Fulfilled</span>
     </td>
    </tr>
    <tr id="showme2" class="collapse" data-parent="#tryMe">
     <td colspan="4" class="p-3">
      <table class="table table-sm m-0">
       <thead>
        <tr>
         <th></th>
         <th>Status</th>
         <th>Visit Date</th>
         <th>Assigned To</th>
         <th>Delivered On</th>
         <th></th>
        </tr>
       </thead>
       <tbody>
        <tr>
         <td>
          <div class="p-1 small border border-success alert-success d-inline-block">
           Visit #3
          </div>
         </td>
         <td>
          <span class="badge badge-success">Approved</span>
         </td>
         <td>
          2018-09-10
         </td>
         <td>
          Daragh Heitzman
         </td>
         <td>
          2018-08-10
         </td>
         <td class="text-right">
          <a class="btn btn-info btn-sm" href="#">
           <i class="far fa-edit"></i> Edit Visit
          </a>
         </td>
        </tr>
        <tr>
         <td>
          <div class="p-1 small border border-success alert-success d-inline-block">
           Visit #2
          </div>
         </td>
         <td>
          <span class="badge badge-success">Approved</span>
         </td>
         <td>
          2018-08-10
         </td>
         <td>
          Daragh Heitzman
         </td>
         <td>
          2018-08-10
         </td>
         <td class="text-right">
          <a class="btn btn-info btn-sm" href="#">
           <i class="far fa-edit"></i> Edit Visit
          </a>
         </td>
        </tr>
       </tbody>
      </table>
     </td>
    </tr>
    <tr data-toggle="collapse" data-target="#showme1" aria-expanded="false" aria-controls="showme1">
     <td>
      Shipment #1
     </td>
     <td>
      2018-07-26
     </td>
     <td>
      <div class="p-1 small border border-success alert-success d-inline-block">
       Visit #1
      </div>
     </td>
     <td>
      <span class="badge badge-dark">Fulfilled</span>
     </td>
    </tr>
    <tr id="showme1" class="collapse" data-parent="#tryMe">
     <td colspan="4" class="p-3">
      <table class="table table-sm m-0">
       <thead>
        <tr>
         <th></th>
         <th>Status</th>
         <th>Visit Date</th>
         <th>Assigned To</th>
         <th>Delivered On</th>
         <th></th>
        </tr>
       </thead>
       <tbody>
        <tr>
         <td>
          <div class="p-1 small border border-success alert-success d-inline-block">
           Visit #1
          </div>
         </td>
         <td>
          <span class="badge badge-success">Approved</span>
         </td>
         <td>
          N/A
         </td>
         <td>
          Daragh Heitzman
         </td>
         <td>
          2018-07-26
         </td>
         <td class="text-right">
          <a class="btn btn-info btn-sm" href="#">
           <i class="far fa-edit"></i> Edit Visit
          </a>
         </td>
        </tr>
       </tbody>
      </table>
     </td>
    </tr>
   </tbody>
  </table>
 </div>


@endsection