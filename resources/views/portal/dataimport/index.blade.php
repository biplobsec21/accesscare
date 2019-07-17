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
                Data Migration
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
                    Data migration
                </li>
            </ol>
            <div class="text-right">
              <!--   <button class="btn btn-secondary btn-sm" id="ShowRightSide" href="{{ route('eac.portal.settings.manage.states.loglist') }}">
                    Changelog
                </button> -->
            </div>
        </div>
    </div>
</div><!-- end .titleBar -->


<div class="actionBar">

    <div class="col-md-6 text-left">
        
        <a href="" class="btn btn-primary btn-lg">
            <i class="fas fa-file-import"></i> Import Data
        </a>
    </div>

</div><!-- end .actionBar -->


<div class="rightSide">
    right side
</div><!-- end .rightSide -->
@endsection
@section('scripts')
@endsection
