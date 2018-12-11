@extends('back.layouts.main-auth')

@section('title', 'Login | Klorofil - Free Bootstrap Dashboard Template')



@section('content')
					<div class="left">
						<div class="content">
							<div class="header">
								<div class="logo text-center"><img src="{{ asset('back/img/logo-dark.png') }}" alt="Klorofil Logo"></div>
								<p class="lead">Login to your account</p>
							</div>
							<form class="form-auth-small" method="POST" action="{{ route('login') }}">
								@csrf
								<div class="form-group">
									<label for="signin-email" class="control-label sr-only">Email</label>
									<input type="email" name="email" class="form-control" id="signin-email" placeholder="Email" required>
	                                @if ($errors->has('email'))
	                                    <span class="invalid-feedback" role="alert">
	                                        <strong>{{ $errors->first('email') }}</strong>
	                                    </span>
	                                @endif
								</div>
								<div class="form-group">
									<label for="signin-password" class="control-label sr-only">Contraseña</label>
									<input type="password" name="password" class="form-control" id="signin-password" placeholder="Contraseña" required>
	                                @if ($errors->has('password'))
	                                    <span class="invalid-feedback" role="alert">
	                                        <strong>{{ $errors->first('password') }}</strong>
	                                    </span>
	                                @endif
								</div>
								<div class="form-group clearfix">
									<label class="fancy-checkbox element-left">
										<input type="checkbox" name="remember">
										<span>Remember me</span>
									</label>
								</div>
								<button type="submit" class="btn btn-primary btn-lg btn-block">LOGIN</button>
								<div class="bottom">
									<span class="helper-text"><i class="fa fa-lock"></i> <a href="{{ route('password.request') }}">Forgot password?</a></span>
								</div>
							</form>
						</div>
					</div>
					<div class="right" style="background-image: url('{{ asset('back/img/login-bg.jpg') }}');">
						<div class="overlay"></div>
						<div class="content text">
							<h1 class="heading">Free Bootstrap dashboard template</h1>
							<p>by The Develovers</p>
						</div>
					</div>
					<div class="clearfix"></div>
@endsection