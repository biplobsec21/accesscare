@extends('layouts.portal')

@section('title')
 QuasarEsh's Testing (test 2) Page
@endsection

@section('styles')
@endsection

@section('content')
 <pre>QuasarEsh test-2 page</pre>

 <div class="d-flex justify-content-between align-items-center">
  <h3 class="mb-3 mb-xl-4">
   Welcome to your
   <strong>Dashboard,</strong>
   <span class="text-info">Developer</span>
  </h3>
  <span class="badge badge-primary d-none d-md-inline">Early Access Care</span>
 </div>

     <div class="dashCards">
   <div class="row">
    <div class="col-sm-6 col-xl mb-3 mb-xl-5">
    <div class="poppins alert alert-warning p-2 small">
     <span class="fa-exclamation-triangle fad fa-fw fa-lg text-warning"></span> 8 New Requests
    </div>
     <div class="card">
    <div class="card-body p-3">
   <i class="boxcon fad fa-medkit text-secondary"></i>
   <div class="row">
    <div class="col mb-1 mb-md-3 ">
     <a href="http://127.0.0.1:8000/portal/rid/list" class="h4 mb-0" title="View All Requests">
      <strong>101</strong>
      Requests
     </a>
    </div>
         <div class="col-auto mb-3">
      <a class="badge text-dark" data-toggle="collapse" title="Expand Request Details" href="#showRIDstats" role="button" aria-expanded="false" aria-controls="showRIDstats">
      Show Details
      </a>
     </div>
       </div><!-- /.row -->
   <div class="text-xl-center poppins">
    "Initiate New Request" initiates a drug order for investigational drug.
   </div>
       <div class="collapse" id="showRIDstats">
     <ul class="list-group list-group-flush mb-0 small">
             <li class="list-group-item pt-1 pb-1 text-danger">
        <a href="http://127.0.0.1:8000/portal/rid/list">
         <div class="row m-0">
          <div class="col p-0">
           New
            <i class="fas fa-exclamation-triangle text-danger"></i>
          </div>
          <div class="col-auto p-0">
           <span class="badge badge-danger">
            8
           </span>
          </div>
         </div><!-- /.row -->
        </a>
       </li>
       <li class="list-group-item pt-1 pb-1">
        <a href="http://127.0.0.1:8000/portal/rid/list">
         <div class="row m-0">
          <div class="col p-0">
           Pending
          </div>
          <div class="col-auto p-0">
           <span class="badge badge-light">
            24
           </span>
          </div>
         </div><!-- /.row -->
        </a>
       </li>
       <li class="list-group-item pt-1 pb-1">
        <a href="http://127.0.0.1:8000/portal/rid/list">
         <div class="row m-0">
          <div class="col p-0">
           Fulfillment
          </div>
          <div class="col-auto p-0">
           <span class="badge badge-light">
            15
           </span>
          </div>
         </div><!-- /.row -->
        </a>
       </li>
       <li class="list-group-item pt-1 pb-1">
        <a href="http://127.0.0.1:8000/portal/rid/list">
         <div class="row m-0">
          <div class="col p-0">
           Completed
          </div>
          <div class="col-auto p-0">
           <span class="badge badge-light">
            4
           </span>
          </div>
         </div><!-- /.row -->
        </a>
       </li>
       <li class="list-group-item pt-1 pb-1">
        <a href="http://127.0.0.1:8000/portal/rid/list">
         <div class="row m-0">
          <div class="col p-0">
           Approved
          </div>
          <div class="col-auto p-0">
           <span class="badge badge-light">
            2
           </span>
          </div>
         </div><!-- /.row -->
        </a>
       </li>
           </ul>
    </div>
   
   

   <div class="mt-3 d-flex justify-content-between flex-wrap">
    <div><!-- empty --></div>
    <a class="btn btn-link btn-sm" href="http://127.0.0.1:8000/portal/rid/list" title="View All Requests">
     View All Requests <span class="fal fa-long-arrow-right"></span>
    </a>
   </div>
  </div>
  <a href="http://127.0.0.1:8000/portal/rid/create" class="btn btn-primary border-0 btn-block h5 mb-0 p-0" title="Initiate New Request">
   <div class="p-1 pl-2 pr-2 p-xl-3 d-flex justify-content-between align-items-center">
    <span>Initiate New Request</span>
    <span class="fa-fw fad fa-lg fa-medkit"></span>
   </div>
  </a>
 </div>
    </div>
    <div class="col-sm-6 col-xl mb-3 mb-xl-5">
     <div class="poppins alert alert-info p-2 small">
    <span class="fa-check-circle fad fa-fw fa-lg text-info"></span> No Pending Drugs
   </div>
     <div class="card">
   
    <div class="card-body p-3">
   <i class="boxcon fad fa-capsules text-secondary"></i>
   <div class="row">
    <div class="col mb-1 mb-md-3 ">
     <a href="http://127.0.0.1:8000/portal/drug/list" class="h4 mb-0 " title="View All Drugs">
      <strong>10</strong>
      Drugs
     </a>
    </div>
         <div class="col-auto mb-3">
      <a class="badge text-dark" data-toggle="collapse" title="Expand Drug Details" href="#showDRUGstats" role="button" aria-expanded="false" aria-controls="showDRUGstats">
       Show Details
      </a>
     </div>
       </div><!-- /.row -->
   <div class="text-xl-center poppins">
    Manage investigative drugs within the platform
   </div>
       <div class="collapse" id="showDRUGstats">
     <ul class="list-group list-group-flush mb-0 small">
      <li class="list-group-item pt-1 pb-1">
       <a href="http://127.0.0.1:8000/portal/drug/list">
        <div class="row m-0">
         <div class="col p-0">
          Not Approved
         </div>
         <div class="col-auto p-0">
          <span class="badge badge-light">
           0
          </span>
         </div>
        </div><!-- /.row -->
       </a>
      </li>
      <li class="list-group-item pt-1 pb-1">
       <a href="http://127.0.0.1:8000/portal/drug/list">
        <div class="row m-0">
         <div class="col p-0">
          Pending
         </div>
         <div class="col-auto p-0">
          <span class="badge badge-light">
           5
          </span>
         </div>
        </div><!-- /.row -->
       </a>
      </li>
      <li class="list-group-item pt-1 pb-1">
       <a href="http://127.0.0.1:8000/portal/drug/list">
        <div class="row m-0">
         <div class="col p-0">
          Approved
         </div>
         <div class="col-auto p-0">
          <span class="badge badge-light">
           5
          </span>
         </div>
        </div><!-- /.row -->
       </a>
      </li>
     </ul>
    </div>
      <div class="mt-3 d-flex justify-content-between flex-wrap">
    <div><!-- empty --></div>
    <a class="btn btn-link btn-sm" href="http://127.0.0.1:8000/portal/drug/list">
     View All Drugs <span class="fal fa-long-arrow-right"></span>
    </a>
   </div>
  </div>
  <a href="http://127.0.0.1:8000/portal/drug/create" class="btn btn-light border-0 btn-block h5 mb-0 p-0">
   <div class="p-1 pl-2 pr-2 p-xl-3 d-flex justify-content-between align-items-center">
    <span>Add Drug</span>
    <span class="fa-fw fad fa-lg fa-capsules"></span>
   </div>
  </a>
 </div>
    </div>
    <div class="col-sm-6 col-xl mb-3 mb-xl-5">
    <div class="poppins alert alert-warning p-2 small">
     <span class="fa-exclamation-triangle fad fa-fw fa-lg text-warning"></span> 2 Pending Physicians
    </div>
     <div class="card">
    <div class="card-body p-3">
   <i class="boxcon fad fa-user-md text-secondary"></i>
   <div class="row">
    <div class="col mb-1 mb-md-3 ">
     <a href="http://127.0.0.1:8000/portal/user/list" class="h4 mb-0" title="View All Users">
      <strong>106</strong>
      Users
     </a>
    </div>
         <div class="col-auto mb-3">
      <a class="badge text-dark" data-toggle="collapse" title="Expand User Details" href="#showUSERstats" role="button" aria-expanded="false" aria-controls="showUSERstats">
       Show Details
      </a>
     </div>
       </div><!-- /.row -->
   <div class="text-xl-center poppins">
    Create and manage all user types within the platform.
   </div>
       <div class="collapse" id="showUSERstats">
     <ul class="list-group list-group-flush mb-0 small">
      <li class="list-group-item pt-1 pb-1 text-danger">
       <a href="http://127.0.0.1:8000/portal/user/list">
        <div class="row m-0">
         <div class="col p-0">
          Pending
          <i class="fas fa-exclamation-triangle text-danger"></i>
         </div>
         <div class="col-auto p-0">
          <span class="badge badge-danger">17</span>
         </div>
        </div><!-- /.row -->
       </a>
      </li>
      <li class="list-group-item pt-1 pb-1">
       <a href="http://127.0.0.1:8000/portal/user/list">
        <div class="row m-0">
         <div class="col p-0">
          Registering
         </div>
         <div class="col-auto p-0">
          <span class="badge badge-light">5</span>
         </div>
        </div><!-- /.row -->
       </a>
      </li>
      <li class="list-group-item pt-1 pb-1">
       <a href="http://127.0.0.1:8000/portal/user/list">
        <div class="row m-0">
         <div class="col p-0">
          Approved
         </div>
         <div class="col-auto p-0">
          <span class="badge badge-light">81</span>
         </div>
        </div><!-- /.row -->
       </a>
       <ul class="list-unstyled small ml-3 mb-0">
        <li class="pt-1 pb-1">
         <a href="http://127.0.0.1:8000/portal/user/list">
          <div class="row m-0">
           <div class="col p-0">
            Physician Users
           </div>
           <div class="col-auto p-0">
            <span class="badge badge-light">
             50
            </span>
           </div>
          </div><!-- /.row -->
         </a>
        </li>
        <li class="pt-1 pb-1">
         <a href="http://127.0.0.1:8000/portal/user/list">
          <div class="row m-0">
           <div class="col p-0">
            Pharmaceutical Users
           </div>
           <div class="col-auto p-0">
            <span class="badge badge-light">
             17
            </span>
           </div>
          </div><!-- /.row -->
         </a>
        </li>
        <li class="pt-1 pb-1">
         <a href="http://127.0.0.1:8000/portal/user/list">
          <div class="row m-0">
           <div class="col p-0">
            Early Access Care Users
           </div>
           <div class="col-auto p-0">
            <span class="badge badge-light">
             14
            </span>
           </div>
          </div><!-- /.row -->
         </a>
        </li>
       </ul>
      </li>
      <li class="list-group-item pt-1 pb-1">
       <a href="http://127.0.0.1:8000/portal/user/list">
        <div class="row m-0">
         <div class="col p-0">
          Suspended
         </div>
         <div class="col-auto p-0">
          <span class="badge badge-light">3</span>
         </div>
        </div><!-- /.row -->
       </a>
      </li>
     </ul>
    </div>
      <div class="mt-3 d-flex justify-content-between flex-wrap">
    <div><!-- empty --></div>
    <a class="btn btn-link btn-sm" href="http://127.0.0.1:8000/portal/user/list">
     View All Users <span class="fal fa-long-arrow-right"></span>
    </a>
   </div>
  </div>
  <a href="http://127.0.0.1:8000/portal/user/create" class="btn btn-light border-0 btn-block h5 mb-0 p-0">
   <div class="p-1 pl-2 pr-2 p-xl-3 d-flex justify-content-between align-items-center">
    <span>Create User</span>
    <span class="fa-fw fad fa-lg fa-user-md"></span>
   </div>
  </a>
 </div>
    </div>
    <div class="col-sm-6 col-xl mb-3 mb-xl-5">
    <div class="poppins alert alert-warning p-2 small">
     <span class="fa-exclamation-triangle fad fa-fw fa-lg text-warning"></span> 2 Users without Groups
    </div>
     <div class="card">
    <div class="card-body p-3">
   <i class="boxcon fad fa-users text-secondary"></i>
   <div class="row">
    <div class="col mb-1 mb-md-3 ">
     <a href="http://127.0.0.1:8000/portal/user/group/list" class="h4 mb-0" title="View All User Groups">
      <strong>12</strong>
      User Groups
     </a>
    </div>
         <div class="col-auto mb-3">
      <a class="badge text-dark" data-toggle="collapse" title="Expand User Details" href="#showGROUPstats" role="button" aria-expanded="false" aria-controls="showGROUPstats">
       Show Details
      </a>
     </div>
       </div><!-- /.row -->
   <div class="text-xl-center poppins">
    Establish user groups within your practice/hospital
   </div>
       <div class="collapse" id="showGROUPstats">
     <ul class="list-group list-group-flush mb-0 small">
      <li class="list-group-item pt-1 pb-1">
       <a href="http://127.0.0.1:8000/portal/user/group/list" title="View All User Groups">
        <div class="row m-0">
         <div class="col p-0">
          Physician Groups
         </div>
         <div class="col-auto p-0">
          <span class="badge badge-light">
           #
          </span>
         </div>
        </div><!-- /.row -->
       </a>
      </li>
      <li class="list-group-item pt-1 pb-1">
       <a href="http://127.0.0.1:8000/portal/user/group/list" title="View All User Groups">
        <div class="row m-0">
         <div class="col p-0">
          Pharmaceutical Groups
         </div>
         <div class="col-auto p-0">
          <span class="badge badge-light">
           #
          </span>
         </div>
        </div><!-- /.row -->
       </a>
      </li>
      <li class="list-group-item pt-1 pb-1">
       <a href="http://127.0.0.1:8000/portal/user/group/list" title="View All User Groups">
        <div class="row m-0">
         <div class="col p-0">
          Early Access Care Groups
         </div>
         <div class="col-auto p-0">
          <span class="badge badge-light">
           #
          </span>
         </div>
        </div><!-- /.row -->
       </a>
      </li>
     </ul>
    </div>
      <div class="mt-3 d-flex justify-content-between flex-wrap">
    <div><!-- empty --></div>
    <a class="btn btn-link btn-sm" href="http://127.0.0.1:8000/portal/user/group/list" title="View All User Groups">
     View All User Groups <span class="fal fa-long-arrow-right"></span>
    </a>
   </div>
  </div>
  <a href="http://127.0.0.1:8000/portal/user/group/create" class="btn btn-light border-0 btn-block h5 mb-0 p-0" title="Create User Groups">
   <div class="p-1 pl-2 pr-2 p-xl-3 d-flex justify-content-between align-items-center">
    <span>Create User Group</span>
    <span class="fa-fw fad fa-lg fa-users"></span>
   </div>
  </a>
 </div>
    </div>
   </div>
  </div>
  <div class="viewData">
   <h3 class="mb-3">Pending Shipments</h3>
