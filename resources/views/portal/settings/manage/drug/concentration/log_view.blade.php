@extends('layouts.portal')

@section('title')
Dosage Units/Concentration Manager
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
            <!--<div class="text-right">
                                                    <button class="btn btn-secondary btn-sm" id="ShowRightSide" href="#">
                                                            Changelog
                                                    </button>
                                            </div>-->
        </div>
    </div>
</div><!-- end .titleBar -->
<div class="actionBar">

    <div class="col-md-6 text-left">
        <a href="{{ route($page['listAll']) }}" class=" btn btn-success" >
            <i class="fas fa-list-ul fa-fw"></i> List all
        </a>
        <a href="{{ route($page['createButton']) }}" class="btn btn-success">
            <i class="fa-fw far fa-file-medical"></i> Add New
        </a>
        <a href="{{ route($page['logsr']) }}" class="btn btn-primary">
            <i class="fal fa-key"></i> Change Log
        </a>
    </div>
    <div class="col-md-6 text-right">

    </div>  
</div><!-- end .actionBar -->
<div class="actionBar m-t-20">
    <div class="">
        <h3>Logs Data</h3>
        <h5>
            <a href="{{ route($page['logsr']) }}"class="btn btn-warning">
                <i class="far fa-angle-double-left  fa-fw"> </i> Go Back
            </a>  
            Log list For <span class="text-danger">[{{  \App\DosageUnit::where('id','=',request()->id)->firstOrFail()->name  }}]</span>
        </h5>
    </div>
</div><!-- end .titleBar -->
 @php
  if(Session::has('alerts')) {
   $alert = Session::get('alerts');
   $alert_dismiss = view('layouts.alert-dismiss', ['type' => $alert['type'], 'message' => $alert['msg']]);
   echo $alert_dismiss;
  }
 @endphp
<div class="" >
    <div class="card">
        <table class="table table-sm SObasic dt-responsive">
            <thead>
                <tr>
                    <th>
                       ACTION BY
                    </th>
                    <th>
                        DATA
                    </th>
                    <th>
                        DATE
                    </th>
                 
                </tr>
            </thead>
            <tbody>
                @if($logData)
                @foreach($logData as $val)
                <?php $user =   \App\User::where('id','=',$val->user_id)->count(); ?>
                <tr data-id="{{$val->user_id}}">
                    <?php if($user>0){ ?><td>{{  \App\User ::where('id','=',$val->user_id)->firstOrFail()->first_name  }} {{  \App\User ::where('id','=',$val->user_id)->firstOrFail()->last_name  }}</td>
                    <?php  }else{
                         echo '<td>N/A</td>';   
                        } ?>
                    
                    <td><?php $cng = json_decode($val->desc, true); ?>
                        @foreach($cng as $key=>$cdata)  
                         <span style="font-weight: bold;">{{$key}}: </span>  {{$cdata}}<br>
                        @endforeach
                    </td>
                    <td><span class=""> {{ $val->created_at->toDateString() }} </span></td>
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


