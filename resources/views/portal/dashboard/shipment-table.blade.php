<div class="card-body pt-3 pl-3 pr-3 pb-0">
	<h5 class="text-primary strong text-upper mb-3">
		Pending Shipments </h5>
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
