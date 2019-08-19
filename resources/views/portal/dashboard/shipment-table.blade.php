<h3 class="mb-3">Pending Shipments</h3>
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
 		<tbody></tbody>
 	</table>
 </div>
</div>
