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
            <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{route('update.trainer',$details->id)}}" name="frm" id="frm" novalidate="novalidate"> {{ csrf_field() }}
              @if($errors->any())
                <div class="alert alert-danger">
                  @foreach($errors->all() as $error)
                    {{ $error }} <br>
                  @endforeach
                </div>
              @endif
              <input type="hidden" name="id" value="{{ $details->id }}">
              <div class="item form-group">
                  <label class="control-label col-md-2 col-sm-2 col-xs-12" for="title">Name <span class="required">*</span>
                  </label>
                  <div class="col-md-7 col-sm-7 col-xs-12">
                      <input type="text" name="name" required="required" class="form-control col-md-7 col-xs-12" value="{{ $details->name }}" />
                  </div>
              </div>
              <div class="item form-group">
                  <label class="control-label col-md-2 col-sm-2 col-xs-12" for="title">Contact Name
                  </label>
                  <div class="col-md-7 col-sm-7 col-xs-12">
                      <input type="text" name="contact_name" class="form-control col-md-7 col-xs-12" value="{{ $details->contact_name }}" />
                  </div>
              </div>
              <div class="item form-group">
                  <label class="control-label col-md-2 col-sm-2 col-xs-12" for="title">Email<span class="required">*</span>
                  </label>
                  <div class="col-md-7 col-sm-7 col-xs-12">
                      <input type="text" name="email" required="required" readonly="readonly" class="form-control col-md-7 col-xs-12" value="{{ $details->email }}" />
                  </div>
              </div>
              <div class="item form-group">
                  <label class="control-label col-md-2 col-sm-2 col-xs-12" for="title">Phone Number<span class="required">*</span>
                  </label>
                  <div class="col-md-7 col-sm-7 col-xs-12">
                      <input type="text" name="phone_number" required="required" class="form-control col-md-7 col-xs-12" value="{{ $details->phone_number }}" />
                  </div>
              </div>
              <div class="item form-group">
                  <label class="control-label col-md-2 col-sm-2 col-xs-12" for="title">Password<span class="required">*</span>
                  </label>
                  <div class="col-md-7 col-sm-7 col-xs-12">
                      <input type="password" name="password" id="password" disabled="disabled" class="form-control col-md-7 col-xs-12" />
                      <a href="javascript:" class="change_pass_btn" onclick="changePassword()">Change Password</a>
                  </div>
              </div>
              <div class="item form-group">
                  <label class="control-label col-md-2 col-sm-2 col-xs-12" for="title">Address 1</label>
                  <div class="col-md-7 col-sm-7 col-xs-12">
                      <input type="text" name="address_1" class="form-control col-md-7 col-xs-12" value="{{ $details->address_1 }}" />
                  </div>
              </div>
              <div class="item form-group">
                  <label class="control-label col-md-2 col-sm-2 col-xs-12" for="title">Address 2</label>
                  <div class="col-md-7 col-sm-7 col-xs-12">
                      <input type="text" name="address_2" required="required" class="form-control col-md-7 col-xs-12" value="{{ $details->address_2 }}" />
                  </div>
              </div>
              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">
                  <button type="submit" class="btn btn-success">Update</button>
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
  function changePassword(){
    $('#password').attr('disabled',!$("#password").attr('disabled'));
  }
</script>
@endsection