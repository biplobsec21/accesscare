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

@section('scripts')
	<script type="text/javascript">
  $(document).ready(function () {
   function ridShipFormat($d) {
    return '<table>' +
     '<tr>' +
     '<td>Delivery By Date:</td>' +
     '<td>' + $d.deliver_by_date + '</td>' +
     '</tr>' +
     '<tr>' +
     '<td>Destination:</td>' +
     '<td>' + $d.destination + '</td>' +
     '</tr>' +
     '</table>';
   }
	  
   let $url = "{{route('eac.portal.shipment.list')}}";
   // Data Tables
   let dataTable = $('#shipmentListTBL').initDT({
    ajax: {
     url: $url,
     type: "post",
     fields: [
      {
       data: "created_at",
      },
      {
       data: "rid-number",
       type: "link",
       href: "rid-view_route"
      },
      {
       data: "rid-drug-name"
      },
      {
       data: "ship_by_date",
      },
      {
       data: "rid-physician-full_name",
       type: "link",
       href: "rid-physician-view_route"
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
    order: [[1, 'asc']],
   });
   $('#shipmentListTBL').on('click', 'td.details-control', function () {
    var tr = $(this).closest('tr');
    var row = dataTable.row(tr);

    if (row.child.isShown()) {
     // This row is already open - close it
     row.child.hide();
     tr.removeClass('shown');
    } else {
     // Open this row
     row.child(ridShipFormat(row.data())).show();
     tr.addClass('shown');
    }
   });
  }); // end doc ready
	</script>
@append
