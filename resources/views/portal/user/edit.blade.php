@extends('layouts.portal')

@section('title')
    @if(Auth::User()->id == $user->id)
        Edit Profile Settings
    @else
        Edit User
    @endif
@endsection
@section('styles')
    <style>
        @media screen and (min-width: 1200px) {
            :root {
                --leftCol: 180px;
                --rightCol: 740px;
            }
            
            .actionBar, .viewData {
                max-width: calc(var(--leftCol) + var(--rightCol));
            }
            
            .viewData .row.thisone > [class*=col]:first-child {
                max-width: var(--leftCol);
                min-width: var(--leftCol);
            }
            
            .viewData .row.thisone > [class*=col]:last-child {
                max-width: var(--rightCol);
                min-width: var(--rightCol);
            }
        }
    </style>
@endsection

@section('content')
    <div class="titleBar">
        <nav aria-label="breadcrumb">
            <div class="row">
                <div class="col-sm-auto">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('eac.portal.getDashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('eac.portal.user.list') }}">All Users</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('eac.portal.user.show', $user->id) }}">{{$user->full_name}}</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            @yield('title')
                        </li>
                    </ol>
                </div>
            </div>
        </nav>
        <h6 class="title small upper m-0">
            @yield('title')
        </h6>
        <h2 class="m-0">
            {{$user->full_name}}
            @if($user->company_id)
                <small>({{ $user->company->name }})</small>
            @endif
        </h2>
        <div class="small">
            @if($user->updated_at)
                <strong>Last Updated:</strong>
                {{$user->updated_at->setTimezone(Session::get('time-zone'))->format('Y/m/d h:i A')}}
            @endif
        </div>
    </div><!-- end .titleBar -->
    <div class="viewData">
        @if(Auth::user()->type->name == 'Early Access Care')
            @if($user->status === 'Pending')
                <div class="alert alert-warning mb-3" role="alert">
                    <h5 class="text-danger">
                        <i class="fas fa-exclamation-triangle"></i>
                        User Pending
                    </h5>
                    <p class="text-dark mb-2">
                        <strong>{{ $user->full_name }}</strong>
                        is unable to submit content at this time, user must be Approved in order to proceed.
                    </p>
                    @if(!$user->certificate)
                        <div class="bg-gradient-warning text-dark p-2 pl-4 pr-4 ml-n4 mr-n4 mb-3">
                            <small class="d-block upper">Attention!</small>
                            <h5 class="mb-0 strong">{{ $user->full_name }} has not provided any credentials.</h5>
                        </div>
                    @endif
                    <a href="{{ route("eac.portal.user.deny", $user->id )}}" class="btn btn-danger mr-3" title="Deny User">
                        <i class="fas fa-ban"></i>
                        Deny User
                    </a>
                    <a href="{{ route("eac.portal.user.approve", $user->id )}}" class="btn btn-success" title="Approve User">
                        <i class="fas fa-check"></i>
                        Approve User
                    </a>
                </div><!-- end alert -->
            @elseif($user->status === 'Not Approved')
                <div class="alert alert-warning mb-3" role="alert">
                    <h5 class="text-danger">
                        <i class="fas fa-exclamation-triangle"></i>
                        Not Authorized
                    </h5>
                    <p class="text-dark ">
                        <strong>{{ $user->full_name }}</strong>
                        is unable to access content at this time, user must be re-authorized in order to proceed.
                    </p>
                    <a href="{{ route("eac.portal.user.approve", $user->id )}}" class="btn btn-success" title="Authorize User">
                        <i class="fas fa-check"></i>
                        Authorize
                    </a>
                    <a href="{{ route("eac.portal.user.pend", $user->id )}}" class="btn btn-warning" title="Authorize User">
                        <i class="fas fa-check"></i>
                        Pend
                    </a>
                </div><!-- end alert -->
            @endif
        @endif
        <div class="bg-dark text-white pt-2 pb-2 pr-3 pl-3 d-flex justify-content-between">
            <a href="{{ route('eac.portal.user.show', $user->id) }}" class="btn btn-secondary">
                @if(Auth::User()->id == $user->id)
                    View My Profile
                @else
                    View User
                @endif
            </a>
            <a href="{{ route('eac.portal.user.show', $user->id) }}" class="btn btn-info">
                <i class="fal fa-redo"></i>
                Resend Welcome Email
            </a>
            <div>
                @if(\Auth::user()->id === $user->id)
                    <a href="{{route('eac.auth.password.change', \Auth::user()->id)}}" class="btn btn-dark btn-block">
                        Modify Password
                        <i class="fa-fw fas fa-user-md"></i>
                    </a>
                @endif
            </div>
        </div>
        <div class="row thisone m-0 mb-xl-5">
            <div class="col-sm-3 col-xl-auto p-0 mb-2 mb-sm-0">
                <div class="wizardSteps symbols nav flex-row flex-sm-column mt-sm-3" id="tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link complete active" id="xdetails-tab" data-toggle="pill" href="#xdetails" role="tab" aria-controls="xdetails" aria-selected="true">
                        <span>Details</span>
                    </a>
                    @access('rid.info.view')
                    <a class="nav-link @if($rids->count()) complete @endif" id="xassignedRIDs-tab" data-toggle="pill" href="#xassignedRIDs" role="tab" aria-controls="xassignedRIDs" aria-selected="false">
                        <span>Assigned RIDs</span>
                    </a>
                    @endif
                    @access('drug.info.view')
                    <a class="nav-link @if($drugs->count()) complete @endif" id="xassignedDrugs-tab" data-toggle="pill" href="#xassignedDrugs" role="tab" aria-controls="xassignedDrugs" aria-selected="false">
                        <span>Assigned Drugs</span>
                    </a>
                    @endif
                    <a class="nav-link @if($user->groups()) complete @endif" id="xgroups-tab" data-toggle="pill" href="#xgroups" role="tab" aria-controls="xgroups" aria-selected="false">
                        <span>User Groups</span>
                    </a>
                    @access('user.note.view')
                    <a class="nav-link @if($user->notes->count() > 0) complete @endif" id="xnotes-tab" data-toggle="pill" href="#xnotes" role="tab" aria-controls="xnotes" aria-selected="false">
                        <span>User Notes</span>
                    </a>
                    @endif
                </div>
            </div>
            <div class="col-sm-9 col-xl p-0">
                <div class="tab-content wizardContent" id="tabContent">
                    <div class="alert-light text-dark pt-3 pl-3 pr-3">
                        <div class="row">
                            <div class="col mb-3">
                                <strong>{{ $user->full_name }}</strong>
                                <span class="badge badge-{{ config('eac.user.availableStatus.' . $user->status) }}">
                                    {{ $user->status }}
                                </span>
                                <ul class="nav flex-row m-0">
                                    @if($user->phone && $user->phone->number)
                                        <li class="nav-item">
                                            <a href="tel:{{ $user->phone->number }}" class="small" data-toggle="tooltip" data-placement="bottom" title="Call {{ $user->phone->number }}">
                                                <i class="text-secondary fa-fw fas fa-phone fa-sm fa-rotate-90"></i>
                                            </a>
                                        </li>
                                    @endif
                                    @if(($user->phone && $user->phone->number) && ($user->email))
                                        <li class="nav-item pl-2 pr-2 d-none d-sm-block text-secondary">|</li>
                                    @endif
                                    @if($user->email)
                                        <li class="nav-item">
                                            <a target="_blank" href="mailto:{{ $user->email }}" class="small" data-toggle="tooltip" data-placement="bottom" title="Email {{ $user->email }}">
                                                <i class="text-secondary fa-fw fas fa-envelope fa-sm"></i>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                            <div class="order-3 order-md-2 col-md mb-3">
                                <small class="upper d-block">User Type</small>
                                <strong>{{ $user->type->name }}</strong>
                                @if($user->company)
                                    <span class="d-inline-block">
                                        (
                                        <a href="{{ route('eac.portal.company.show', $user->company->id) }}">{{ $user->company->name }}</a>
                                        )
                                    </span>
                                @endif
                            </div>
                            <div class="order-2 order-md-3 col-auto mb-3">
                                <small class="upper d-block">Created On</small>
                                <strong>{{ $user->created_at->format(config('eac.date_format')) }}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade show active" id="xdetails" role="tabpanel" aria-labelledby="xdetails-tab">
                        <form method="post" action="{{ route('eac.portal.user.edit', $user->id) }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="type" value="{{ $user->type }}"/>
                            <input type="hidden" name="address_id" value="{{ $user->address_id }}"/>
                            <input type="hidden" name="phone_id" value="{{ $user->phone_id }}"/>
                            <div class="card card-body mb-0">
                                <div class="row">
                                    <div class="col-xl">
                                        <div class="row">
                                            <div class="col-auto mb-3">
                                                <label class="d-block">Title</label>
                                                <select class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title">
                                                    <option disabled="" hidden="" selected="" value="">-- Select --
                                                    </option>
                                                    @foreach(config('eac.user.availableTitle') as $key => $value)
                                                        <option value="{{ $key }}" {{ $user->title == $key ? 'selected="selected"' : '' }} >
                                                            {{ $value }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('title') }}
                                                </div>
                                            </div>
                                            <div class="col col-md mb-3">
                                                <label class="d-block label_required">First Name</label>
                                                <input type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ $user->first_name }}"/>
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('first_name') }}
                                                </div>
                                            </div>
                                            <div class="col col-md mb-3">
                                                <label class="d-block label_required">Last Name</label>
                                                <input type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ $user->last_name }}"/>
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('last_name') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5 mb-3">
                                        <label class="d-block label_required">Type of User</label>
                                        <select class="form-control{{ $errors->has('type') ? ' is-invalid' : '' }}" name="type">
                                            @foreach($user_types as $type)
                                                <option value="{{$type->id}}" @if($user->type_id == $type->id) selected @endif>
                                                    {{$type->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            {{ $errors->first('type') }}
                                        </div>
                                    </div>
                                    <div class="col-sm mb-3">
                                        <label class="d-block">Status</label>
                                        <select class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }}" name="status">
                                            <option value="{{ $user->status }}">{{ $user->status }}</option>
                                            @foreach(config('eac.user.availableStatus') as $v)
                                                @if($v != $user->status)
                                                    <option value="{{ $v }}">{{ $v }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            {{ $errors->first('status') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm mb-3">
                                        <label class="d-block label_required">Phone</label>
                                        <input type="text" class=" form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ isset($user->phone->number) ? $user->phone->number : '' }}"/>
                                        <div class="invalid-feedback">
                                            {{ $errors->first('phone') }}
                                        </div>
                                    </div>
                                    <div class="col-sm mb-3">
                                        <label class="d-block label_required">Email</label>
                                        <input type="text" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="@if(isset($user->email)) {{ $user->email }} @endif"/>
                                        <div class="invalid-feedback">
                                            {{ $errors->first('email') }}
                                        </div>
                                    </div>
                                </div>
                                <label class="d-block">Address</label>
                                <div class="row m-md-0">
                                    <div class="col-md mb-1 mb-md-3 p-md-0">
                                        <input type="text" class="form-control{{ $errors->has('addr1') ? ' is-invalid' : '' }}" name="addr1" value="@if(isset($user->address->addr1)) {{ $user->address->addr1 }} @endif" placeholder="Street Address"/>
                                    </div>
                                    <div class="col-md-5 mb-3 p-md-0 pl-md-1">
                                        <input type="text" class="form-control" name="addr2" value="@if(isset($user->address->addr2)) {{ $user->address->addr2  }} @endif" placeholder="Address Continued (Building #, Suite, Floor, etc)"/>
                                    </div>
                                </div>
                                <div class="invalid-feedback">
                                    {{ $errors->first('addr1') }}
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-7 col-lg-6 mb-3">
                                        <label class="d-block label_required">Country</label>
                                        <select class="form-control select2{{ $errors->has('country') ? ' is-invalid' : '' }}" name="country" id="country_id">
                                            <option disabled="" hidden="" selected="" value="">-- Select --
                                            </option>
                                            @if($countries)
                                                @foreach($countries as $cval)
                                                    <option value="{{ $cval->id }}" {{ isset($user->address->country_id) && $user->address->country_id == $cval->id ? 'selected="selected"' : ''}} >
                                                        {{ trim($cval->name) }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <div class="invalid-feedback">
                                            {{ $errors->first('country') }}
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-lg-6 mb-3">
                                        <label class="d-block">City</label>
                                        <input type="text" class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}" name="city" value="@if(isset($user->address->city)) {{ $user->address->city }} @endif"/>
                                        <div class="invalid-feedback">
                                            {{ $errors->first('city') }}
                                        </div>
                                    </div>
                                    <div class="col-sm-7 col-lg-6 mb-3">
                                        <label class="d-block" id="lbl">State</label>
                                        <div id="div1">
                                            <select class="select2 form-control{{ $errors->has('state') ? ' is-invalid' : '' }}" name="state" id="state">
                                                <option disabled hidden selected value="">-- Select --
                                                </option>
                                                @foreach(\App\State::all(['id', 'name','abbr'])->sortBy('name') as $state)
                                                    <option value="{{$state->id}}" @if($user->address){{ $user->address->state_province == $state->id? 'selected' : ''  }} @endif>{{$state->name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div id="div2">
                                            <input type="text" placeholder="Province" value="@if($user->address){{ $user->address->state_province}}@endif" name="state" id="state_text" class="form-control">
                                        </div>
                                        <div class="invalid-feedback">
                                            {{ $errors->first('state') }}
                                        </div>
                                    
                                    </div>
                                    <div class="col-sm-5 col-lg-6 mb-3">
                                        <label class="d-block">Postal Code</label>
                                        <input type="text" class="form-control @if($errors->has('zipcode')) 'is-invalid' @endif" name="zipcode" value="@if(isset($user->address->zipcode)) {{ $user->address->zipcode }} @endif"/>
                                        <div class="invalid-feedback">
                                            {{ $errors->first('zipcode') }}
                                        </div>
                                    </div>
                                </div>
                            
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-success" name="submit" value="Submit">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                    @access('rid.info.view')
                    <div class="tab-pane fade " id="xassignedRIDs" role="tabpanel" aria-labelledby="xassignedRIDs-tab">
                        <div class="card card-body">
                            <h4 class="mb-3">
                                <strong>Assigned RIDs</strong>
                                @if($rids)
                                    <span class="badge badge-success">{{$rids->count()}}</span>
                                @endif
                            </h4>
                            @if($rids->count())
                                <div class="table-responsive">
                                    <table class="table table-sm SObasic w-100" id="ridsAssigned">
                                        <thead>
                                        <tr>
                                            <th>RID Number</th>
                                            <th>Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($rids as $rid)
                                            <tr>
                                                <td>
                                                    <a href="{{$rid->view_route}}">{{$rid->number}}</a>
                                                </td>
                                                <td class="text-right">
                                                    {{date('Y-m-d', strtotime($rid->created_at))}}
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted m-0">
                                    <i class="fal fa-info-circle"></i>
                                    No Accessible Rids
                                </p>
                            @endif
                        </div>
                    </div>
                    @endif
                    @access('drug.info.view')
                    <div class="tab-pane fade " id="xassignedDrugs" role="tabpanel" aria-labelledby="xassignedDrugs-tab">
                        <div class="card card-body">
                            <h4 class="mb-3">
                                <strong>Assigned Drugs</strong>
                                @if($drugs)
                                    <span class="badge badge-success">{{$drugs->count()}}</span>
                                @endif
                            </h4>
                            @if($drugs->count())
                                <div class="table-responsive">
                                    <table class="table table-sm SObasic w-100" id="drugsAssigned">
                                        <thead>
                                        <tr>
                                            <th>Drug</th>
                                            <th>Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($drugs as $drug)
                                            <tr>
                                                <td>
                                                    <a href="{{$drug->view_route}}">{{$drug->name}}</a>
                                                </td>
                                                <td class="text-right">
                                                    {{date('Y-m-d', strtotime($drug->created_at))}}
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted m-0">
                                    <i class="fal fa-info-circle"></i>
                                    No Accessible Drugs
                                </p>
                            @endif
                        </div>
                    </div>
                    @endif
                    <div class="tab-pane fade " id="xgroups" role="tabpanel" aria-labelledby="xgroups-tab">
                        <div class="card card-body">
                            <h4 class="mb-3">
                                <strong>User Groups</strong>
                                @if($user->groups())
                                    <span class="badge badge-dark">{{$user->groups()->count()}}</span>
                                @endif
                            </h4>
                            @if($user->groups())
                                <div class="row">
                                    @foreach($user->groups()->sortBy('name') as $userGroup)
                                        <div class="col-sm-6 mb-3">
                                            <div class="card border-light bs-no border">
                                                <div class="card-header p-2 text-sm-center">
                                                    <div>
                                                        <strong>{{$userGroup->name}}</strong>
                                                        <small>({{$userGroup->type->name}} Group)</small>
                                                    </div>
                                                    @if($userGroup->parent())
                                                        <div class="small ml-3 ml-sm-0">
                                                            <a href="{{ route('eac.portal.user.show', $user->id) }}" class="btn btn-link btn-sm">
                                                                {{$userGroup->parent->full_name}}
                                                            </a>
                                                            <small class="badge badge-success">Group Lead</small>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="card-body p-2">
                                                    <ul class="list-group list-group-flush mb-0">
                                                        <!-- Group leader -->
                                                        <!-- member -->
                                                        @foreach($userGroup->users()->sortBy('first_name') as $user)
                                                            @if($user)
                                                                <li class="list-group-item">
                                                                    <a href="{{ route('eac.portal.user.show', $user->id) }}" class="btn btn-link btn-sm">
                                                                        {{$user->full_name}}
                                                                    </a>
                                                                    <small class="d-block">
                                                                        {{$userGroup->roleInTeam($user->id)->name}}
                                                                        @if($user->id == $userGroup->parent_user_id)
                                                                            <span class="badge badge-success">Group Lead</span>
                                                                        @endif
                                                                    </small>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted m-0">
                                    <i class="fal fa-info-circle"></i>
                                    No information available
                                </p>
                            @endif
                        </div>
                    </div>
                    @access('user.note.view')
                    <div class="tab-pane fade " id="xnotes" role="tabpanel" aria-labelledby="xnotes-tab">
                        <div class="card card-body mb-0">
                            <h5 class="">
                                User Notes
                                <span class="badge badge-dark"></span>
                            </h5>
                            @if($user->notes->count() > 0)
                                <ul class="list-group list-group-flush m-0">
                                    @foreach($user->notes->sortByDesc('created_at') as $note)
                                        <li class="list-group-item">
                                            <a href="{{ route('eac.portal.note.delete', $note->id) }}" class="btn text-danger float-right" title="Delete Note">
                                                <i class="far fa-times"></i>
                                                <span class="sr-only">Delete</span>
                                            </a>
                                            <label class="d-block">
                                                {{ \Auth::user()->first_name }} {{ \Auth::user()->last_name }}
                                                <small>{{ $note->created_at->format('Y-m-d  h:m A') }}</small>
                                            </label>
                                            <p class="m-0 small">{{ $note->text }}</p>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted m-0">
                                    <i class="fal fa-info-circle"></i>
                                    No information available
                                </p>
                            @endif
                        </div>
                        <div class="card-footer">
                            <a href="#" class="btn btn-success" data-toggle="modal" data-target="#NoteAdd">
                                Add Note
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div><!-- /.viewData -->
    
    <div class="modal fade" id="NoteAdd" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header p-2">
                    <h5 class="m-0">
                        Add Note to
                        <strong>{{ $user->full_name }}</strong>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times"></i>
                    </button>
                </div>
                <form method="post" action="{{ route('eac.portal.note.create') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="subject_id" value="{{$user->id}}">
                    <div class="modal-body p-3">
                        <div class="mb-3">
                            <label class="d-block">
                                {{ \Auth::user()->first_name }} {{ \Auth::user()->last_name }}
                                <small>{{date('Y-m-d H:i')}}</small>
                                :
                            </label>
                            <textarea name="text" class="note_text form-control" rows="5" placeholder="Enter note..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer p-2 d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" tabindex="0">Cancel
                        </button>
                        <button type="submit" name="submit" class="btn btn-success" value="Add Note">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <pre id="output"></pre>
@endsection





@section('scripts')
    <script>
        var str = $("#country_id option:selected").text();
        if (str.toLowerCase().indexOf("united states") >= 0) {

            $("#state").prop('required', true);
            $("#div2").hide();
            $('#state_text').attr("disabled", true);
            $('#state').attr("disabled", false);
            $("#div1").show();
        } else {

            $("#state").prop('required', false);
            $("#div1").hide();
            $('#state').attr("disabled", true);
            $('#state_text').attr("disabled", false);
            $("#div2").show();
        }

        $("#country_id").on('change', function () {
            console.log($("#country_id option:selected").text());
            var str = $("#country_id option:selected").text();
            if (str.toLowerCase().indexOf("united states") >= 0) {

                $("#state").prop('required', true);
                $("#div2").hide();
                $('#state').attr("disabled", false);
                $('#state_text').attr("disabled", true);
                $("#div1").show();
            } else {

                $("#state").prop('required', false);
                $("#div1").hide();
                $('#state_text').attr("disabled", false);
                $('#state').attr("disabled", true);
                $("#div2").show();
            }
        });
    </script>
@endsection
