@extends('layouts.homelayout.front_design')
@section('content')     
@php  $ids = array();  @endphp     
<div class="inner_pages_title heading_text">
  <div class="container">
    <div class="courses_title">
      <h6>Based on your answers, <br><span class="simple_text">below are the recommendations {{ $plantool_type }}</span></h6>
    </div>
  </div>
</div>
<div class="container">
  <div class="contact_section resiter_sec">
    <div class="register_inner">
      <div class="col-md-5 padd_0">
        <div class="regiter_left traine_left">
          <img src="{{ asset('frontend/images/plan_tool_2.png') }}" alt="">
        </div>
      </div>
      <div class="col-md-7 padd_0">
        <div class="contact_right">
          <div class="contact_right_col">
            <div class="quantity_per_month">
              <div class="traine_quantity_2">
                <h6>Recommended Quantity Per Month</h6>
                <p>90 to 150 kg for espresso and 60 to 100 kg for filtered coffee</p>
                <div class="col-md-5 padd_0">
                  <div class="quantity_filter_sec">
                    <h5>Espresso 
                      @foreach($espresso_products as $e)
                      @php array_push($ids, $e->id)  @endphp
                      <span>{{ $e->product_name }}</span>
                      @endforeach
                    </h5>
                  </div>
                </div>
                <div class="col-md-5 padd_0">
                  <div class="quantity_filter_sec">
                    <h5>Filtered Coffee 
                      @foreach($filtered_products as $f)
                      @php array_push($ids, $f->id)  @endphp
                      <span>{{ $f->product_name }}</span>
                      @endforeach
                  </div>
                </div>
              </div>
              @if($code !="")
              <div class="section_promo_discount">
                <p>We appreciate having you as a client, please use promo code <span>{{ $code }}</span> to get a <br><span>{{ $value }}% discount</span> on your first purchase</p>
              </div>

              <div class="section_promo_discount_2">
                <p>This promo code is valid until <span>{{ Carbon\Carbon::parse($expiry_date)->format('d F Y') }}.</span></p>
              </div>
              <a href="javascript:{}" onclick="document.getElementById('frm').submit()" class="margin_t_0">BUY COFFEE</a>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<form name="frm" id="frm" action="{{ route('bulk.cart') }}" method="post">{{ csrf_field() }}
  <input type="hidden" name="ids" value="{{ json_encode($ids,TRUE)}}" id="ids">  
</form>
@endsection