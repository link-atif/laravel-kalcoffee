@extends('layouts.homelayout.front_design')
@section('content')       
<div class="inner_pages_title dashboard_title_tp">
  <div class="container">
    <div class="courses_title">
      <h6>Dashboard </h6>
    </div>
  </div>
</div>
<div class="container">
  <div class="contact_section resiter_sec dashboard_sec_new">           
    <div class="row row_mb">
      @if(Session::has('flash_message_success'))
        <div class="alert alert-success alert-block">
          <button type="button" class="close" data-dismiss="alert">x</button>
          <strong>{!! session('flash_message_success') !!}</strong>
        </div>
      @endif
      @if(Session::has('flash_message_error'))
        <div class="alert alert-danger alert-block">
          <button type="button" class="close" data-dismiss="alert">x</button>
          <strong>{!! session('flash_message_error') 
      @endif
      @if($errors->any())
          <div class="alert alert-danger alert-block">
          <button type="button" class="close" data-dismiss="alert">x</button>
            @foreach($errors->all() as $error)
              <strong>{{ $error }}</strong><br>
            @endforeach
          </div>
      @endif
      <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="register_inner">
          <div class="dashobard_col">
            <h4>Orders</h4>
            <div class="order_processed">
              <div class="cart_section_main">
 
              <!-- <div >
                <div class="cart_left_col"> -->

                  <div class="cart_resposive_mobile">
                    <table class="table" style="text-align: center;">
                      <thead>
                        <tr>             
                          <td >Id</td>
                          <td >Adress </td>
                          <td >Details</td>
                        </tr>
                        @if(isset($orders))
                        @foreach($orders as $o)
                          @if($o->order_status == 'pending'  )  
                          <tr>
                          <td>Id#{{ $o->id }}</td>
                          <td>{{ $o->country }}</td>
                          <td><a href="{{url('/order.detail/'.$o->id )}}" class="btn btn-info btn-small">View</a></td>            
                        </tr>
                          @endif
                        @endforeach           
                        @endif
                    
                  </thead>
                </table></div></div>
             <!--  </div>
            </div> -->
               {{ $orders->links() }}
            </div>
            <div class="order_history">
              
            </div>
          </div>
        </div>
      </div>         
      <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="register_inner">
          <div class="dashobard_col">
            <h4>Address</h4>
            <div class="order_processed billing_address">
              <h5>billing address</h5>
              <p>{{ $user->address1 }}</p>
              <a href="#" class="address_edit_btn">Edit</a>
            </div>
            <div class="order_processed billing_address">
              <h5>shipping address</h5>
              <p>{{ $user->addresss1 }}</p>
              <a href="#" class="address_edit_btn">Edit</a>
            </div>
          </div>
        </div>
      </div>               
      <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="register_inner">
          <div class="dashobard_col">
          <h4>Account Details</h4>
            <div class="dashboard_form">
              <form method="post" name="frm" id="frm" action="{{ route('update.user') }}">{{ csrf_field() }}
                <input type="text" class="form-control" name="name" placeholder="Entity Name" value="{{ $user->name }}">
                <input type="text" class="form-control" name="contact_name" placeholder="Contact Name" value="{{ $user->contact_name }}">
                <input type="text" class="form-control" name="email" placeholder="Email" readonly="readonly" value="{{ $user->email }}">
                <input type="text" class="form-control" name="phone_number" placeholder="Phone Number" value="{{ $user->phone_number }}">
                <div class="change_pas_field">
                  <input type="password" id="password" name="password" class="form-control" disabled="disabled" placeholder="Password">
                  <a href="javascript:" class="change_pass_btn" onclick="changePassword()">Change Password</a>
                </div>
                <a href="javascript:" class="update_btn_db" onclick="submitForm()">Update</a>
              </form>
            </div>
          </div>
        </div>
      </div>   
    </div>           
  </div>
</div>
@endsection
@section('script')
<script>
  function changePassword(){
    $('#password').attr('disabled',!$("#password").attr('disabled'));
  }

  function submitForm(){
    $('#frm').submit();
  }  
</script>
@endsection