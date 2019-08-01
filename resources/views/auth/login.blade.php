@extends('layouts.frame')

@section('title')
	Sign In
@endsection

@section('content')
	<div class="card">
		<div class="card-header">
		</div>
		<div class="card-body p-0">
			<div class="row m-0">
				<div class="text-center col-md col-lg-auto bg-dark text-white p-3 p-lg-4 p-xl-5">
					<img src="{{ asset('/images/logo-w-bg.png') }}" alt="Early Access Care" class="img-fluid mb-3" />
					<ul class="nav nav-pills justify-content-center" id="LoginP" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="loginGen-tab" data-toggle="tab" href="#loginGen" role="tab"
								aria-controls="loginGen" aria-selected="true">
								Login
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="trackRID-tab" data-toggle="tab" href="#trackRID" role="tab"
								aria-controls="trackRID" aria-selected="false">
								Track RID
							</a>
						</li>
					</ul>
				</div>
				<div class="col-md col-lg p-3 p-lg-4 p-xl-5 ml-lg-auto mr-lg-auto">
					<div class="tab-content" id="LoginPContent">
						<div class="tab-pane fade show active" id="loginGen" role="tabpanel" aria-labelledby="loginGen-tab">
							<form method="post" action="{{ route('eac.auth.postSignIn') }}">
								{{ csrf_field() }}
								<input type="hidden" name="table" value="eac_user"/>
								<h4 class="text-center">Please enter your email address and password.</h4>
								<div class="mb-3 mb-xl-4">
									<label class="d-block">Email</label>
									<input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" type="text" name="email" id="email" placeholder="Email Address" value="{{ old('email') }}">
									<div class="invalid-feedback">
										{{ $errors->first('email') }}
										{{--Either your username or password is incorrect.--}}
									</div>
								</div>
								<div class="mb-3 mb-xl-4">
									<label class="d-block">Password</label>
									<input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" type="password" id="password" name="password" placeholder="Password">
									<div class="invalid-feedback">
										{{ $errors->first('password') }}
										{{--Either your username or password is incorrect.--}}
									</div>
									<div class="text-right">
                                        <a href="{{ route('eac.auth.password.forgot') }}" id="forgotPassword" class="btn btn-sm btn-link">
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
						<div class="tab-pane fade" id="trackRID" role="tabpanel" aria-labelledby="trackRID-tab">
							<form method="post" name="" action="{{ route('eac.auth.ridtrack.patient') }}">
								{{ csrf_field() }}
								<input type="hidden" name="table" value="patient_user"/>
								<h4 class="text-center">Please enter RID Number and password.</h4>
								<div class="mb-3 mb-xl-4">
									<label class="d-block">RID Number</label>
									<input class="form-control" type="text" name="rid_id" placeholder="RID Number">
								</div>
								<div class="mb-3 mb-xl-4">
									<label class="d-block">Password</label>
									<input class="form-control" type="password" name="password" placeholder="Password"
									>
								</div>
								<button class="btn btn-dark btn-block" type="submit" name="cmd" value="Log In">
									Log In
								</button>
							</form><!-- end track rid form -->
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="card-footer text-center">
			Need Help? <a target="_blank" href="mailto:{{site()->email}}">contact EAC</a>
		</div>
	</div>

@endsection
