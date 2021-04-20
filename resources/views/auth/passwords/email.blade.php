@extends('layouts.homelayout.front_design')
@section('content')
<div class="inner_pages_title">
  <div class="container">
    <div class="courses_title">
      <h6>Forgot Password</h6>
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
            <form action="{{ route('password.email') }}" method="post" name="frm" id="frm">{{ csrf_field() }}
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
              <div class="clearfix"></div>
              <div class="col-md-12">
                <a href="javascript:" onclick="submitForm()" id="login">Submit</a>
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
    function submitForm(){
      $('#frm').submit();
    }
  </script>
@endsection