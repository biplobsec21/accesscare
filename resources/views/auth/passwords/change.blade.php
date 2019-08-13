@extends('layouts.portal')

@section('title')
    Change Password
@endsection

@section('content')
    <div class="card mb-5" style="max-width: 700px">
        <div id="header" class="text-center">
            <img src="https://www.earlyaccesscare.com/images/eac_mini.png" class="img-fluid">
        </div>
        <div class="card-body">
            @include('include.alerts')
            <div class="tab-content" id="LoginPContent">
                <div class="col-md col-lg p-3 p-lg-4 p-xl-5 ml-lg-auto mr-lg-auto">
                    <div class="tab-content" id="LoginPContent">
                        <div class="tab-pane fade show active" id="loginGen" role="tabpanel" aria-labelledby="loginGen-tab">
                            <form method="post" action="{{ route('eac.auth.password.update') }}">
                                @csrf
                                <div class="mb-3 mb-xl-4">
                                    <label class="d-block">Current Password</label>
                                    <input class="form-control{{ $errors->has('current_password') ? ' is-invalid' : '' }}" type="password" name="current_password" placeholder="Current Password" value="{{ !$errors->has('current_password') ? old('current_password') : '' }}">
                                    <div class="invalid-feedback">
                                        {{ $errors->first('current_password') }}
                                    </div>
                                </div>
                                <div>
                                    <label class="d-block">New Password</label>
                                </div>
                                <div class="input-group mb-3 mb-xl-4">
                                    <input class="form-control{{ $errors->has('new_password') ? ' is-invalid' : '' }}" type="password" id="new_password" name="new_password" placeholder="New Password" value="">
                                    <div class="input-group-append">
                                        <button tabindex="0" class="btn btn-outline-info btn-pw-show" type="button">
                                            SHOW
                                        </button>
                                        <button tabindex="0" class="btn btn-outline-info btn-pw-hide" type="button" style="display: none;">
                                            HIDE
                                        </button>
                                    </div>
                                </div>
                                <button class="btn btn-success btn-block" type="submit" id="" value="Reset">
                                    Change Password
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-center">
            <a href="{{ route('eac.portal.getDashboard') }}">
                Go to Dashboard
            </a>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $( document ).ready(function() {
            $(".btn-pw-show").click(function () {
                $("#new_password").attr('type', 'text');
                $(this).hide();
                $('.btn-pw-hide').removeClass('d-none').show();
            });
            $(".btn-pw-hide").click(function () {
                $("#new_password").attr('type', 'password');
                $(this).hide();
                $('.btn-pw-show').removeClass('d-none').show();
            });
        });
    </script>
@endsection
