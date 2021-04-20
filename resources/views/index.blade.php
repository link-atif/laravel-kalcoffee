@extends('layouts.homelayout.front_design')
@section('content')
  @if($products_status == 'enable')
  <div class="home_banner_lower_sec btn_Set">
    <div class="container">
        @foreach($products as $p)
        <div class="col-md-4">
          <div class="coffe_types_Sec">
            <img src="{{ asset('images/admin/products/'.$p->image) }}" alt="">
            <a class="cofe_link" href="{{ route('product.details',$p->id) }}">{{ $p->product_name }}</a>
            <p><span class="cofe_price">{{ $p->price }}</span> SAR</p>
            <a href="" class="adto_Cart">ADD TO CART</a>
          </div>
        </div>
        @endforeach
        <div class="shop_all_btn">
            <a href="{{ route('products') }}">shop all coffee</a>
        </div>
    </div>
  </div>
  @endif
  @if($training_status == 'enable')
  <div class="upcoming_courses_sec">
    <div class="container">
      <div class="courses_title set_h_padd">
          <h6>Upcoming Training Courses</h6>
      </div>
      <div class="row">
        @foreach($courses as $course)
        @php
        $start_date =  App\Schedule::where('course_id',$course->id)->orderBy('schedule_date','ASC')->pluck('schedule_date')->first();
        $end_date =  App\Schedule::where('course_id',$course->id)->orderBy('schedule_date','DESC')->pluck('schedule_date')->first(); 
        @endphp
          <div class="col-md-4">
            <div class="section_cource_col">
                <img src="{{ asset('images/admin/courses/'.$course->image) }}" alt="">
                <a href="#">{{ $course->name }}<br>Main Camp</a>
                <p><span class="clock"><img src="{{ asset('frontend/images/clock%201.png') }}" alt=""></span>{{ \Carbon\Carbon::parse($start_date)->format('M d,y')}} - {{ \Carbon\Carbon::parse($end_date)->format('M d,y')}}</p>
            </div>
          </div>
        @endforeach
      </div>
      <div class="shop_all_btn">
          <a href="#">SEE ALL COURSES</a>
      </div>
    </div>
  </div>
  @endif

  <div class="home_about_section">
    <div class="container">
      <div class="col-md-5">
        <div class="about_left_col" _col>
          <img src="{{ asset('images/'.$aboutus_picture) }}" alt="">
        </div>
      </div>
      <div class="col-md-7">
        <div class="about_right_col">
          <div class="courses_title">
            <h6>{{ $aboutus_title }}</h6>
          </div>
          <p><span>{{ $aboutus_description1 }}</span></p>
          <p>{{ $aboutus_description2 }}</p>
          <a href="{{ route('about-us') }}">{{ $aboutus_button_text }}</a>
        </div>
      </div>
    </div>
  </div>

  @if($media_status == 'enable')
  <div class="upcoming_courses_sec">
    <div class="container">
      <div class="courses_title set_h_padd">
        <h6>In the Media</h6>
      </div>
      @foreach($media as $m)
      <div class="col-md-3">
        <div class="section_cource_col">
          <img src="{{ asset('images/admin/media/'.$m->file) }}" alt="">
          <a href="#">{{ $m->title }}</a>
          <p>{{ $m->description }}</p>
        </div>
      </div>
      @endforeach            
      <div class="shop_all_btn">
          <a href="#">SEE ALL MEDIA</a>
      </div>
    </div>
  </div>
  @endif
  @if($clients_status == 'enable')
  <div class="home_clinets">
    <div class="container">
      <div class="courses_title set_h_padd">
        <h6>Clients</h6>
      </div>
      @foreach($clients as $client)
      <div class="clients_col">
        <img src="{{ asset('images/admin/clients/'.$client->file) }}" alt="">
      </div>
      @endforeach
    </div>
  </div>
  @endif
@endsection