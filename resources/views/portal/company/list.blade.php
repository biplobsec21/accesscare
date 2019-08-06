@extends('layouts.portal')

@section('title')
    All Companies
@endsection

@section('content')
    <div class="titleBar">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('eac.portal.getDashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    @yield('title')
                </li>
            </ol>
        </nav>
        <h2 class="m-0">
            @yield('title')
        </h2>
    </div><!-- end .titleBar -->
    
    @php
        if(Session::has('alerts')) {
         $alert = Session::get('alerts');
         $alert_dismiss = view('layouts.alert-dismiss', ['type' => $alert['type'], 'message' => $alert['msg']]);
         echo $alert_dismiss;
        }
    @endphp
    
    <div class="actionBar">
        <a href="{{ route('eac.portal.company.create') }}" class="btn btn-success">
            <i class="fa-fw fas fa-building"></i> Add Company
        </a>
    </div><!-- end .actionBar -->
    
    <div class="viewData">
        <div class="card mb-1 mb-md-4">
            <div class="table-responsive">
                <table class="table table-sm table-striped table-hover companytable" id="companyListTBL">
                    <thead>
                    <tr>
                        <th>Company Name</th>
                        <th class="no-search no-sort">Status</th>
                        <th class="no-search">Drugs</th>
                        <th class="no-search">Requests</th>
                        <th class="no-search">Users</th>
                        <th>Added</th>
                        <th class="no-search no-sort"></th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                    <tr>
                        <th>Company Name</th>
                        <th class="no-search no-sort">Status</th>
                        <th class="no-search">Requests</th>
                        <th class="no-search">Drugs</th>
                        <th class="no-search">Users</th>
                        <th>Added</th>
                        <th class="no-search no-sort"></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div><!-- end .viewData -->
@endsection
@section('scripts')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    
    <script type="text/javascript">
        $(document).ready(function () {
            let $url = "{{route('eac.portal.settings.dataTables', 'Company')}}";
            // Data Tables
            $('#companyListTBL').initDT({
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
                            data: "status",
                        },
                        {
                            data: "rids",
                            type: "count",
                        },
                        {
                            data: "drugs",
                            type: "count",
                        },
                        {
                            data: "users",
                            type: "count",
                        },
                        {
                            data: "created_at"
                        },
                        {
                            data: "view_route",
                            type: "btn",
                            classes: "btn btn-info",
                            icon: '<i class="fal fa-fw fa-eye"></i>',
                            text: "View"
                        },
                    ],
                },
                order: [[0, 'asc']],
            });
        }); // end doc ready
    </script>
@endsection
