@extends('layouts.portal')

@section('title')
    Website Content Manager
@endsection
@section('styles')
    
    <style>
        .ex-panel {
            min-height: 8rem;
            background-color: #5a5a5a;
            border-radius: .25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-bottom: 1rem;
        }
        
        .ex-row {
            max-width: 32rem;
            margin-right: auto;
            margin-left: auto;
        }
        
        .ex-container {
            padding: 1rem;
            margin-right: 0;
            margin-left: 0;
            outline: #5a5a5a 2px solid;
        }
    </style>
@endsection
@section('content')
    <div class="titleBar">
        <nav aria-label="breadcrumb">
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
        </nav>
        <h2 class="m-0">
            @yield('title')
        </h2>
    </div><!-- end .titleBar -->
    @include('include.alerts')
    <div class="actionBar"></div><!-- end .actionBar -->
    
    <div class="viewData">
        <div class="row">
            <div class="col-10">
                <div class="card mb-3">
                    <div class="card-header">
                        Layouts
                    </div>
                    <div class="card-body">
                        <div class="ex-container">
                            <div class="row ex-row">
                                <div class="col-4">
                                    <div class="ex-panel">
                                        <span class="text-white">4</span>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="ex-panel">
                                        <span class="text-white">8</span>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="ex-panel">
                                        <span class="text-white">8</span>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="ex-panel">
                                        <span class="text-white">4</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card mb-3">
                    <div class="card-header">
                        Pages
                    </div>
                </div>
            </div>
        </div>
    </div><!-- end .viewData -->
@endsection

@section('scripts')
@endsection
