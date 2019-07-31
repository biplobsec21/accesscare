@extends('layouts.app')

@section('content')
    <div class="card mb-5">
        <div id="header" class="text-center">
            <img src="https://www.earlyaccesscare.com/images/eac_mini.png" class="img-fluid">
        </div>
        <div class="card-body">
            @php
                if(Session::has('alerts')) {
                  $alert = Session::get('alerts');
                  $alert_dismiss = view('layouts.alert-dismiss', ['type' => $alert['type'], 'message' => $alert['msg']]);
                  echo $alert_dismiss;
                }
            @endphp
            <div class="tab-content" id="LoginPContent">
                <div class="col-md col-lg p-3 p-lg-4 p-xl-5 ml-lg-auto mr-lg-auto">
                    <div class="tab-content" id="LoginPContent">
                        <div class="tab-pane fade show active" id="loginGen" role="tabpanel" aria-labelledby="loginGen-tab">
                            <form method="post" action="{{ route('eac.auth.password.reset.submit') }}">
                                @csrf
                                <input type="hidden" name="table" value="eac_user"/>
                                <h4 class="text-center">Please enter your email.</h4>
                                <div class="mb-3 mb-xl-4">
                                    <label class="d-block">Email</label>
                                    <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" type="text" name="email" id="email" placeholder="Email Address" value="{{ old('email') }}">
                                    <div class="invalid-feedback">
                                        {{ $errors->first('email') }}
                                        {{--Either your username or password is incorrect.--}}
                                    </div>
                                </div>
                                
                                <button class="btn btn-success btn-block" type="submit" id="" value="Reset">
                                    Reset my password
                                </button>
                            
                            </form><!-- end eac form -->
                        </div>
                    
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-center">
            <a href="{{ route('eac.auth.getSignIn') }}">
                Go Back to Login
            </a>
        </div>
    </div>
@endsection
