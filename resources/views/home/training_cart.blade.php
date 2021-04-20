@extends('layouts.homelayout.front_design')
@section('content')
<div class="inner_pages_title">
  <div class="container">
    <div class="courses_title">
      <h6>Cart</h6>
    </div>
  </div>
</div>
             
<div class="container">
  <div class="cart_section_main">
    @if(count($cartData) > 0)
    <div class="col-md-8">
      <div class="cart_left_col">
        <div class="cart_resposive_mobile">
          <table class="table">
            <thead>
              <tr>
                <th>Training Course</th>
                <th>Price</th>
                <th>Action</th>                                
              </tr>
            </thead>
            <tbody>
              @foreach($cartData as $cart)
             
              <tr>
                <td>
                    <h5 style="text-align: left;">{{ $cart->product_name }} - {{ $cart->level_name }}</h5>
                    <h5 style="text-align: left;">{{ Carbon\Carbon::parse($cart->schedule_date)->format('d F Y') }}</h5>
                </td>    
                <td>
                  <h5>{{ number_format($cart->price, 2) }}</h5>
                </td>
                <td>

                  <a href="{{ route('delete.training', $cart->id) }}" class="trash_btn" style="margin-top: 0px; text-align: center;"><i class="fas fa-trash-alt"></i></a>
                  
                </td>    
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="cart_right_col">
        <h5>Summary <span class="pull-right">SAR</span></h5>
        <div class="subtotal_right">
          <p>Sub Total:<span> {{ number_format($total,2) }} </span></p>
          <p>VAT 5%:<span> {{ number_format($vat,2) }} </span></p>
          <p>Order Total:<span> {{ number_format($grand_total,2) }}</span></p>
          <input type="text" class="form-control" name="code" id="code" placeholder="Enter your discount code here">
        </div>
        @if(!\Auth::id())
        <a href="javascript:" onclick="goToLogin()">Login</a>
        @else
        <a href="javascript:" onclick="submitForm()">CHECKOUT</a>
        @endif
      </div>
    </div>
    <form action="{{ route('training.payment') }}" method="post" name="frm" id="frm">{{ csrf_field() }}
      <input type="hidden" name="sub_total" value="{{ $total }}">
      <input type="hidden" name="vat" value="{{ $vat }}">
      <input type="hidden" name="grand_total" value="{{ $grand_total }}">
      <input type="hidden" name="discount_code" id="discount_code" value="">
    </form>
    <form action="{{ route('login.user') }}" method="post" name="login_form" id="login_form">{{ csrf_field() }}
      <input type="hidden" name="login" value="training.cart">
    </form>
    @else
      <h2>Cart Is Empty</h2>
    @endif
  </div>
</div>
@endsection

@section('script')
  <script type="text/javascript">
    function submitForm(){
      $('#discount_code').val($("#code").val());
      $("#frm").submit();
    }

    function goToLogin(){
      $("#login_form").submit();
    }
  </script>
@endsection