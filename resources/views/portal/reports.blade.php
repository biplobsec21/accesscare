@extends('layouts.portal')

@section('title')
 Reports (MOCKUP)
@endsection

@section('styles')
@endsection

@section('precontent')
 <div class="bg-gradient-primary border-bottom">
  <h4 class="p-3 mb-0 text-white">Generate Query Report</h4>
  <div class="row m-0">
   <div class="col-sm-auto col-lg pl-3 pr-3 border-top border-right border-primary">
    <div class="p-3">
     <div class="poppins mb-1 strong text-white">
      Countries
     </div>
     <select class="form-control select2" type="text" name="filters[country_id]" multiple>
      <option value="">-- Select --</option>
      <option value="J6HFADRA" selected>US - United States</option>
      <option value="3R00TQ6U">AE - United Arab Emirates </option>
      <option value="1SEGT5PD">AR - Argentina </option>
      <option value="SPFBRI15">AT - Austria</option>
      <option value="U8PPGURR">AU - Australia</option>
      <option value="VB8VX1LK">BE - Belgium</option>
      <option value="848RAE2A">BG - Bulgaria</option>
      <option value="NLDA8BS2">BR - Brazil </option>
      <option value="BOS4K1PD">CA - Canada</option>
      <option value="OPC085CE">CH - Switzerland</option>
      <option value="K60VG5QY">CL - Chile</option>
      <option value="YXMVWWU9">CN - China</option>
      <option value="97KSLF7N" selected>CO - Colombia </option>
      <option value="AIHRP7VH">CR - Costa Rica</option>
      <option value="DA6EKDSL">CU - Cuba </option>
      <option value="ZPYWWU6N">CZ - Czech Republic</option>
      <option value="JV5UNG1T">DE - Germany</option>
      <option value="MYZCBGIL">DK - Denmark</option>
      <option value="B6OMTKTE">EE - Estonia</option>
      <option value="BMCLNMVU">EGY - Egypt</option>
      <option value="F0P5U87L">ES - Spain</option>
      <option value="I1O9T8G9">EY - Belarus</option>
      <option value="5N8XBM4R">FI - Finland</option>
      <option value="ZPJJIYVX">FR - France</option>
      <option value="T9OFFV3G">GB - United Kingdom</option>
      <option value="OUZF1PC3">GR - Greece</option>
      <option value="B0969EGF">GT - Guatemala </option>
      <option value="JQM0CAJA">HK - Hong Kong</option>
      <option value="KXRNA8HJ">HU - Hungary</option>
      <option value="SX88WZGG">IE - Ireland</option>
      <option value="1NLR2Y95">IL - Israel</option>
      <option value="WQR24E04">IN - India </option>
      <option value="I6RGLYS4">IS - Iceland</option>
      <option value="LDYPEHQ4">IT - Italy</option>
      <option value="QGY3XZC0">JM - Jamaica </option>
      <option value="WU91KIOI">JP - Japan</option>
      <option value="MQ6JJFPV">KR - Korea (S)</option>
      <option value="1K7EDD7J">LT - Lithuania</option>
      <option value="V3WZFSKF">LU - Luxembourg </option>
      <option value="D0SLCTGF">LV - Latvia</option>
      <option value="ZVHND52D">MA - Morocco</option>
      <option value="072LYHQU">MC - Monaco</option>
      <option value="7CF722XS">MT - Malta</option>
      <option value="A44CVFRL">MX - Mexico</option>
      <option value="1IFF4VKI">MY - Malaysia</option>
      <option value="GXLDQPQY">NL - Netherlands</option>
      <option value="SM7KKIBN">NO - Norway</option>
      <option value="VE7Q5K20">NZ - New Zealand</option>
      <option value="Q8HSKGPH">PA - Panama </option>
      <option value="11J0H81P">PE - Peru</option>
      <option value="HIV7CG8P">PER - Peru</option>
      <option value="7GMCPQF5">PH - Philippines</option>
      <option value="VVN4WP1A">PK - Pakistan</option>
      <option value="BN8HW6KV">PL - Poland</option>
      <option value="IBI681NN">PT - Portugal</option>
      <option value="GJCD7ZU7">PY - Paraguay</option>
      <option value="4W2ZL9MH">RO - Romania</option>
      <option value="481BNBUZ">RU - Russia </option>
      <option value="DO0T6WLZ">SA - Saudi Arabia </option>
      <option value="V8NZVG15">SD - Sudan </option>
      <option value="PSW79V0W">SE - Sweden</option>
      <option value="S6PX6ZKE">SG - Singapore</option>
      <option value="08AVUDJZ">SI - Slovenia</option>
      <option value="Z7Y3CZ31">SK - Slovakia</option>
      <option value="VK10BRR8">TH - Thailand </option>
      <option value="2KCB6S2D">TN - Tunisia</option>
      <option value="I4YN9MT4">TN - Tunisia </option>
      <option value="3OZ25SEM">TR - Turkey</option>
      <option value="71TTEF9S">TWN - Taiwan</option>
      <option value="LZ20WFG2">UA - Ukraine</option>
      <option value="1IDLCHY6">VE - Venezuela </option>
      <option value="S0YO4H43">ZA - South Africa</option>
      <option value="02NDX6B4">ZW - Zimbabwe </option>
     </select>
    </div>
   </div>
   <div class="col-sm-auto col-lg pl-3 pr-3 border-top border-right border-primary">
    <div class="p-3">
     <div class="poppins mb-1 strong text-white">
      Pharma Company
     </div>
     <select class="form-control select2" multiple type="text" name="filters[company_id]">
      <option value="">-- Select --</option>
      <option value="M4Y0RBZP">Amicus Therapeutics</option>
      <option value="HACDR6VB">Biohaven Pharmaceuticals, Inc</option>
      <option value="6NQ19AD9" selected>Modis Therapeutics, Inc.</option>
      <option value="VM5XZ006">Origin Biosciences</option>
      <option value="ZU87YOEL">Pharnext SA</option>
     </select>
    </div>
   </div>
   <div class="col-sm-auto col-lg pl-3 pr-3 border-top border-right border-primary">
    <div class="p-3">
     <div class="poppins mb-1 strong text-white">
      Pharma Management Type
     </div>
     <select class="form-control" type="text" name="filters[company_management_status_id]">
      <option value="">-- Select --</option>
      <option value="EACMANAG" selected>EAC Managed</option>
      <option value="SELFMANA">Self Managed</option>
     </select>
    </div>
   </div>
   <div class="col-sm-auto col-lg pl-3 pr-3 border-top border-right border-primary">
    <div class="p-3">
     <div class="poppins mb-1 strong text-white">
      Managed By
     </div>
     <select class="form-control select2" multiple type="text" name="filters[admin_id]">
      <option value="">-- Select --</option>
      <option value="H5QVFIF7">Anne Cropp</option>
      <option value="X1L9MBWC">EAC</option>
      <option value="VFYMU0QQ">John and Anne</option>
      <option value="UDE3RI8U">John Cropp</option>
      <option value="BHUA89KA" selected>QIS</option>
      <option value="G29ZDAA8">Test Admin</option>
     </select>
    </div>
   </div>
   <div class="col-sm-auto col-lg pl-3 pr-3 border-top border-primary">
    <div class="p-3">
     <div class="poppins mb-1 strong text-white">
      RID Status
     </div>
     <select class="form-control select2" multiple type="text" name="filters[rid_status]">
      <option value="">-- Select --</option>
      <option value="InProcess">InProcess</option>
      <option value="Approved" selected>Approved</option>
      <option value="NotApproved">NotApproved</option>
      <option value="Docneeded">Docneeded</option>
      <option value="PendingReview">PendingReview</option>
      <option value="Resupplied">Resupplied</option>
      <option value="Hold">Hold</option>
     </select>
    </div>
   </div>
  </div>
  <div class="bg-primary p-2 text-center">
   <a href="#fauxJump" class="btn btn-success">
    <span class="fad fa-fw fa-wand-magic"></span> Generate Report
   </a>
  </div>
  <div class="p-3">
   <div class="d-flex justify-content-between flex-wrap align-items-center">
    <h3 class="poppins mb-1 text-white">
     1 - XX results for [QUERY]
    </h3>
    <div class="">
     <a href="#" class="btn btn-light btn-sm mr-2 disabled">
      <span class="fas fa-fw fa-save"></span> Save Report
     </a>
     <a href="#" class="btn btn-light btn-sm mr-2">
      <span class="fad fa-fw fa-file-export"></span> Export
     </a>
     <a href="#" class="btn btn-light btn-sm">
      <span class="fad fa-fw fa-print"></span> Print
     </a>
    </div>
   </div>
   <div class="selected">
    <span class="badge bg-light mr-2">
     US - United States
     <a href="#" class="ml-1 text-danger">x</a>
    </span>
    <span class="badge bg-light mr-2">
     CO - Colombia
     <a href="#" class="ml-1 text-danger">x</a>
    </span>
    <span class="badge bg-light mr-2">
     Modis Therapeutics, Inc.
     <a href="#" class="ml-1 text-danger">x</a>
    </span>
    <span class="badge bg-light mr-2">
     EAC Managed
     <a href="#" class="ml-1 text-danger">x</a>
    </span>
    <span class="badge bg-light mr-2">
     QIS
     <a href="#" class="ml-1 text-danger">x</a>
    </span>
    <span class="badge bg-light mr-2">
     Approved
     <a href="#" class="ml-1 text-danger">x</a>
    </span>
   </div>
  </div>
 </div>
