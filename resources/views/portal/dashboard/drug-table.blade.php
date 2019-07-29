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
		<tfoot>
		<tr>
			<th>Drug Name</th>
			<th>Company</th>
			<th class="no-search">Status</th>
			<th>Submitted Date</th>
			<th class="no-search"></th>
		</tr>
		</tfoot>
	</table>
</div>

@section('scripts')
	<script type="text/javascript">
        $(document).ready(function () {
            let $url = "{{route('eac.portal.drug.ajax.list')}}";
            if('{{$_GET['drug_status'] ?? '' }}') {
                $url += "?drug_status=" + "{{$_GET['drug_status'] ?? null}}";
            }
            // Data Tables
            $('#drugListTBL').initDT({
                ajax: {
                    url: $url,
                    type: "post"
                },
                order: [[0, 'asc']],
                columns: [
                    "drug_name",
                    "company_name",
                    "status",
                    "created_at",
                    "btns",
                ],
            });
        }); // end doc ready
	</script>
@append