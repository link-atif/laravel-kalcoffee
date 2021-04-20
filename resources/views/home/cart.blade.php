@extends('layouts.homelayout.front_design')
@section('content')
@php  $subtotal = 0; @endphp
<div class="inner_pages_title">
  <div class="container">
    <div class="courses_title">
      <h6>Cart</h6>
    </div>
  </div>
</div>
             
<div class="container">
  @include('home.partials.message')
  <div class="cart_section_main">
    @if(count($cartData) > 0)
    <div class="col-md-8">
      <div class="cart_left_col">
        <div class="cart_resposive_mobile">
          <table class="table">
            <thead>
              <tr>
                <th>Item</th>
                <th>Unit Price</th>
                <th>Quantity</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
            @foreach($cartData as $cart)
            @php 
              $subtotal = $subtotal + ($cart->price * $cart->quantity)
            @endphp
              <tr>
                <td>
                  <div class="cart_product_image_col">
                    @if(!empty($cart->image))
                      <img src="{{ asset('/images/admin/products/'.$cart->image) }}" style="width:100px; height: 100px;">
                    @endif
                    <h6>{{ $cart->product_name }} - @if($cart->order_type=='full') {{ $cart->bag_size }} Bag @endif</h6>
                    </div>
                    <a href="#"><span class="ion-ios-close"></span></a>
                  </td>
                  <td>
                    <h5>{{ $cart->price }}</h5>
                  </td>
                  <td>
                    <select name="quantity-{{ $cart->id }}" id="quantity-{{ $cart->id }}" data-cart_id = "{{ $cart->id }}" @if($cart->order_type=='sample') disabled="disabled" @endif  onchange="updateQuantity(this)" class="form-control">
                      @for($i=1; $i<=100; $i++)
                      <option value="{{ $i }}" @if($cart->quantity == $i) selected="selected" @endif>{{ $i }}</option>
                      @endfor
                    </select>
                    <a href="{{ route('delete.item',$cart->id) }}" class="trash_btn"><i class="fas fa-trash-alt"></i></a>
                  </td>
                  <td>
                    <h5>{{ $cart->price * $cart->quantity }}</h5>
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
          @php
           $vat = ($v_tax/100)*$subtotal;
           $grand_total = $vat + $subtotal;
          @endphp
          <p>Sub Total:<span> {{ number_format($subtotal, 2) }} </span></p>
          <p>VAT {{ $v_tax }}%:<span> {{ number_format($vat, 2) }} </span></p>
          <p>Order Total:<span>{{ number_format($grand_total, 2) }}</span></p>
          <input type="text" class="form-control" name="code" id="code" placeholder="Enter your discount code here">
        </div>
        @if(!\Auth::id())
        <a href="javascript:" onclick="submitLoginForm()">Login</a>
        @else
        <a href="javascript:" onclick="submitForm()">CHECKOUT</a>
        @endif
      </div>
    </div>
    <form action="@if(\Auth::id() && \Auth::user()->isWholeSale=="Yes"){{ route('saler') }} 
@else {{ route('order.payment') }}  @endif" method="post" name="frm" id="frm">{{ csrf_field() }}
      <input type="hidden" name="sub_total" value="{{ $subtotal }}">
      <input type="hidden" name="vat" value="{{ $vat }}">
      <input type="hidden" name="grand_total" value="{{ $grand_total }}">
      <input type="hidden" name="discount_code" id="discount_code" value="">
    </form>

    <form action="{{ route('update.quantity') }}" method="post" name="update" id="update">{{ csrf_field() }}
      <input type="hidden" name="cart_id" id="cart_id" value="">
      <input type="hidden" name="quantity" id="quantity" value="">
    </form>
    <form action="{{ route('login.user') }}" method="post" name="login_form" id="login_form">{{ csrf_field() }}
      <input type="hidden" name="login" value="cart.details">
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

    function submitLoginForm(){
      $("#login_form").submit();
    }

    function updateQuantity(x){
      $("#quantity").val($(x).val());
      $("#cart_id").val($(x).attr('data-cart_id'));
      $("#update").submit();
    }
  </script>
@endsection