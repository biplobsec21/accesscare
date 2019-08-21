(function ($) {

	$.fn.initDT = function ($options) {
		let $header = this.find('thead');
		let $body = this.find('tbody');
		let $footer = this.find('tfoot');
		let $id = this.attr('id');

		//Set our custom default settings and then apply th  provided settings
		let $settings = Object.assign({
			paginationDefault: 10,
			paginationOptions: [10, 25, 50, 75, 100],
			processing: true,
			serverSide: true,
			orderCellsTop: true,
			fixedHeader: true,
			deferLoading: true,
		}, $options);

		// Get filters based on $_GET parameters
		let $params = $('#getParams');
		if ($params.length)
			$params = JSON.parse($params.val());
		else
			$params = [];

		// Set the 'columns' DataTable setting with custom setup
		if ($settings.ajax.fields) {
			$settings.columns = $settings.ajax.fields.map(function ($field, $index) {
				let $colHeader = $header.find('th:eq(' + $index + ')');
				$field.name = $field.data;
				$field.orderable = !$colHeader.hasClass('no-sort');
				$field.searchable = !$colHeader.hasClass('no-search');
				$field.selectable = $colHeader.hasClass('select');

				// If no type given, assume string
				if (!$field.type)
					$field.type = "string";

				return $field;
			});
		}

		// Get the first header row
		let $firstHeaderRow = $header.find('tr:eq(0)');
		// Create second table header row for filtering columns
		let $secondHeaderRow = $firstHeaderRow.clone(true).appendTo($header).addClass("filter-cols");
		// Set first table header row to sort by that column
		$firstHeaderRow.addClass("sort-cols");


		// Populate second table header row with inputs
		$secondHeaderRow.find('th').each(function (i) {
			let $col = $settings.columns[i];
			let $val = $params[$col.data];
			if ($(this).hasClass("no-search")) {
				$(this).html('');
				return;
			} else if ($(this).hasClass("select")) {
				if (!!$val)
					$(this).html('<select class="form-control" data-col="' + i + '"><option selected value="' + $val + '">' + $val + '</option></select>');
				else
					$(this).html('<select class="form-control" data-col="' + i + '"><option selected value="">All</option></select>');
				$('select', this).on('change', function () {
					if ($(this).closest('table').DataTable().column(i).search() !== this.value)
						$(this).closest('table').DataTable().column(i).search(this.value).draw();
				});
			} else {
				if (!!$val)
					$(this).html('<input type="text" class="form-control" placeholder="Search ' + $(this).text() + '" value="' + $val + '" />');
				else
					$(this).html('<input type="text" class="form-control" placeholder="Search ' + $(this).text() + '" />');
				$('input', this).on('change', function () {
					if ($(this).closest('table').DataTable().column(i).search() !== this.value)
						$(this).closest('table').DataTable().column(i).search(this.value).draw();
				});
			}
		});

		// Add columns to data sent through ajax
		$settings.ajax.data = {columns: $settings.columns};

		// Initiate DataTable
		let dataTable = $(this).DataTable($settings);

		// Add $_GET filters
		if (!!$params.length)
			for (var key in $params)
				dataTable.column(key + ':name').search($params[key]);

		// Draw table
		dataTable.draw();

		// Populate select filters with options
		dataTable.on('xhr', function () {
			let $response = dataTable.ajax.json();
			$secondHeaderRow.find('select').each(function () {
				let $select = $response.options[$(this).data('col')];
				let $arr = $select['options'];
				let $val = $select['value'];
				$(this).empty();
				if ($val === null)
					$(this).append('<option selected value="">All</option>');
				else
					$(this).append('<option value="">All</option>');
				for (let i = 0; i < $arr.length; i++) {
					if ($val === $arr[i])
						$(this).append('<option selected value="' + $arr[i] + '">' + $arr[i] + '</option>');
					else
						$(this).append('<option value="' + $arr[i] + '">' + $arr[i] + '</option>');
				}
			});
		});

		// Hide the global search (since we have column filtering)
		$('.dataTables_filter').hide();

		// $('.dataTables_wrapper').children('.row:first').hide();
		// $('.dataTables_length select').clone(true).appendTo($secondHeaderRow.find('th:last'));
		// $('select', $secondHeaderRow.find('th:last')).on('change', function () {
		//     $(this).closest('table').DataTable().page.len($(this).val()).draw();
		// }).attr('style', 'width: 100%!important;').removeClass('custom-select').removeClass('custom-select-sm');

		$.fn.dataTable.ext.errMode = function (settings, helpPage, message) {
			swal({
				text: "There was an error understanding this request.",
				content: {
					element: "a",
					attributes: {
						href: "mailto:" + $siteEmail + "",
						text: "If this issue persists, click here to contact us.",
						class: "",
					},
				},
				icon: "warning",
			});
		};

		// Return DataTable
		return dataTable;
	};
}(jQuery));
