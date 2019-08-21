@extends('layouts.portal')

@section('title')
    {{$title}} Requests
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
    
    <div class="actionBar">
        <a href="{{ route('eac.portal.rid.create') }}" class="btn btn-success">
            <i class="fa-fw fas fa-medkit"></i>
            Initiate Request
        </a>
    </div><!-- end .actionBar -->
    
    <div class="viewData">
        <div class="card mb-1 mb-md-4">
            <div class="card-header">
                {{--
                 * * * PLEASE UTILIZE THIS PLUGIN * * * https://datatables.net/plug-ins/filtering/row-based/range_dates * * *
                --}}
                <div class="row align-items-end">
                    <div class="col-sm col-xl-auto mb-2">
                        <label class="d-block">Request Date</label>
                        <div class="input-group mb-0">
                            <input type="text" name="" value="{{date('Y-m-d', strtotime('-14 days'))}}" class="form-control form-control-sm datepicker" style="min-width: 8rem"/>
                            <div class="input-group-append input-group-prepend">
                                <span class="input-group-text">to</span>
                            </div>
                            <input type="text" name="" value="{{date('Y-m-d', strtotime('+7 days'))}}" class="form-control form-control-sm datepicker" style="min-width: 8rem"/>
                        </div>
                    </div>
                    <div class="col-sm col-xl-auto mb-2">
                        <label class="d-block">Request Status</label>
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
                    <div class="col-sm-auto mb-2">
                        <button type="submit" name="" value="" class="btn btn-dark">
                            Apply Filter(s)
                        </button>
                    </div>
                </div>
            </div>
            <div class="mb-2 ml-sm-2 mr-sm-2 mt-sm-2 d-flex justify-content-between btn-group-toggle novisual flex-wrap" data-toggle="buttons">
                <label class="btn btn-outline-primary m-1 flex-fill " onclick="$(this).find(':radio').prop('checked', true);this.form.submit()">
                    <input type="radio" name="type" value="aFu1f1fYhq">
                    <span class="small upper h6 m-0 d-flex align-items-center justify-content-center flex-wrap">
                        <span class="h4 m-0 mr-1 poppins">Approved</span> Requests
                    </span>
                </label>
                <label class="btn btn-outline-primary m-1 flex-fill " onclick="$(this).find(':radio').prop('checked', true);this.form.submit()">
                    <input type="radio" name="type" value="XdP0OKYrui">
                    <span class="small upper h6 m-0 d-flex align-items-center justify-content-center flex-wrap">
                        <span class="h4 m-0 mr-1 poppins">Pending</span> Requests
                    </span>
                </label>
                <label class="btn btn-outline-primary m-1 flex-fill " onclick="$(this).find(':radio').prop('checked', true);this.form.submit()">
                    <input type="radio" name="type" value="bTHfo6PeGj">
                    <span class="small upper h6 m-0 d-flex align-items-center justify-content-center flex-wrap">
                        <span class="h4 m-0 mr-1 poppins">Not Approved</span> Requests
                    </span>
                </label>
                <label class="btn btn-outline-primary m-1 flex-fill " onclick="$(this).find(':radio').prop('checked', true);this.form.submit()">
                    <input type="radio" name="type" value="bTHfo6PeGj">
                    <span class="small upper h6 m-0 d-flex align-items-center justify-content-center flex-wrap">
                        Requests <span class="h4 m-0 mr-1 poppins">Awaiting Shipment</span>
                    </span>
                </label>
                <label class="btn btn-outline-primary m-1 flex-fill active" onclick="$(this).find(':radio').prop('checked', true);this.form.submit()">
                    <input type="radio" name="type" value="all">
                    <span class="small upper h6 m-0 d-flex align-items-center justify-content-center flex-wrap">
                        <span class="h4 m-0 mr-1 poppins">All</span> Requests
                    </span>
                </label>
            </div>
            <input type="hidden" id="getParams" value="{{json_encode($_GET)}}"/>
            <div class="table-responsive">
                <table class="table table-sm table-striped table-hover" id="ridListTBL">
                    <thead>
                    <tr>
                        <th>Request Date</th>
                        <th>RID Number</th>
                        <th class="no-search">Visits</th>
                        <th class="select">Request Status</th>
                        <th class="select">Physician</th>
                        <th class="select">Drug Requested</th>
                        <th class="no-search no-sort"></th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div><!-- end .viewData -->
@endsection

@section('scripts')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    
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
                order: [[0, 'asc']],
                responsive: true
            });
        }); // end doc ready
    </script>
@endsection
