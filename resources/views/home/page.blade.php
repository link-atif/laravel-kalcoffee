@extends('layouts.homelayout.front_design')
@section('content')
  <div class="inner_pages_title">
     <div class="container">
          <div class="courses_title">
             <h6>{{ $page_data->title }}</h6>
          </div>
     </div>
  </div>
       
       
  <div class="container">
       {!! trimString($page_data->body) !!}  </div>
@endsection