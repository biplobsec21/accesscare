@extends('layouts.portal')

@section('title')
    Country Manager
@endsection

@section('content')
    <div class="titleBar">
        <div class="row justify-content-between">
            <div class="col-md col-lg-auto">
                <h4 class="m-0">Supporting Content:</h4>
                <h2 class="m-0">
                    @yield('title')
                </h2>
                @if(!is_null(Auth::user()->last_seen))
                    <h6>LAST LOGIN:
                        <small>{{ \Carbon\Carbon::parse(Auth::user()->last_seen)->format(config('eac.date_format')) }}</small>
                    </h6>
                @endif
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
<!--                <div class="text-right">
                    <button class="btn btn-secondary btn-sm" id="ShowRightSide" href="#">
                        Changelog
                    </button>
                </div>-->
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
        <a href="{{ route('eac.portal.settings.manage.country.logcountry') }}" class="btn btn-secondary btn-sm">
            <i class="fal fa-key"></i> Change Log
        </a>
    </div>
    <div class="col-md-6 text-right">

    </div>  
</div><!-- end .actionBar -->
<div class="actionBar m-t-20">
    <div class="">
        <h3>Logs Data</h3>
        
    </div>
    <
</div><!-- end .titleBar -->
 @include('include.alerts')
<div class="" >
    <div class="card">
        <table class="table table-sm SObasic dt-responsive">
            <thead>
                <tr>
                    <th style="text-align:center">
                       ID
                    </th>
                    <th>
                        NAME
                    </th>
                    <th>
                        LOGS OCCUR
                    </th>
                    <th style="text-align:center">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @if($logData)
                @foreach($logData as $val)
                <tr data-id="{{$val->id}}">
                    <td>{{ $val->id }}</td>
                    
                    <td>{{  \App\Country::where('id','=',$val->id)->firstOrFail()->name  }}</td>
                    <td width="20"><p style="background: green; width: 40%;height:20px;text-align: center;"><span>{{ $val->total_action }}</span></p></td>
                    <td align="center">
                        
                    <a href="{{ route('eac.portal.settings.manage.country.countrylogview',$val->id) }}" ><i class="fas fa-eye"></i></a>
                    </td>
                </tr>
                @endforeach
                @endif

            </tbody>
        </table>
    </div>
</div><!-- end .viewData -->
@endsection
@section('scripts')
<script>
    $(document).ready(function () {

        $("#-datatble-").on("click", function () {
            
        });

    });

        
    function ConfirmDelete(param){
       
    }
</script>
@endsection


