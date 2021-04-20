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
            <form class="form-horizontal" name="frm" id="frm" action="{{ route('update.plan', $plans->id) }}" method="post" novalidate="novalidate"> {{ csrf_field() }}
              {{ method_field('put') }}
              @if($errors->any())
                <div class="alert alert-danger">
                  @foreach($errors->all() as $error)
                    {{ $error }} <br>
                  @endforeach
                </div>
              @endif
              <div class="item form-group">
                <label class="control-label col-md-2 col-sm-2 col-xs-12">User Type<span class="required">*</span></label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                  <select name="type" id="type" class="form-control" required="required">
                    <option value="">Select User Type</option>
                    <option value="new" >New Cafe</option>
                    <option value="roastery">Roastery</option>
                  </select>
                </div>
              </div>
              <div class="item form-group">
                <label class="control-label col-md-2 col-sm-2 col-xs-12">Under Category<span class="required">*</span></label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                  <select name="category_id" id="category_id" onchange="loadProducts(this)" class="form-control" required="required">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                      <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              @php  $notes = explode(',', $plans->notes); @endphp 
              <div class="item form-group">
                <label class="control-label col-md-2 col-sm-2 col-xs-12">Notes<span class="required">*</span></label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                  <div class="row">
                    <div class="col-md-3">
                      <label><input type="checkbox" name="notes[]" value="nutty" @if(in_array("nutty", $notes)) checked="checked" @endif> Nutty</label>
                    </div>
                    <div class="col-md-3">
                      <label><input type="checkbox" name="notes[]" value="sweet fruit" @if(in_array("sweet fruit", $notes)) checked="checked" @endif> Sweet Fruit</label>
                    </div>
                    <div class="col-md-3">
                      <label><input type="checkbox" name="notes[]" value="earthy/savory" @if(in_array("earthy/savory", $notes)) checked="checked" @endif> Earthy / Savory</label>
                    </div>
                    <div class="col-md-3">
                      <label><input type="checkbox" name="notes[]" value="chocolate" @if(in_array("chocolate", $notes)) checked="checked" @endif> Chocolate</label>
                    </div>
                    <div class="col-md-3">
                      <label><input type="checkbox" name="notes[]" value="tart fruit" @if(in_array("tart fruit", $notes)) checked="checked" @endif> Tart Fruit</label>
                    </div>
                    <div class="col-md-3">
                      <label><input type="checkbox" name="notes[]" value="floral" @if(in_array("floral", $notes)) checked="checked" @endif> Floral</label>
                    </div>
                    <div class="col-md-3">
                      <label><input type="checkbox" name="notes[]" value="berry/cherry/raisin" @if(in_array("berry/cherry/raisin", $notes)) checked="checked" @endif> Berry / Cherry / Raisin</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="item form-group">
                <label class="control-label col-md-2 col-sm-2 col-xs-12">Recommendations<span class="required">*</span></label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                  <select name="recommendation" id="recommendation" class="form-control" required="required">
                    <option value="">Select Products</option>
                    @foreach($products as $p)
                      <option value="{{ $p->id }}">{{ $p->product_name }}</option>
                    @endforeach
                  </select>
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
<script type="text/javascript">
  $(document).ready(function(){
    $("#category_id").val('{{ $plans->category_id }}');
    $("#type").val('{{ $plans->type }}');
    $("#recommendation").val('{{ $plans->recommendation }}');
  });
</script>
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
<script type="text/javascript">
  function loadProducts(x){
    $("#recommendation").find('option').remove().end();
    var url = "{{ route('load.products') }}";
    var id  = $(x).val();
    $.post(url, {'_token' : '{{ csrf_token() }}', id: id }, function(response){
      if(response!=false){
        $("#recommendation").append($('<option>', {value: "", text: "Select Product" }));
        $.each(response, function(i,v){
            $("#recommendation").append($('<option>', {value: v.id, text: v.product_name }));
        });
      }
    });
  }
</script>
@endsection