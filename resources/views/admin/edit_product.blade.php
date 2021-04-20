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
            <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ url('/admin/edit-product/'.$productDetails->id) }}" name="add_product" id="add_product" novalidate="novalidate"> {{ csrf_field() }}
              @if($errors->any())
                <div class="alert alert-danger">
                  @foreach($errors->all() as $error)
                    {{ $error }} <br>
                  @endforeach
                </div>
              @endif
              <div class="form-group">
                <label class="control-label col-md-2 col-sm-2 col-xs-12">Under Category</label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                  <select name="category_id" id="category_id" class="form-control">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                      <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              @php  $espresso_note = explode(',', $productDetails->espresso_notes); 
                    $filtered_note = explode(',', $productDetails->filtered_notes); 
                    $certifications = explode(',', $productDetails->certificate_id); 
              @endphp 
              <div class="item form-group">
                <label class="control-label col-md-2 col-sm-2 col-xs-12">Espresso Notes<span class="required">*</span></label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                  <div class="row">
                    @foreach($espresso_notes as $e)
                    <div class="col-md-3">
                      <label><input type="checkbox" name="espresso_notes[]" value="{{ $e->name }}" @if(in_array($e->name, $espresso_note)) checked="checked" @endif>{{ $e->name }}</label>
                    </div>
                    @endforeach
                  </div>
                </div>
              </div>
              <div class="item form-group">
                <label class="control-label col-md-2 col-sm-2 col-xs-12">Filtered Notes<span class="required">*</span></label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                  <div class="row">
                    @foreach($filtered_notes as $f)
                    <div class="col-md-3">
                      <label><input type="checkbox" name="filtered_notes[]" value="{{ $f->name }}" @if(in_array($f->name, $filtered_note)) checked="checked" @endif>{{ $f->name }}</label>
                    </div>
                    @endforeach
                  </div>
                </div>
              </div>
              <div class="item form-group">
                <label class="control-label col-md-2 col-sm-2 col-xs-12">Process<span class="required">*</span></label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                  <select name="process_id" id="process_id" class="form-control" required="required">
                    <option value="">Select Process</option>
                    @foreach($processes as $p)
                      <option value="{{ $p->id }}">{{ $p->process_name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="item form-group">
                <label class="control-label col-md-2 col-sm-2 col-xs-12">Variety<span class="required">*</span></label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                  <select name="variety_id" id="variety_id" class="form-control" required="required">
                    <option value="">Select Variety</option>
                    @foreach($varieties as $v)
                      <option value="{{ $v->id }}">{{ $v->variety_name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="item form-group">
                <label class="control-label col-md-2 col-sm-2 col-xs-12">Certificate<span class="required">*</span></label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                  <select name="certificate_id[]" id="certificate_id" multiple="multiple" class="form-control" required="required">
                    @foreach($certificates as $c)
                      <option value="{{ $c->id }}" @if(in_array($c->id, $certifications)) selected="selected" @endif>{{ $c->certificate_name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="item form-group">
                <label class="control-label col-md-2 col-sm-2 col-xs-12">Country<span class="required">*</span></label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                  <select name="country" id="country" class="form-control" required="required">
                    <option value="">Select Country</option>
                    @foreach(getAllCountries() as $country)
                      <option value="{{ $country }}">{{ $country }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="item form-group">
                  <label class="control-label col-md-2 col-sm-2 col-xs-12" for="title">Region <span class="required">*</span>
                  </label>
                  <div class="col-md-7 col-sm-7 col-xs-12">
                      <input type="text" name="region" required="required" class="form-control col-md-7 col-xs-12" value="{{ $productDetails->region }}" />
                  </div>
              </div>
              <div class="item form-group">
                  <label class="control-label col-md-2 col-sm-2 col-xs-12" for="title">Product Name <span class="required">*</span>
                  </label>
                  <div class="col-md-7 col-sm-7 col-xs-12">
                      <input type="text" name="product_name" required="required" class="form-control col-md-7 col-xs-12" value="{{ $productDetails->product_name }}" />
                  </div>
              </div>
              <div class="item form-group">
                  <label class="control-label col-md-2 col-sm-2 col-xs-12" for="title">Bag Size<span class="required">*</span>
                  </label>
                  <div class="col-md-7 col-sm-7 col-xs-12">
                      <input type="text" name="bag_size" required="required" class="form-control col-md-7 col-xs-12" value="{{ $productDetails->bag_size }}" />
                  </div>
              </div>
              <div class="item form-group">
                  <label class="control-label col-md-2 col-sm-2 col-xs-12" for="title">Price<span class="required">*</span>
                  </label>
                  <div class="col-md-7 col-sm-7 col-xs-12">
                      <input type="text" name="price" required="required" class="form-control col-md-7 col-xs-12" value="{{ $productDetails->price }}" />
                  </div>
              </div>
              <div class="item form-group">
                  <label class="control-label col-md-2 col-sm-2 col-xs-12" for="title">Altitude<span class="required">*</span>
                  </label>
                  <div class="col-md-7 col-sm-7 col-xs-12">
                      <input type="text" name="altitude" required="required" class="form-control col-md-7 col-xs-12" value="{{ $productDetails->altitude }}" />
                  </div>
              </div>
              <div class="item form-group">
                  <label class="control-label col-md-2 col-sm-2 col-xs-12" for="title">Score <span class="required">*</span>
                  </label>
                  <div class="col-md-7 col-sm-7 col-xs-12">
                      <input type="text" name="score" required="required" class="form-control col-md-7 col-xs-12" value="{{ $productDetails->score }}" />
                  </div>
              </div>
              <div class="item form-group">
                  <label class="control-label col-md-2 col-sm-2 col-xs-12" for="title">Cupping Notes<span class="required">*</span>
                  </label>
                  <div class="col-md-7 col-sm-7 col-xs-12">
                      <input type="text" name="cupping_notes" required="required" class="form-control col-md-7 col-xs-12" value="{{ $productDetails->cupping_notes }}" />
                  </div>
              </div>
              <div class="item form-group">
                  <label class="control-label col-md-2 col-sm-2 col-xs-12" for="title">Sample Size<span class="required">*</span>
                  </label>
                  <div class="col-md-7 col-sm-7 col-xs-12">
                      <input type="text" name="sample_size" required="required" class="form-control col-md-7 col-xs-12" value="{{ $productDetails->sample_size }}" />
                  </div>
              </div>
              <div class="item form-group">
                  <label class="control-label col-md-2 col-sm-2 col-xs-12" for="title">Sample Price<span class="required">*</span>
                  </label>
                  <div class="col-md-7 col-sm-7 col-xs-12">
                      <input type="text" name="sample_price" required="required" class="form-control col-md-7 col-xs-12" value="{{ $productDetails->sample_price }}" />
                  </div>
              </div>
              <div class="item form-group">
                  <label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">Description <span class="required">*</span>
                  </label>
                  <div class="col-md-7 col-sm-7 col-xs-12">
                      <textarea name="description" class="form-control col-md-7 col-xs-12">{{ $productDetails->description }}</textarea>
                  </div>
              </div>
              <div class="item form-group">
                  <label class="control-label col-md-2 col-sm-2 col-xs-12" for="title">Image<span class="required">*</span>
                  </label>
                  <div class="col-md-7 col-sm-7 col-xs-12">
                      <input type="file" name="image" class="form-control col-md-7 col-xs-12" value="" />
                  </div>
              </div>
              @if(!empty($productDetails->image))
              <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">&nbsp;</label>
                  <div class="col-md-9 col-sm-9 col-xs-12">
                      <img width="100px" height="100px" src="{{ asset('/images/admin/products/'.$productDetails->image) }}">
                  </div>
              </div>
              @endif

              <div class="item form-group">
                  <label class="control-label col-md-2 col-sm-2 col-xs-12" for="title">Header Image<span class="required">*</span>
                  </label>
                  <div class="col-md-7 col-sm-7 col-xs-12">
                      <input type="file" name="header_image" class="form-control col-md-7 col-xs-12" value="" />
                  </div>
              </div>
              @if(!empty($productDetails->header_image))
              <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">&nbsp;</label>
                  <div class="col-md-9 col-sm-9 col-xs-12">
                      <img width="100px" height="100px" src="{{ asset('/images/admin/products/'.$productDetails->header_image) }}">
                  </div>
              </div>
              @endif

              <div class="item form-group">
                  <label class="control-label col-md-2 col-sm-2 col-xs-12" for="title">Map<span class="required">*</span>
                  </label>
                  <div class="col-md-7 col-sm-7 col-xs-12">
                      <input type="file" name="map" class="form-control col-md-7 col-xs-12" value="" />
                  </div>
              </div>
              @if(!empty($productDetails->map))
              <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">&nbsp;</label>
                  <div class="col-md-9 col-sm-9 col-xs-12">
                      <img width="100px" height="100px" src="{{ asset('/images/admin/products/'.$productDetails->map) }}">
                  </div>
              </div>
              @endif
              <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
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
<script type="text/javascript">
  document.add_product.category_id.value = '{{ $productDetails->category_id }}';
  document.add_product.process_id.value = '{{ $productDetails->process_id }}';
  document.add_product.variety_id.value = '{{ $productDetails->variety_id }}';
  document.add_product.country.value = '{{ $productDetails->country }}';
  $(document).ready(function(){
      $("#certificate_id").select2({
          placeholder: "Select Certifications",
          tags: true,
          allowClear: true
      });
  });
</script>

@endsection