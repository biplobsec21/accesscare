<div class="card mb-1 mb-md-4">
 <div class="card-body">
  <h3 class="mb-0 ">Investigative Drugs</h3>
 </div>
 @if(\Auth::user()->type->name == 'Early Access Care')
  <div class="card-header">
   {{--
    * * * PLEASE UTILIZE THIS PLUGIN * * * https://datatables.net/plug-ins/filtering/row-based/range_dates * * * 
   --}}
   <div class="row align-items-end">
    <div class="col-sm col-xl-auto mb-2">
     <label class="d-block">Company</label>
     <select class="form-control" name="">
      <option>-- Select --</option>
      <option value="">Test 1</option>
      <option value="">Test 2</option>
      <option value="">Test 3</option>
      <option value="">Test 4</option>
     </select>
    </div>
    <div class="col-sm col-xl-auto mb-2">
     <label class="d-block">Status</label>
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
 @endif
 <div class="table-responsive">
 	<table class="table table-sm table-striped table-hover drugtable" id="drugListTBL">
 		<thead>
 		<tr>
 			<th>Drug Name</th>
 			<th>Company</th>
 			<th class="no-search">Status</th>
 			<th>Submitted Date</th>
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
   let $url = "{{route('eac.portal.drug.ajax.list')}}";
   // Data Tables
   $('#drugListTBL').initDT({
    ajax: {
     url: $url,
     type: "post",
     fields: [
      {
       data: "name",
       type: "link",
       href: "view_route"
      },
      {
       data: "company-name",
      },
      {
       data: "status",
      },
      {
       data: "created_at"
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
    order: [[0, 'asc']],
   });
  }); // end doc ready
 </script>
@append
