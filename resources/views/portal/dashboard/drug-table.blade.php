<div class="card-body pt-3 pl-3 pr-3 pb-0">
	<h5 class="text-primary strong text-upper mb-3">
		Drugs </h5>
</div>
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