@endsection

@section('content')
 <div class="row mt-xl-n3">
  <div class="col-sm-3">
   <div class="filterColumn">
    <div class="mb-3">
     <div class="poppins mb-1 strong">
      Date Range
     </div>
     <div class="input-group">
      <input type="date" class="form-control datepicker" value="{{date('Y-m-d')}}" name="" />
      <div class="input-group-append input-group-prepend">
       <span class="input-group-text">
        to
       </span>
      </div>
      <input type="date" class="form-control datepicker" value="{{date('Y-m-d', strtotime('+1 month'))}}" name="" />
     </div>
    </div>
    <hr />
    <div class="mb-3">
     <div class="poppins mb-1 strong">
      Show Columns
     </div>
     <ul class="list-unstyled">
      <li>
       <label for="rid_number" class="d-flex row m-0">
        <div class="col-auto pl-1 pr-1">
         <input type="checkbox" name="" value="" id="rid_number" checked="">
        </div>
        <div class="col pl-1 pr-1">
         RID
        </div>
       </label>
      </li>
      <li>
       <label for="rid_reason" class="d-flex row m-0">
        <div class="col-auto pl-1 pr-1">
         <input type="checkbox" name="" value="" id="rid_reason" checked="">
        </div>
        <div class="col pl-1 pr-1">
         Reason
        </div>
       </label>
      </li>
      <li>
       <label for="rid_status" class="d-flex row m-0">
        <div class="col-auto pl-1 pr-1">
         <input type="checkbox" name="" value="" id="rid_status" checked="">
        </div>
        <div class="col pl-1 pr-1">
         Status
        </div>
       </label>
      </li>
      <li>
       <label for="rid_ship_lot_number" class="d-flex row m-0">
        <div class="col-auto pl-1 pr-1">
         <input type="checkbox" name="" value="" id="rid_ship_lot_number" checked="">
        </div>
        <div class="col pl-1 pr-1">
         Lot Number
        </div>
       </label>
      </li>
      <li>
       <label for="rid_ship_quantity" class="d-flex row m-0">
        <div class="col-auto pl-1 pr-1">
         <input type="checkbox" name="" value="" id="rid_ship_quantity" checked="">
        </div>
        <div class="col pl-1 pr-1">
         Qty Shipped
        </div>
       </label>
      </li>
      <li>
       <label for="rid_depot" class="d-flex row m-0">
        <div class="col-auto pl-1 pr-1">
         <input type="checkbox" name="" value="" id="rid_depot" checked="">
        </div>
        <div class="col pl-1 pr-1">
         Depot
        </div>
       </label>
      </li>
      <li>
       <label for="rid_ship_tracking_number" class="d-flex row m-0">
        <div class="col-auto pl-1 pr-1">
         <input type="checkbox" name="" value="" id="rid_ship_tracking_number" checked="">
        </div>
        <div class="col pl-1 pr-1">
         Tracking Number
        </div>
       </label>
      </li>
      <li>
       <label for="rid_ship_delivery_date" class="d-flex row m-0">
        <div class="col-auto pl-1 pr-1">
         <input type="checkbox" name="" value="" id="rid_ship_delivery_date" checked="">
        </div>
        <div class="col pl-1 pr-1">
         Delivery Date
        </div>
       </label>
      </li>
      <li>
       <label for="rid_approved_added" class="d-flex row m-0">
        <div class="col-auto pl-1 pr-1">
         <input type="checkbox" name="" value="" id="rid_approved_added" checked="">
        </div>
        <div class="col pl-1 pr-1">
         RID Approval Date
        </div>
       </label>
      </li>
      <li>
       <label for="rid_not_approved_added" class="d-flex row m-0">
        <div class="col-auto pl-1 pr-1">
         <input type="checkbox" name="" value="" id="rid_not_approved_added" checked="">
        </div>
        <div class="col pl-1 pr-1">
         RID Not Approved Date
        </div>
       </label>
      </li>
      <li>
       <label for="rid_not_approved_reason_name" class="d-flex row m-0">
        <div class="col-auto pl-1 pr-1">
         <input type="checkbox" name="" value="" id="rid_not_approved_reason_name" checked="">
        </div>
        <div class="col pl-1 pr-1">
         RID Not Approved Reason
        </div>
       </label>
      </li>
      <li>
       <label for="rid_not_approved_explanation" class="d-flex row m-0">
        <div class="col-auto pl-1 pr-1">
         <input type="checkbox" name="" value="" id="rid_not_approved_explanation" checked="">
        </div>
        <div class="col pl-1 pr-1">
         RID Not Approved Explanation
        </div>
       </label>
      </li>
      <li>
       <label for="rid_shipment_status" class="d-flex row m-0">
        <div class="col-auto pl-1 pr-1">
         <input type="checkbox" name="" value="" id="rid_shipment_status" checked="">
        </div>
        <div class="col pl-1 pr-1">
         Ship Status
        </div>
       </label>
      </li>
      <li>
       <label for="rid_shipment_country" class="d-flex row m-0">
        <div class="col-auto pl-1 pr-1">
         <input type="checkbox" name="" value="" id="rid_shipment_country" checked="">
        </div>
        <div class="col pl-1 pr-1">
         Ship Country
        </div>
       </label>
      </li>
      <li>
       <label for="rid_request_date" class="d-flex row m-0">
        <div class="col-auto pl-1 pr-1">
         <input type="checkbox" name="" value="" id="rid_request_date" checked="">
        </div>
        <div class="col pl-1 pr-1">
         Request Date
        </div>
       </label>
      </li>
      <li>
       <label for="rid_resupply_date" class="d-flex row m-0">
        <div class="col-auto pl-1 pr-1">
         <input type="checkbox" name="" value="" id="rid_resupply_date" checked="">
        </div>
        <div class="col pl-1 pr-1">
         Resupply Date
        </div>
       </label>
      </li>
      <li>
       <label for="rid_patient_birthday" class="d-flex row m-0">
        <div class="col-auto pl-1 pr-1">
         <input type="checkbox" name="" value="" id="rid_patient_birthday" checked="">
        </div>
        <div class="col pl-1 pr-1">
         Patient Birthday
        </div>
       </label>
      </li>
      <li>
       <label for="rid_patient_gender" class="d-flex row m-0">
        <div class="col-auto pl-1 pr-1">
         <input type="checkbox" name="" value="" id="rid_patient_gender" checked="">
        </div>
        <div class="col pl-1 pr-1">
         Patient Gender
        </div>
       </label>
      </li>
      <li>
       <label for="drug_name" class="d-flex row m-0">
        <div class="col-auto pl-1 pr-1">
         <input type="checkbox" name="" value="" id="drug_name" checked="">
        </div>
        <div class="col pl-1 pr-1">
         Drug Name
        </div>
       </label>
      </li>
      <li>
       <label for="route_admin_name" class="d-flex row m-0">
        <div class="col-auto pl-1 pr-1">
         <input type="checkbox" name="" value="" id="route_admin_name" checked="">
        </div>
        <div class="col pl-1 pr-1">
         Route of Administration
        </div>
       </label>
      </li>
      <li>
       <label for="drug_dosage_stock" class="d-flex row m-0">
        <div class="col-auto pl-1 pr-1">
         <input type="checkbox" name="" value="" id="drug_dosage_stock" checked="">
        </div>
        <div class="col pl-1 pr-1">
         Stock Level
        </div>
       </label>
      </li>
      <li>
       <label for="drug_dosage_unit_amount" class="d-flex row m-0">
        <div class="col-auto pl-1 pr-1">
         <input type="checkbox" name="" value="" id="drug_dosage_unit_amount" checked="">
        </div>
        <div class="col pl-1 pr-1">
         Dose
        </div>
       </label>
      </li>
      <li>
       <label for="drug_dosage_concentration_amount" class="d-flex row m-0">
        <div class="col-auto pl-1 pr-1">
         <input type="checkbox" name="" value="" id="drug_dosage_concentration_amount" checked="">
        </div>
        <div class="col pl-1 pr-1">
         Concentration
        </div>
       </label>
      </li>
      <li>
       <label for="drug_dosage_strength" class="d-flex row m-0">
        <div class="col-auto pl-1 pr-1">
         <input type="checkbox" name="" value="" id="drug_dosage_strength" checked="">
        </div>
        <div class="col pl-1 pr-1">
         Drug Formulation Strength
        </div>
       </label>
      </li>
      <li>
       <label for="drug_date_of_submission" class="d-flex row m-0">
        <div class="col-auto pl-1 pr-1">
         <input type="checkbox" name="" value="" id="drug_date_of_submission" checked="">
        </div>
        <div class="col pl-1 pr-1">
         Drug Approval Date
        </div>
       </label>
      </li>
      <li>
       <label for="rid_created_by" class="d-flex row m-0">
        <div class="col-auto pl-1 pr-1">
         <input type="checkbox" name="" value="" id="rid_created_by" checked="">
        </div>
        <div class="col pl-1 pr-1">
         Requesting Physician
        </div>
       </label>
      </li>
      <li>
       <label for="company_name" class="d-flex row m-0">
        <div class="col-auto pl-1 pr-1">
         <input type="checkbox" name="" value="" id="company_name" checked="">
        </div>
        <div class="col pl-1 pr-1">
         Pharmaceutical Company
        </div>
       </label>
      </li>
     </ul>
     <hr />
    </div>
   </div><!-- /.filterColumn -->
  </div>
  <div class="col-sm-9">
   <a name="fauxJump"></a>
   <div class="titleBar">
    <h4 class="mb-3">@yield('title')</h4>
   </div>
   search results
  </div>
 </div>
@endsection