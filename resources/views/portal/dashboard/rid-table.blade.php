<h3 class="mb-3">Requests (RIDs)</h3>
<div class="card mb-1 mb-md-4">
 <div class="card-header">
  {{--
   * * * PLEASE UTILIZE THIS PLUGIN * * * https://datatables.net/plug-ins/filtering/row-based/range_dates * * * 
 --}}
  <div class="row align-items-end">
   <div class="col-sm col-xl-auto mb-2">
    <label class="d-block">Request Date</label>
    <div class="input-group mb-0">
     <input type="text" name="" value="{{date('Y-m-d', strtotime('-14 days'))}}" class="form-control form-control-sm datepicker" style="min-width: 8rem" />
     <div class="input-group-append input-group-prepend">
      <span class="input-group-text">to</span>
     </div>
     <input type="text" name="" value="{{date('Y-m-d', strtotime('+7 days'))}}" class="form-control form-control-sm datepicker" style="min-width: 8rem" />
    </div>
   </div>
   <div class="col-sm col-xl-auto mb-2">
    <label class="d-block">Request Status</label>
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
   <div class="col-sm-auto mb-2">
    <button type="submit" name="" value="" class="btn btn-dark">
     Apply Filter(s)
    </button>
   </div>
  </div>
 </div>
 <div class="table-responsive">
  <table class="table table-sm table-striped table-hover " id="ridListTBL">
   <thead>
   <tr>
    <th>Request Date</th>
    <th>RID Number</th>
    <th class="no-search">Visits</th>
    <th class="no-search">Request Status</th>
    <th>Physician</th>
    <th>Drug Requested</th>
    <th class="no-search no-sort"></th>
   </tr>
   </thead>
   <tbody></tbody>
  </table>
 </div>
</div>
@section('scripts')
 <script type="text/javascript">
  $(document).ready(function () {
   let $url = "{{route('eac.portal.rid.ajax.list')}}";
   // Data Tables
   $('#ridListTBL').initDT({
    ajax: {
     url: $url,
     type: "post",
     fields: [
      {
       data: "created_at",
      },
      {
       data: "number",
       type: "link",
       href: "view_route"
      },
      {
       data: "visits",
       type: "count"
      },
      {
       data: "status-name",
      },
      {
       data: "physician-full_name",
       type: "link",
       href: "physician-view_route"
      },
      {
       data: "drug-name"
      },
      {
       data: "view_route",
       type: "btn",
       classes: "btn btn-primary btn-sm",
       icon: '<i class="far fa-sm fa-search"></i>',
       text: "View"
      },
     ],
    },
    order: [[0, 'desc']],
   });
  }); // end doc ready
 </script>
@append
