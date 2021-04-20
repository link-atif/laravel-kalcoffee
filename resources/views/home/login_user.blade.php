@extends('layouts.homelayout.front_design')
@section('content')
<div class="inner_pages_title">
  <div class="container">
    <div class="courses_title">
      <h6>Login</h6>
    </div>
  </div>
</div>
<div class="container">
  <div class="contact_section resiter_sec">
    <div class="register_inner">
      <div class="col-md-5 padd_0">
        <div class="regiter_left">
          <img src="{{ asset('images/register_img.png') }}" alt="">
        </div>
      </div>
      <div class="col-md-7 padd_0">
        <div class="contact_right">       
          <div class="contact_right_col">
            <form action="{{ route('login.user') }}" method="post" name="frm" id="frm">{{ csrf_field() }}
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
              <div class="row">
                <div class="col-md-6">
                  <input type="text" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}">
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <input type="password" class="form-control" placeholder="Password*" name="password">
                </div>
              </div>
              <div class="section_promo_discount_2" style="margin-top: 10px;">
                <p id="forgot" style="color: black; font-weight: bold; cursor: pointer;">Forgot Your Password?</p>
              </div>
              <div class="col-md-12">
                <a href="javascript:" onclick="login_submit();">Login</a>
              </div>
              <div class="section_promo_discount_2" style="margin-top: 10px;">
                <p>Don't have an account register <span id="register" style="color: black; cursor: pointer;">here.</span></p>
              </div>
            </form>
          </div>
        </div>
      </div> 
    </div>
  </div>
</div>
@endsection
@section('script')
  <script type="text/javascript">
    function login_submit(){
      $('#frm').submit();
    }

    $(document).ready(function(){
      $("#register").on('click',function(){
        window.location.href = "{{ route('register.user') }}";
      });

      $("#forgot").on('click',function(){
        window.location.href = "{{ url('/password/reset') }}";
      });
    });

  </script>
@endsection