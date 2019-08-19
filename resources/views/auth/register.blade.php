@extends('layouts.frame')

@section('title')
 Register as Physician
@endsection

@section('content')
 <div class="card">
  <div class="card-header">
  </div>
  <div class="card-body p-0">
   <div class="row m-0">
    <div class="text-center col-lg-auto bg-dark text-white p-3 p-lg-4 p-xl-5 d-sm-flex d-lg-block justify-content-sm-between flex-sm-wrap align-items-sm-center">
     <img src="{{ asset('/images/logo-w-bg.png') }}" alt="Early Access Care" class="img-fluid mb-3 mb-sm-0 mb-lg-3" style="max-height: 100px" />
     <ul class="nav nav-pills justify-content-center" id="LoginP" role="tablist">
      <li class="nav-item">
       <a class="nav-link active" href="{{ route('eac.auth.getSignIn') }}">
        Login
       </a>
      </li>
     </ul>
    </div>
    <div class="col-lg p-3 p-lg-4 p-xl-5 ml-lg-auto mr-lg-auto">
     <form method="post" action="{{ route('eac.auth.postSignUp') }}">
      {{ csrf_field() }}
      <h4 class="text-center">Please enter your information.</h4>
      <div class="row">
       <div class="col-auto mb-3">
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
       <div class="col mb-3">
        <label dusk="label-first-name" class="d-block">First Name</label>
        <input type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ old('first_name') }}"/>
        <div class="invalid-feedback">
         {{ $errors->first('first_name') }}
        </div>
       </div>
       <div class="col-sm mb-3">
        <label dusk="label-last-name" class="d-block">Last Name</label>
        <input type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}"/>
        <div class="invalid-feedback">
         {{ $errors->first('last_name') }}
        </div>
       </div>
      </div>
      <div class="row">
       <div class="col-sm mb-3">
        <label dusk="label-phone" class="d-block">Phone</label>
        <input type="text" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') }}" />
        <div class="invalid-feedback">
         {{ $errors->first('phone') }}
        </div>
       </div>
       <div class="col-sm mb-3">
        <label dusk="label-email" class="d-block">Email Address</label>
        <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" />
        <div class="invalid-feedback">
         {{ $errors->first('email') }}
        </div>
       </div>
      </div>
      <hr />
      <div class="mb-3">
       <label dusk="label-hospital" class="d-block">Name of Practice/Institution</label>
       <input type="text" class="form-control{{ $errors->has('hospital') ? ' is-invalid' : '' }}" name="hospital" value="{{ old('hospital') }}"/>
       <div class="invalid-feedback">
        {{ $errors->first('hospital') }}
       </div>
      </div>
      <div class="mb-3">
       <label dusk="label-address" class="d-block">Practice/Institution Address</label>
       <input type="text" class="form-control mb-1{{ $errors->has('addr1') ? ' is-invalid' : '' }}" name="addr1" value="{{ old('addr1') }}"/>
       <input type="text" class="form-control" name="addr2" value="{{ old('addr2') }}" placeholder="Address Line 2"/>
       <div class="invalid-feedback">
        {{ $errors->first('addr1') }}
       </div>
      </div>
      <div class="mb-3">
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
      <div class="row">
       <div class="col-sm mb-3">
        <label class="d-block">City</label>
        <input type="text" class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}" name="city" value="{{ old('city') }}"/>
        <div class="invalid-feedback">
         {{ $errors->first('city') }}
        </div>
       </div>
       <div class="col-sm mb-3">
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
       <div class="col-sm mb-3">
        <label class="d-block">Postal Code</label>
        <input type="text" class="form-control{{ $errors->has('zipcode') ? ' is-invalid' : '' }}" name="zipcode" value="{{ old('zipcode') }}"/>
        <div class="invalid-feedback">
         {{ $errors->first('zipcode') }}
        </div>
       </div>
      </div>

      <div class="mb-3">
       <label class="d-block bg-transparent p-0 border-0 form-control{{ $errors->has('certified') ? ' is-invalid' : '' }}" for="certified">
        <input type="checkbox" name="certified" id="certified" value="1">
        <strong class="{{ $errors->has('certified') ? ' text-danger' : '' }}">I certify that I am a licensed Physician.</strong>
       </label>
       <div class="invalid-feedback">
        {{ $errors->first('certified') }}
       </div>
      </div>

      <button type="submit" class="btn btn-success btn-block">
       Submit
      </button>

     </form>
    </div>
   </div><!-- ./row -->
  </div>
 </div>
@endsection
