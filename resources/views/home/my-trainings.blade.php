@extends('layouts.homelayout.front_design')
@section('content')
<div class="inner_pages_title dashboard_title_tp">
  <div class="container">
    <div class="courses_title">
      <h6>My Trainings </h6>
    </div>
  </div>
</div>
<div class="container">
  <div class="contact_section resiter_sec dashboard_sec_new">           
    <div class="row row_mb">
      <div class="col-md-12 col-sm-8 col-xs-12">
        <div class="register_inner">
          <div class="dashobard_col">
            <h4>Orders</h4>
               <div class="cart_resposive_mobile">
                  <table class="table" style="text-align: center;">

                  
                    <thead>
                      <tr>             
                        <th>Course Name</th>
                        <th>Duration </th>  
                        <th>Schedule Date</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th>Payment Type</th>
                      </tr>
                    </thead>
                    <tbody>
                     
                        @if(!empty($orders))
                    
                      @foreach($orders as $o)
                      @php 
                        $product_name = App\Courses::where('id', $o->course_id)->pluck('name')->first();
                        $level_name = App\Level::where('id', $o->level_id)->pluck('name')->first();
                        $level_duration = App\Level::where('id', $o->level_id)->pluck('duration')->first();

                        $status = App\Order::where('id', $o->order_id)->pluck('order_status')->first();

                        $payment = App\Order::where('id', $o->order_id)->pluck('payment_method')->first();
                      @endphp
                      <tr style="text-align: left;">
                        <td>{{ $product_name }} - {{ $level_name }}</td>
                        <td>{{ $level_duration }}</td>
                        <td>{{ Carbon\Carbon::parse($o->schedule_date)->format('d F Y') }}</td>
                        <td>{{$o->price}}</td>

                        <td>{{$status}}</td>
                          @if($payment ="pay")
                            <td>Card</td>
                          @else
                            <td>Transfer</td>
                          @endif
                      </tr>
                       @endforeach
                    </tbody>
                  </table>

         
               
              @endif
            </div>
          </div>
        </div>
      </div>        
    </div>           
  </div>
</div>
@endsection