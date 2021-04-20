@extends('layouts.homelayout.front_design')
@section('content')
  <div class="inner_pages_title">
    <div class="container">
      <div class="courses_title">
        <h6>Training</h6>
      </div>
    </div>
  </div>
  <div class="container">
    @include('home.partials.message')
    <div class="kal_cofee_Calender">
      <div class="date_calender">
        <div id='schedule_courses'></div>
        <div style='clear:both'></div>
     
      </div>
    </div>
  </div>
@endsection 
@section('script')
<script src="{{ asset('frontend/js/calender.js') }}"></script>
<!-- <script src="{{ asset('frontend/js/calender-2.js') }}"></script> -->
<script type="text/javascript">
    var calendar =  $('#schedule_courses').fullCalendar({
      header: {
        left: 'prev',
        center: 'title',
        right: 'next'
      },
      editable: true,
      firstDay: 1, //  1(Monday) this can be changed to 0(Sunday) for the USA system
      selectable: true,
      selectAllow: function(select) {
        return moment().diff(select.start) <= 0
      },
      defaultView: 'month',
      axisFormat: 'h:mm',
      columnFormat: {
        month: 'ddd',    // Mon
        week: 'ddd d', // Mon 7
        day: 'dddd M/d',  // Monday 9/7
        agendaDay: 'dddd d'
        },
        titleFormat: {
            month: 'MMMM yyyy', // September 2009
            week: "MMMM yyyy", // September 2009
            day: 'MMMM yyyy'                  // Tuesday, Sep 8, 2009
        },
      allDaySlot: false,
      selectHelper: true,
      events: "{{ URL::to('calendar_data') }}"
    });
</script>
@endsection