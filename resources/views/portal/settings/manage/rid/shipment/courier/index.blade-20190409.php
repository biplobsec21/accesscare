@extends('layouts.portal')

@section('title')
Rid Shipping Courier Manager
@endsection

@section('content')
<div class="titleBar">
    <div class="row justify-content-between">
        <div class="col-md col-lg-auto">
            <h4 class="m-0">Supporting Content:</h4>
            <h2 class="m-0">
                @yield('title')
            </h2>
        </div>
        <div class="col-md col-lg-auto ml-lg-auto">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('eac.portal.getDashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('eac.portal.settings') }}">Supporting Content</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    @yield('title')
                </li>
            </ol>
            <div class="text-right">
                <button class="btn btn-secondary btn-sm" id="ShowRightSide" href="#">
                    Changelog
                </button>
            </div>
        </div>
    </div>
</div><!-- end .titleBar -->


<div class="actionBar">

    <div class="col-md-6 text-left">
        <a href="{{ route($page['listAll']) }}" class=" btn btn-primary" >
            <i class="fas fa-list-ul fa-fw"></i> List all
        </a>
        <a href="{{ route($page['createButton']) }}" class="btn btn-success">
            <i class="fa-fw far fa-file-medical"></i> Add New
        </a>
        <a href="{{ route($page['listAll']) }}" class="btn btn-secondary btn-sm">
            <i class="fal fa-key"></i> Change Log
        </a>
    </div>
    <div class="col-md-6 text-right">

    </div>
</div><!-- end .actionBar -->

<div class="row m-t-10">
    <div class="col-md-12">
        <?php
        if (Session::has('alerts')) {
            $alert = Session::get('alerts');
            $alert_dismiss = view('layouts.alert-dismiss', ['type' => $alert['type'], 'message' => $alert['msg']]);
            echo $alert_dismiss;
        }
        ?>
    </div>
</div>

<div class="viewData">
    <div class="card">
        <div class="table-responsive">
            <table class="table table-striped usertable" id="routeTBL">
                <thead>
                    <tr>
                        <th>name</th>
                        <th>active</th>
                        <th>created_at</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <tr>
                        <th>name</th>
                        <th class="no-search">active</th>
                        <th>created_at</th>
                        <th class="no-search"></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div><!-- end .viewData -->

<div class="rightSide">
    right side
</div><!-- end .rightSide -->
@endsection
@section('scripts')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>

$(document).ready(function () {
    $('#routeTBL tfoot th').each(function () {
        if ($(this).hasClass("no-search"))
            return;
        var title = $(this).text();
        $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" />');
    });

    var dataTable = $('#routeTBL').DataTable({
        "paginationDefault": 10,
        // "responsive": true,
        'order': [[0, 'desc']],
        "ajax": {
            url: "{{ route('eac.portal.settings.manage.rid.shipment.courier.ajaxlist') }}",
            type: "post"
        },
        "processing": true,
        "serverSide": true,
        "columns": [
            {
                "data": "name",
                'name': 'name',
                searchable: true
            },
            {
                "data": "active",
                "searchable": false,
            },

            {
                "data": "created_at",
                "name": "created_at",
                orderable: false,
                searchable: false
            },
            {
                "data": "ops_btns",
                orderable: false,
                searchable: false
            }
        ]
    });

    dataTable.columns().every(function () {
        var that = this;

        $('input', this.footer()).on('keyup change', function () {
            if (that.search() !== this.value) {
                that
                        .search(this.value)
                        .draw();
            }
        });
    });

    $.fn.dataTable.ext.errMode = function (settings, helpPage, message) {
        swal({
            title: "Oh Snap!",
            text: "Something went wrong on our side. Please try again later.",
            icon: "warning",
        });
    };

}); // end doc ready
$(".alert").delay(2000).slideUp(200, function () {
    $(this).alert('close');
});

function Confirm_Delete(param)
{

    swal({
        title: "Are you sure?",
        text: "Want to delete it",
        icon: "warning",
        buttons: [
            'No, cancel it!',
            'Yes, I am sure!'
        ],
        dangerMode: true,
    }).then(function (isConfirm) {
        if (isConfirm) {
            swal({
                title: 'Successfull!',
                text: 'Content deleted!',
                icon: 'success'
            }).then(function () {
                $.get("{{route('eac.portal.settings.manage.rid.shipment.courierdelete')}}",
                        {
                            id: param
                        });
                // return false;
                swal.close();

                $(location).attr('href', '{{route('eac.portal.settings.manage.rid.shipment.courier.index')}}') // <--- submit form programmatically
            });
        } else {
            swal("Cancelled", "Operation cancelled", "error");
        }
    })
}
</script>
@endsection
