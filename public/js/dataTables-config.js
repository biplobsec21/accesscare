(function ($) {

    $.fn.initDT = function ($options) {
        let $header = this.find('thead');
        let $body = this.find('tbody');
        let $footer = this.find('tfoot');

        let $settings = Object.assign({
            paginationDefault: 10,
            paginationOptions: [10, 25, 50, 75, 100],
            processing: true,
            serverSide: true,
            orderCellsTop: true,
            fixedHeader: true,
        }, $options);
        if ($settings.ajax.fields) {
            $settings.columns = $settings.ajax.fields.map(function ($field, $index) {
                let $col = $header.find('th:eq(' + $index + ')');
                $field.orderable = !$col.hasClass('no-sort');
                $field.searchable = !$col.hasClass('no-search');
                if (!$field.type) {
                    $field.type = "string";
                }
                return $field;
            });
        } else if ($settings.columns) {
            $settings.columns = $settings.columns.map(function (str, index) {
                let $col = $header.find('th:eq(' + index + ')');
                let $val = {orderable: !$col.hasClass('no-sort'), searchable: !$col.hasClass('no-search')};
                if (str) {
                    $val.data = str;
                }
                return $val;
            });
        }


        // Create inputs in the table head
        let $firstHeaderRow = $header.find('tr:eq(0)');
        let $secondHeaderRow = $firstHeaderRow.clone(true).appendTo($header).addClass("filter-cols");
        $firstHeaderRow.addClass("sort-cols");
        $secondHeaderRow.find('th').each(function (i) {
            if ($(this).hasClass("no-search")) {
                $(this).html('');
                return;
            }
            if ($(this).hasClass("no-search")) {
                $(this).html('');
                return;
            }
            $(this).html('<input type="text" class="form-control" placeholder="Search ' + $(this).text() + '" />');
            $('input', this).on('change', function () {
                if ($(this).closest('table').DataTable().column(i).search() !== this.value)
                    $(this).closest('table').DataTable().column(i).search(this.value).draw();
            });
        });

        //Passing columns through ajax
        $settings.ajax.data = {columns: $settings.columns};

        let dataTable = $(this).DataTable($settings);

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
        $('.dataTables_filter').hide();
        return dataTable;
    };
}(jQuery));
