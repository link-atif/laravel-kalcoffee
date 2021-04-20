
@extends('layouts.homelayout.front_design')
@section('content')      
<div class="inner_pages_title">
   <div class="container">
        <div class="courses_title">
           <h6>FAQ </h6>
        </div>
   </div>
</div>
       
<div class="container">
   <div class="accordian_sec">
      <div class="wrapper center-block">
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
          @foreach($faqs as $faq)
          <div class="panel panel-default">
            <div class="panel-heading @if($loop->index == 0) {{ 'active' }} @endif" role="tab" id="heading{{ $loop->index }}">
              <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $loop->index }}" aria-expanded="@if($loop->index == 0) {{ true }} @else {{ false }} @endif" aria-controls="collapse{{ $loop->index }}">
                  {{ $loop->index+1 }}.  {{ $faq->question }}
                </a>
              </h4>
            </div>
            <div id="collapse{{ $loop->index }}" class="panel-collapse collapse @if($loop->index == 0) {{ 'in' }} @endif" role="tabpanel" aria-labelledby="heading{{ $loop->index }}">
              <div class="panel-body">
                  <p>{{ $faq->answer }}</p>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
   </div>
</div>
@endsection