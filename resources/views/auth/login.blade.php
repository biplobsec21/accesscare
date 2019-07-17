@extends('layouts.app')

@section('title')
	Sign In
@endsection

@section('content')
	<div class="card">
		<div id="header" class="text-center border-0">
			<img src="https://www.earlyaccesscare.com/images/eac_mini.png" class="img-fluid"/>
		</div>
		<div class="card-header">
			<ul class="nav nav-tabs justify-content-center" id="LoginP" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" id="one-tab" data-toggle="tab" href="#one" role="tab"
						 aria-controls="one" aria-selected="true">
						Login
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="four-tab" data-toggle="tab" href="#four" role="tab"
						 aria-controls="four" aria-selected="false">
						Track RID
					</a>
				</li>
			</ul>
		</div>
		<div class="card-body">
			<div class="tab-content" id="LoginPContent">
				<div class="tab-pane fade show active" id="one" role="tabpanel" aria-labelledby="one-tab">
					<form method="post" action="{{ route('eac.auth.postSignIn') }}">
						{{ csrf_field() }}
						<input type="hidden" name="table" value="eac_user"/>
						<h4 class="text-center">Please enter your email address and password.</h4>
      <div class="mb-3 mb-xl-4">
							<label>Email</label>
							<input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" type="text" name="email"
										 id="email"
										 placeholder="Email Address" value="{{ old('email') }}">
							<div class="invalid-feedback">
								{{ $errors->first('email') }}
								{{--Either your username or password is incorrect.--}}
							</div>
      </div>
      <div class="mb-3 mb-xl-4">
							<label>Password</label>
							<input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" type="password"
										 id="password"
										 name="password" placeholder="Password">
							<div class="invalid-feedback">
								{{ $errors->first('password') }}
								{{--Either your username or password is incorrect.--}}
							</div>
 						<div class="text-right small">
 							<a href="javascript:;" id="forgotPassword">
 								<i class="far fa-lock"></i> Forgot Password
 							</a>
 						</div>
      </div>
						<button class="btn btn-dark btn-block" type="submit" id="login_submit" value="Log In">
       Log In
						</button>
						<div class="text-center">
							<a href="{{ route('eac.auth.getSignUp') }}">Register as User</a>
						</div>
					</form><!-- end eac form -->
				</div>
				<div class="tab-pane fade" id="four" role="tabpanel" aria-labelledby="four-tab">
					<form method="post" name="" action="{{ route('eac.auth.ridtrack.patient') }}">
						{{ csrf_field() }}
						<input type="hidden" name="table" value="patient_user"/>
						<h4 class="text-center">Please enter RID Number and password.</h4>
						<div class="row">
							<div class="col-sm col-lg-12">
								<label>RID Number</label>
							</div>
							<div class="col-sm col-lg-12">
								<input class="form-control" type="text" name="rid_id" placeholder="RID Number"
											 >
							</div>
						</div>
						<div class="row">
							<div class="col-sm col-lg-12">
								<label>Password</label>
							</div>
							<div class="col-sm col-lg-12">
								<input class="form-control" type="password" name="password" placeholder="Password"
							>
							</div>
						</div>
						<button class="btn btn-dark btn-block" type="submit" name="cmd" value="Log In">Log In
						</button>
					</form><!-- end track rid form -->
				</div>
			</div>
		</div>
		<div class="card-footer text-center">
			Need Help? <a href="https://www.earlyaccesscare.com/contact.htm" target="_blank">Contact
				EAC</a>
		</div>
	</div>
@endsection
