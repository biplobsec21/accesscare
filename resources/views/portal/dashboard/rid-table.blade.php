<div class="card-body pt-3 pl-3 pr-3 pb-0">
 <h5 class="text-primary strong text-upper mb-3">
  RIDs </h5>
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
