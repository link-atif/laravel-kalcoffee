@extends('layouts.adminlayout.admin_design')
@section('content')
    <div role="main">
      <div class="x_content content">
        <div class="page-title">
            <div class="title_left">
                <h3>{{ $page_title }}</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="x_content">
          <div class="x_panel">
            <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ url('/admin/edit-schedule/'.$detail->id) }}" name="frm" id="frm" novalidate="novalidate"> {{ csrf_field() }}
              @if($errors->any())
                <div class="alert alert-danger">
                  @foreach($errors->all() as $error)
                    {{ $error }} <br>
                  @endforeach
                </div>
              @endif
              <div class="item form-group">
                <label class="control-label col-md-2 col-sm-2 col-xs-12">Under Training Course<span class="required">*</span></label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                  <select name="course_id" id="course_id" class="form-control" required="required" onchange="loadLevels(this)">
                    <option value="">Select Course</option>
                    @foreach($courses as $c)
                      <option value="{{ $c->id }}">{{ $c->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="item form-group">
                <label class="control-label col-md-2 col-sm-2 col-xs-12">Under Level<span class="required">*</span></label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                  <select name="level_id" id="level_id" class="form-control" required="required">
                    <option value="">Select Level</option>
                    @foreach($levels as $l)
                      <option value="{{ $l->id }}">{{ $l->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="item form-group">
                <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">Date<span class="required">*</span></label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                  <input id="schedule_date" name="schedule_date" class="form-control" type="date" value="{{ $detail->schedule_date }}" />                                            
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  <button type="submit" class="btn btn-success">Submit</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="clear"></div>                
    </div>
<script src="{{ asset('js/admin_js/validator/validator.js') }}"></script>
<script>
    // initialize the validator function
    validator.message['date'] = 'not a real date';

    // validate a field on "blur" event, a 'select' on 'change' event & a '.reuired' classed multifield on 'keyup':
    $('form')
        .on('blur', 'input[required], input.optional, select.required', validator.checkField)
        .on('change', 'select.required', validator.checkField)
        .on('keypress', 'input[required][pattern]', validator.keypress);

    $('.multi.required')
        .on('keyup blur', 'input', function () {
            validator.checkField.apply($(this).siblings().last()[0]);
        });

    // bind the validation to the form submit event
    //$('#send').click('submit');//.prop('disabled', true);

    $('form').submit(function (e) {
        e.preventDefault();
        var submit = true;
        // evaluate the form using generic validaing
        if (!validator.checkAll($(this))) {
            submit = false;
        }

        if (submit)
            this.submit();
        return false;
    });

    /* FOR DEMO ONLY */
    $('#vfields').change(function () {
        $('form').toggleClass('mode2');
    }).prop('checked', false);

    $('#alerts').change(function () {
        validator.defaults.alerts = (this.checked) ? false : true;
        if (this.checked)
            $('form .alert').remove();
    }).prop('checked', false);
</script>
<script>
    $(document).ready(function(){
      $("#course_id").val('{{ $detail->course_id }}');
      $("#level_id").val('{{ $detail->level_id }}');
    });
    $('#schedule_date').datepicker({
      format : 'mm-dd-yyyy'
    });
</script>
<script type="text/javascript">
    function loadLevels(x){
        $("#level_id").find('option').remove().end();
        var url = "{{ route('loadLevel') }}";
        var id  = $(x).val();
        $.post(url, {'_token' : '{{ csrf_token() }}', id: id }, function(response){
            if(response!=false){
                //var response = JSON.parse(response);
                //console.log(response);
                $("#level_id").append($('<option>', {value: "", text: "Select Level" }));
                $.each(response, function(i,v){
                    $("#level_id").append($('<option>', {value: v.id, text: v.name }));
                });
            }
        });
    }
</script>
@endsection