<div class="card mb-1 mb-md-4">
 <div class="card-header">
  
  <div class="row align-items-end">
   <div class="col-sm col-xl-auto mb-2">
    <label class="d-block">Request Date</label>
    <div class="input-group mb-0">
     <input type="text" name="" value="2019-08-02" class="form-control datepicker" style="min-width: 8rem" />
     <div class="input-group-append input-group-prepend">
      <span class="input-group-text">to</span>
     </div>
     <input type="text" name="" value="2019-08-23" class="form-control datepicker" style="min-width: 8rem" />
    </div>
   </div>
   <div class="col-sm col-xl-auto mb-2">
    <label class="d-block">Drug Requested</label>
    <select class="form-control" name="">
     <option>-- Select --</option>
     <option value="">Test 1</option>
     <option value="">Test 2</option>
     <option value="">Test 3</option>
     <option value="">Test 4</option>
    </select>
   </div>
   <div class="col-sm col-xl-auto mb-2">
    <label class="d-block">Physician</label>
    <select class="form-control" name="">
     <option>-- Select --</option>
     <option value="">Test 1</option>
     <option value="">Test 2</option>
     <option value="">Test 3</option>
     <option value="">Test 4</option>
    </select>
   </div>
   <div class="col-sm-auto mb-2">
    <button type="submit" name="" value="" class="btn btn-dark">
     Apply Filter(s)
    </button>
   </div>
  </div>
 </div>
 <div class="table-responsive">
  <table class="table table-sm table-striped table-hover w-100" id="shipmentListTBL">
   <thead>
   <tr>
    <th class="no-search no-sort"></th>
    <th>RID Number</th>
    <th>Drug Requested</th>
    <th>Ship By</th>
    <th>Physician</th>
    <th class="no-search no-sort"></th>
   </tr>
   </thead>
   <tbody><tr role="row" class="odd"><td>10 Jul, 2019</td><td class="sorting_1"><a href="http://127.0.0.1:8000/portal/rid/show/Mjl9aZFuuz">AMI-20180713-749S20Z0</a></td><td>Migalastat (Galafold)</td><td></td><td><a href="http://127.0.0.1:8000/portal/user/show/QVITSqrzUC">Roberto Giugliani</a></td><td><a href="http://127.0.0.1:8000/portal/rid/show/Mjl9aZFuuz" class="btn btn-primary btn-sm"><i class="far fa-sm fa-search"></i> View</a></td></tr><tr role="row" class="even"><td>10 Jul, 2019</td><td class="sorting_1"><a href="http://127.0.0.1:8000/portal/rid/show/ksPnVdu9dg">AMI-20180713-C1DX1MP0</a></td><td>Migalastat (Galafold)</td><td></td><td><a href="http://127.0.0.1:8000/portal/user/show/QVITSqrzUC">Roberto Giugliani</a></td><td><a href="http://127.0.0.1:8000/portal/rid/show/ksPnVdu9dg" class="btn btn-primary btn-sm"><i class="far fa-sm fa-search"></i> View</a></td></tr><tr role="row" class="odd"><td>10 Jul, 2019</td><td class="sorting_1"><a href="http://127.0.0.1:8000/portal/rid/show/8TUV4F56l2">AMI-20180713-CEJAFGR3</a></td><td>Migalastat (Galafold)</td><td></td><td><a href="http://127.0.0.1:8000/portal/user/show/QVITSqrzUC">Roberto Giugliani</a></td><td><a href="http://127.0.0.1:8000/portal/rid/show/8TUV4F56l2" class="btn btn-primary btn-sm"><i class="far fa-sm fa-search"></i> View</a></td></tr><tr role="row" class="even"><td>10 Jul, 2019</td><td class="sorting_1"><a href="http://127.0.0.1:8000/portal/rid/show/kysvav9PzN">AMI-20180713-IGIR3C3O</a></td><td>Migalastat (Galafold)</td><td></td><td><a href="http://127.0.0.1:8000/portal/user/show/a5UyRWssaZ">Usama A. Azim Sharaf ElDin</a></td><td><a href="http://127.0.0.1:8000/portal/rid/show/kysvav9PzN" class="btn btn-primary btn-sm"><i class="far fa-sm fa-search"></i> View</a></td></tr><tr role="row" class="odd"><td>10 Jul, 2019</td><td class="sorting_1"><a href="http://127.0.0.1:8000/portal/rid/show/teEVumAYsm">AMI-20180713-SCPOWAAV</a></td><td>Migalastat (Galafold)</td><td></td><td><a href="http://127.0.0.1:8000/portal/user/show/DZLIdPQc0m">Hernan Amartino</a></td><td><a href="http://127.0.0.1:8000/portal/rid/show/teEVumAYsm" class="btn btn-primary btn-sm"><i class="far fa-sm fa-search"></i> View</a></td></tr><tr role="row" class="even"><td>10 Jul, 2019</td><td class="sorting_1"><a href="http://127.0.0.1:8000/portal/rid/show/vNs0hFNNee">AMI-20190414-E0PWDE49</a></td><td>ATB200</td><td></td><td><a href="http://127.0.0.1:8000/portal/user/show/ZhT1vJyhGh">Yin-Hsiu Chien</a></td><td><a href="http://127.0.0.1:8000/portal/rid/show/vNs0hFNNee" class="btn btn-primary btn-sm"><i class="far fa-sm fa-search"></i> View</a></td></tr><tr role="row" class="odd"><td>15 Aug, 2019</td><td class="sorting_1"><a href="http://127.0.0.1:8000/portal/rid/show/7WNQngmffp">AMI-20190414-YBOUNEPB</a></td><td>ATB200</td><td>2019-08-01</td><td><a href="http://127.0.0.1:8000/portal/user/show/ZhT1vJyhGh">Yin-Hsiu Chien</a></td><td><a href="http://127.0.0.1:8000/portal/rid/show/7WNQngmffp" class="btn btn-primary btn-sm"><i class="far fa-sm fa-search"></i> View</a></td></tr><tr role="row" class="even"><td>10 Jul, 2019</td><td class="sorting_1"><a href="http://127.0.0.1:8000/portal/rid/show/7WNQngmffp">AMI-20190414-YBOUNEPB</a></td><td>ATB200</td><td></td><td><a href="http://127.0.0.1:8000/portal/user/show/ZhT1vJyhGh">Yin-Hsiu Chien</a></td><td><a href="http://127.0.0.1:8000/portal/rid/show/7WNQngmffp" class="btn btn-primary btn-sm"><i class="far fa-sm fa-search"></i> View</a></td></tr><tr role="row" class="odd"><td>11 Jul, 2019</td><td class="sorting_1"><a href="http://127.0.0.1:8000/portal/rid/show/7DZ2bTXc56">AMI-20190711-11IQSC0O</a></td><td>Migalastat (Galafold)</td><td></td><td><a href="http://127.0.0.1:8000/portal/user/show/98BzxMz4nY">Allison Newell-Sturdivant</a></td><td><a href="http://127.0.0.1:8000/portal/rid/show/7DZ2bTXc56" class="btn btn-primary btn-sm"><i class="far fa-sm fa-search"></i> View</a></td></tr><tr role="row" class="even"><td>12 Jul, 2019</td><td class="sorting_1"><a href="http://127.0.0.1:8000/portal/rid/show/YomU6KKull">AMI-20190712-BN8NQ2XR</a></td><td>Migalastat (Galafold)</td><td></td><td><a href="http://127.0.0.1:8000/portal/user/show/98BzxMz4nY">Allison Newell-Sturdivant</a></td><td><a href="http://127.0.0.1:8000/portal/rid/show/YomU6KKull" class="btn btn-primary btn-sm"><i class="far fa-sm fa-search"></i> View</a></td></tr></tbody>
  </table>
 </div>
</div>

  </div>

@endsection
