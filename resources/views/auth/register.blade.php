@extends('layouts.app')

@section('content')
    <form method="post" action="{{ route('eac.auth.postSignUp') }}">
        {{ csrf_field() }}
        <div class="card mb-5">
            <div id="header" class="text-center">
                <img src="https://www.earlyaccesscare.com/images/eac_mini.png" class="img-fluid">
            </div>
            <div class="card-header">
                <ul class="nav nav-pills justify-content-center" id="LoginP" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="one-tab" data-toggle="tab" href="#one" role="tab" aria-controls="one" aria-selected="true">
                            Register as Physician
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('eac.auth.getSignIn') }}">
                            Login
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="LoginPContent">
                    <div class="tab-pane fade show active" id="one" role="tabpanel" aria-labelledby="one-tab">
                        <div class="row">
                            <div class="col-sm-3 mb-2">
                                <label dusk="label-first-name" class="d-block">Title</label>
                                <select class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title">
                                    <option value="">-- Select --</option>
                                    @foreach(config('eac.user.availableTitle') as $k => $v)
                                        <option value={{$k}} @if(old('first_name') == $k || (old('first_name') == "" && $v == "Dr.")) selected @endif>{{$v}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    {{ $errors->first('title') }}
                                </div>
                            </div>
                            <div class="col-sm">
                                <label dusk="label-first-name" class="d-block">First Name</label>
                                <input type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ old('first_name') }}"/>
                                <div class="invalid-feedback">
                                    {{ $errors->first('first_name') }}
                                </div>
                            </div>
                            <div class="col-sm">
                                <label dusk="label-last-name" class="d-block">Last Name</label>
                                <input type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}"/>
                                <div class="invalid-feedback">
                                    {{ $errors->first('last_name') }}
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label dusk="label-hospital" class="d-block">Name of Practice or Institution</label>
                            <input type="text" class="form-control{{ $errors->has('hospital') ? ' is-invalid' : '' }}" name="hospital" value="{{ old('hospital') }}"/>
                            <div class="invalid-feedback">
                                {{ $errors->first('hospital') }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label dusk="label-address" class="d-block">Practice or Institution Address</label>
                            <input type="text" class="form-control mb-1{{ $errors->has('addr1') ? ' is-invalid' : '' }}" name="addr1" value="{{ old('addr1') }}"/>
                            <input type="text" class="form-control" name="addr2" value="{{ old('addr2') }}" placeholder="Apartment, Building, Suite, Floor, etc"/>
                            <div class="invalid-feedback">
                                {{ $errors->first('addr1') }}
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm col-md-8 col-lg-12 col-xl-7 mb-2">
                                <label class="d-block">Country</label>
                                <select class="form-control{{ $errors->has('country') ? ' is-invalid' : '' }}" name="country">
                                    <option disabled hidden selected value="">-- Select --</option>
                                    @foreach(\App\Country::where('active', 1)->get()->sortBy('index') as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    {{ $errors->first('phone_country') }}
                                </div>
                            </div>
                            <div class="col-sm col-md-4 col-lg-12 col-xl mb-2">
                                <label class="d-block">City</label>
                                <input type="text" class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}" name="city" value="{{ old('city') }}"/>
                                <div class="invalid-feedback">
                                    {{ $errors->first('city') }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm col-lg-7 mb-2">
                                <label class="d-block">State</label>
                                <select class="form-control{{ $errors->has('state') ? ' is-invalid' : '' }}" name="state">
                                    <option disabled hidden selected value="">-- Select --</option>
                                    @foreach(\App\State::all(['id', 'name'])->sortBy('name') as $state)
                                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    {{ $errors->first('state') }}
                                </div>
                            </div>
                            <div class="col-sm col-lg-5 mb-2">
                                <label class="d-block">Zipcode</label>
                                <input type="text" class="form-control{{ $errors->has('zipcode') ? ' is-invalid' : '' }}" name="zipcode" value="{{ old('zipcode') }}"/>
                                <div class="invalid-feedback">
                                    {{ $errors->first('zipcode') }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm col-lg-12 mb-2">
                                <label dusk="label-phone" class="d-block">Phone</label>
                                <input type="text" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') }}" placeholder="Phone"/>
                                <div class="invalid-feedback">
                                    {{ $errors->first('phone') }}
                                </div>
                            </div>
                            <div class="col-sm col-lg-12 mb-2">
                                <label dusk="label-email" class="d-block">Email Address</label>
                                <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Email"/>
                                <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm col-lg-2 mb-2">
                                <input type="checkbox" class="form-control{{ $errors->has('certified') ? ' is-invalid' : '' }}" name="certified" value="1">
                                <div class="invalid-feedback">
                                    {{ $errors->first('certified') }}
                                </div>
                            </div>
                            <div class="col-sm col-lg-10 mb-2">
                                <strong>I certify that I am a licensed Physician.</strong>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success btn-block">
                            Submit
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="">
                    Return to Homepage
                </a>
            </div>
        </div>
    </form>
@endsection
