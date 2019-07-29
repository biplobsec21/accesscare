(function ( $ ) {

	$.fn.initDT = function ($options) {
		let $header = this.find('thead');
		let $body = this.find('tbody');
		let $footer = this.find('tfoot');

		let $settings = Object.assign({
			paginationDefault: 10,
			paginationOptions: [10, 25, 50, 75, 100],
			processing: false,
			serverSide: false,
			orderCellsTop: true,
			fixedHeader: true,
		}, $options );
		$settings.columns = $settings.columns.map(function(str, index) {
			let $col = $header.find('th:eq(' + index + ')');
			return {
				data: str,
				orderable: !$col.hasClass('no-sort'),
				searchable: !$col.hasClass('no-search'),
			};
		});

		// Create inputs in the table head
		let $firstHeaderRow = $header.find('tr:eq(0)');
		let $secondHeaderRow = $firstHeaderRow.clone(true).appendTo($header).addClass("filter-cols");
		$firstHeaderRow.addClass("sort-cols");
		$secondHeaderRow.find('th').each(function (i) {
			if ($(this).hasClass("no-search")) {
				$(this).html('');
				return;
			}
			$(this).html('<input type="text" class="form-control" placeholder="Search ' + $(this).text() + '" />');
			$('input', this).on('keyup change', function () {
				if ($(this).closest('table').DataTable().column(i).search() !== this.value)
					$(this).closest('table').DataTable().column(i).search(this.value).draw();
			});
		});

		let dataTable = $(this).dataTable($settings);

		$('.dataTables_wrapper').children('.row:first').hide();
		$('.dataTables_length select').clone(true).appendTo($secondHeaderRow.find('th:last'));
		$('select', $secondHeaderRow.find('th:last')).on('change', function () {
			$(this).closest('table').DataTable().page.len($(this).val()).draw();
		}).attr('style', 'width: 100%!important;').removeClass('custom-select').removeClass('custom-select-sm');


		$.fn.dataTable.ext.errMode = function (settings, helpPage, message) {
			swal({
				title: "Oh Snap!",
				text: "Something went wrong on our side. Please try again later.",
				icon: "warning",
			});
		};

		return dataTable;
	};
}( jQuery ));
