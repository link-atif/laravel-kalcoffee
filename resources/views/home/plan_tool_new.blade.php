@extends('layouts.homelayout.front_design')
@section('content')       
<div class="inner_pages_title">
  <div class="container">
    <div class="courses_title">
      <img src="{{ asset('frontend/images/heading_seperater.png') }}" alt="">
      <h6>Plan <br>Tool</h6>
      <div class="border_line"></div>
    </div>
  </div>
</div>
<div class="container">
  <div class="contact_section resiter_sec">
    <div class="register_inner">
      <div class="col-md-5 padd_0">
        <div class="regiter_left traine_left">
          <img src="{{ asset('frontend/images/plan_tool.png') }}" alt="">
        </div>
      </div>
      <div class="col-md-7 padd_0">
        <div class="contact_right">              
          <div class="contact_right_col">
            <form id="frm" name="frm" action="{{ route('plan.solution') }}" method="post">{{ csrf_field() }}
              <div class="alert alert-danger" id="alert-block" style="display: none">
                  <strong id="error"></strong><br>
              </div>
              <input type="hidden" name="type" value="new">
              <div class="traine_sec">
                <div class="traine_quantity">
                  <h6>1. Capacity </h6>
                  <p>How many chairs are available in your cafe?</p>
                  <div class="col-md-6 padd_0">
                    <input type="text" class="form-control" placeholder="Enter h ere">
                  </div>
                </div>                 
                <div class="traine_quantity">
                  <h6>2. Espresso Notes</h6>
                  <p>What are your preferred notes for Espresso?</p>
                  <div class="form_select_option_col">
                    <p>
                      @foreach($espresso_notes as $e)
                      <label><input type="checkbox" name="espresso_notes[]" value="{{ $e->name }}"> {{ $e->name }}</label>
                      @endforeach
                    </p>
                  </div>                   
                </div>
                <div class="traine_quantity">
                  <h6>2. Filtered Coffee Notes</h6>
                  <p>What are your preferred notes for Filtered Coffee?</p>
                  <div class="form_select_option_col">
                    <p>
                      @foreach($filtered_notes as $f)
                      <label><input type="checkbox" name="filtered_notes[]" value="{{ $f->name }}"> {{ $f->name }}</label>
                      @endforeach
                    </p>
                  </div>                   
                </div>

                <a href="javascript:{}" onclick="validate();" class="margin_t_0">NEXT</a>
              </div>
            </form>
          </div>             
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
  function validate(){
    if(($('input[name^=espresso_notes]:checked').length <= 0) || ($('input[name^=filtered_notes]:checked').length <= 0)) {
        $("#alert-block").show();
        $("#error").html("<h5>At least 1 espresso note and 1 filtered note should be selected.</h5>");
        return false;
    }
    else{
        $('#frm').submit();
    }
  }
</script>
@endsection