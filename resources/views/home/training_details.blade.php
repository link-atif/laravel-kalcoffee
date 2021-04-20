@extends('layouts.homelayout.front_design')
@section('content')       
<div class="inner_pages_title training_new_title">
  <div class="container">
    @include('home.partials.message')
    <div class="courses_title">
      <h6><img src="{{ asset('frontend/images/tea-mug.png') }}" alt=""> {{ $course->name }} {{ optional($level_details)->name }} - {{ Carbon\Carbon::parse(optional($schedule)->schedule_date)->format('F Y') }} </h6>
    </div>
  </div>
</div>
<div class="container">
  <div class="contact_section resiter_sec">
    <div class="register_inner register_inner_2">
      <div class="col-md-5">
        <div class="training_col_new">
          <p>{{ optional($level_details)->description }}</p>
        </div>
      </div>
           
      <div class="col-md-3">
        <div class="training_col_new">
          <h5><span>Duration</span>{{ optional($level_details)->duration }} day</h5>
          <h5><span>Price</span> SR {{ optional($level_details)->price }}</h5>
          <h5><span>Points</span>{{ optional($level_details)->points }}</h5>
        </div>
      </div>
           
      <div class="col-md-4">
        <div class="training_col_new">
          <h6>Schedule</h6>
          @if(!empty($level_details))
          @php 
          $today = Carbon\Carbon::today()->toDateString();
          $schedules =  App\Schedule::where('level_id',$level_details->id)->whereDate('schedule_date','>=',$today )->orderBy('schedule_date', 'asc')->get();
          @endphp
            @foreach($schedules as $schedule)
            <div class="enrol_levl_col">
              <p>{{ Carbon\Carbon::parse($schedule->schedule_date)->format('d F Y') }}</p>
              <a href="{{ url('training_cart/'.$schedule->id) }}">ENROLL NOW</a>
            </div>
            @endforeach
          @endif
        </div>
      </div>
           
      <div class="clearfix"></div>
           
      <div class="section_badges">
        <div class="col-md-12">
          <div class="enrol_badges">
            <div class="col-md-3">
              <div class="enrol_badges_col">
                <h5>{{ $course->name }}<br> Related Levels </h5>
              </div>
            </div>
            @if(!empty($level_details))
            @php $levels = App\Level::where('course_id', $course->id)->get(); @endphp
            @foreach($levels as $level)
              <div class="col-md-3"> <!-- where('id','<>', $level_details->id)-> -->
                <div class="enrol_badges_col @if($level->id == $level_details->id) enrol_badges_level enrol_badges_selected  @endif">
                  <a href="{{ url('training_details/'.$course->id.'/'.$level->id) }}">
                    <img src="{{ asset('frontend/images/badge.png') }}" alt="">
                    <p>{{ $level->name }}</p>
                    <h6>{{ $level->points }} Points</h6>
                  </a>
                </div>
              </div>
              @endforeach
            @endif
          </div>
        </div>
      </div> 
    </div>   
  </div>
</div>
@endsection     