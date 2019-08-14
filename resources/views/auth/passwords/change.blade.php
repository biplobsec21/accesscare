@extends('layouts.portal')

@section('title')
 Change Password
@endsection

@section('content')
 <div class="titleBar">
  <h2 class="m-0">
   @yield('title')
  </h2>
 </div>
 <div class="viewData">
  @include('include.alerts')
  <div class="card card-body" style="max-width: 568px">
   <form method="post" action="{{ route('eac.auth.password.update') }}">
    @csrf
    <div class="mb-3">
     <label>Current Password</label>
     <input class="form-control{{ $errors->has('current_password') ? ' is-invalid' : '' }}" type="password" name="current_password" placeholder="Current Password" value="{{ !$errors->has('current_password') ? old('current_password') : '' }}">
     <div class="invalid-feedback">
      {{ $errors->first('current_password') }}
     </div>
    </div>
    <div class="mb-3">
     <label>New Password</label>
     <div class="input-group mb-0">
      <input class="form-control{{ $errors->has('new_password') ? ' is-invalid' : '' }}" type="password" id="new_password" name="new_password" placeholder="New Password" value="">
      <div class="input-group-append">
       <button tabindex="0" class="btn btn-outline-dark btn-pw-show" type="button">
        <span class="fad fa-fw fa-lock-open-alt"></span> Show
       </button>
       <button tabindex="0" class="btn btn-dark btn-pw-hide" type="button" style="display: none;">
        <span class="fad fa-fw fa-lock-alt"></span> Hide
       </button>
      </div>
     </div>
    </div>
    <div class="text-center">
     <button class="btn btn-success" type="submit" id="" value="Reset">
      Change Password
     </button>
    </div>
   </form>
  </div>
 </div><!-- /.viewData -->
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
