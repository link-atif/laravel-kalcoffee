@extends('layouts.homelayout.front_design')
@section('content')
<div class="inner_pages_title">
  <div class="container">
    <div class="courses_title">
      <h6>Checkout</h6>
    </div>
  </div>
</div>
<div class="container">
  @if($errors->any())
    <div class="alert alert-danger">
      @foreach($errors->all() as $error)
        {{ $error }} <br>
      @endforeach
    </div>
  @endif
  <div class="cart_section_main">
    <div class="row">
      <div class="col-md-8">
        <form action="
@if(\Auth::id() && \Auth::user()->type=="business"){{ route('order.checkout') }}
@else(\Auth::id() && \Auth::user()->type=="trainee"){{ route('training.checkout') }}


         @endif" name="frm" method="post" id="frm">{{ csrf_field() }}
          <input type="hidden" name="sub_total" value="{{ \Session::get('total') }}">
          <input type="hidden" name="grand_total" value="{{ \Session::get('grand_total') }}">
          <input type="hidden" name="discount_code" id="discount_code" value="{{ \Session::get('discount_code') }}">
          <input type="hidden" name="discount_amount" id="discount_amount" value="{{ $amount }}">
          <input type="hidden" name="vat" id="vat" value="{{ \Session::get('vat') }}">
          <input type="hidden" name="type" id="type" value="{{ $type }}">
        <div class="cart_left_col checkout_sec padd_l_0">
          <h6>Choose a payment option below</h6>
          <div class="check_payment_method">
             <label><input type="radio" name="payment_method" id="show_payment" @if(old('payment_method') && old('payment_method') == "pay") {{ "checked" }}  @endif value="pay">Pay</label>
             <label><input type="radio" name="payment_method" @if(old('payment_method') && old('payment_method') != "pay") {{ "checked" }} @endif  @if(old('payment_method') == "") {{ "checked" }}  @endif  id="show_transfer" value="transfer">Transfer</label>
          </div>
          <div class="payment_method_input_card" id="transfer" @if(old('payment_method') && old('payment_method') == "pay") style="display: none;" @endif @if(old('payment_method') == "") style="display: block;"  @endif>
            <p>Please transfer invoice total to:-</p>
            <p>Bank Name: {{ $bank_name }}</p>
            <p>IBAN: {{ $iban }}</p>
          </div>  
          <div class="payment_method_input_card" id="pay" @if(old('payment_method') && old('payment_method') == "pay") style="display: block;"  @else  style="display: none;" @endif>
            <div class="row">
              <div class="col-md-12">
                <input type="text" class="form-control" name="name_on_card" placeholder="Name on the Card">
              </div>
              <div class="col-md-8">
                <input type="text" class="form-control" name="card_number" placeholder="Credit Card Number">
              </div>
              <div class="col-md-2">
                <input type="text" class="form-control" name="expiration" placeholder="DD / YYYY">
              </div>
              <div class="col-md-2">
                <input type="text" class="form-control" name="cvv" placeholder="CVV">
              </div>
            </div>
          </div>   
        </div>
        <form>
      </div>
      <div class="col-md-4">
        <div class="cart_right_col">
          <h5>Summary <span class="pull-right">SAR</span></h5>
            <div class="subtotal_right">
              <p>Sub Total: <span>{{ number_format(\Session::get('total'), 2) }}</span></p>
              <p>VAT 5%: <span>{{ number_format(\Session::get('vat'), 2) }}</span></p>
              <p>Discount Amount: <span>{{ number_format(\Session::get('amount'), 2) }}</span></p>
              <p>Order Total: <span>{{ number_format(\Session::get('grand_total'), 2) }} </span></p>     
              <div class="cart_reward_sec">
                <!-- <p><input type="checkbox"> Use Reward Points <span>: 10 PTS</span></p> -->
              </div>
            </div>
            <a href="javascript:" onclick="submitForm();">CHECKOUT</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
  function submitForm(){
    $("#frm").submit();
  }

   $(document).ready(function(){
    $("#show_payment").click(function(){
      $("#pay").show();
      $("#transfer").hide();
    });
    $("#show_transfer").click(function(){
      $("#pay").hide();
      $("#transfer").show();
    });
   });
</script>
@endsection