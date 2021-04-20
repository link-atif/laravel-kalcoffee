@extends('layouts.homelayout.front_design');
@section('content')
	<section id="form"><!--form-->
		<div class="container">
			<div class="row">
				@if(Session::has('flash_message_success'))
					<div class="alert alert-success alert-block">
						<button type="button" class="close" data-dismiss="alert">x</button>
						<strong>{!! session('flash_message_success') !!}</strong>
					</div>
				@endif
				@if(Session::has('flash_message_error'))
					<div class="alert alert-danger alert-block">
						<button type="button" class="close" data-dismiss="alert">x</button>
						<strong>{!! session('flash_message_error') !!}</strong>
					</div>
				@endif
				@if($errors->any())
	                <div class="alert alert-danger alert-block">
	                <button type="button" class="close" data-dismiss="alert">x</button>
	                  @foreach($errors->all() as $error)
	                    <strong>{{ $error }}</strong><br>
	                  @endforeach
	                </div>
	            @endif
				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form"><!--login form-->
						<h2>Login to your account</h2>
						<form action="{{ route('login.user')}}" method="post" name="login_form" id="login_form">{{ csrf_field() }}
							<input type="email" placeholder="Email Address" name="email" />
							<input type="password" name="password" />
							<span>
								<input type="checkbox" class="checkbox"> 
								Keep me signed in
							</span>
							<button type="submit" class="btn btn-default">Login</button>
						</form>
					</div><!--/login form-->
				</div>
				<div class="col-sm-1">
					<h2 class="or">OR</h2>
				</div>
				<div class="col-sm-4">
					<div class="signup-form"><!--sign up form-->
						<h2>New User Signup!</h2>
						<form action="{{ route('login.register') }}" method="post" name="frm" id="frm">{{ csrf_field() }}
							<input type="text" placeholder="Name" name="name" value="{{ old('name') }}">
							<input type="text" placeholder="Contact Name" name="contact_name" value="{{ old('contact_name') }}">
							<input type="email" placeholder="Email Address" name="email" value="{{ old('email') }}">
							<input type="text" placeholder="Address Line 1" name="address_1" value="{{ old('address_1') }}">
							<input type="text" placeholder="Address Line 2" name="address_2" value="{{ old('address_2') }}">
							<input type="text" placeholder="Phone Number" name="phone_number" value="{{ old('phone_number') }}">
							<input type="text" placeholder="Country" name="country" value="{{ old('country') }}">
							<input type="text" placeholder="City" name="city" value="{{ old('city') }}">
							<input type="password" placeholder="Password" name="password">
							<button type="submit" class="btn btn-default">Signup</button>
						</form>
					</div><!--/sign up form-->
				</div>
			</div>
		</div>
	</section><!--/form-->
@endsection