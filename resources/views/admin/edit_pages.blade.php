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
            <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ url('/admin/edit-pages/'.$pagesDetails->id) }}" name="frm" id="frm" novalidate="novalidate"> {{ csrf_field() }}
              @if($errors->any())
                <div class="alert alert-danger">
                  @foreach($errors->all() as $error)
                    {{ $error }} <br>
                  @endforeach
                </div>
              @endif
              <div class="form-group">
                <label class="control-label col-md-2 col-sm-2 col-xs-12">Type</label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                  <select name="type" id="type" class="form-control">
                      <option value="coffee">Coffee</option>
                      <option value="company">Company</option>
                      <option value="quick_links">Quick Links</option>
                      <option value="other">Other</option>
                  </select>
                </div>
                <script type="text/javascript">
                  document.frm.type.value = '{{ $pagesDetails->type }}';
                </script>
              </div>
              <div class="item form-group">
                  <label class="control-label col-md-2 col-sm-2 col-xs-12" for="title">Title <span class="required">*</span>
                  </label>
                  <div class="col-md-7 col-sm-7 col-xs-12">
                      <input type="text" name="title" required="required" class="form-control col-md-7 col-xs-12" value="{{ $pagesDetails->title }}" />
                  </div>
              </div>
              <div class="item form-group">
                  <label class="control-label col-md-2 col-sm-2 col-xs-12" for="title">Sort Order
                  </label>
                  <div class="col-md-7 col-sm-7 col-xs-12">
                      <input type="text" name="sort_order" class="form-control col-md-7 col-xs-12" value="{{ $pagesDetails->sort_order }}" />
                  </div>
              </div>
              <div class="item form-group">
                  <label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">Description <span class="required">*</span>
                  </label>
                  <div class="col-md-7 col-sm-7 col-xs-12">
                      <textarea name="body" class="form-control col-md-7 col-xs-12" required="required">{{ $pagesDetails->body }}</textarea>
                  </div>
              </div>
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
<script type="text/javascript" src="{{ asset('js/admin_js/tinymce/tinymce.min.js') }}"></script>
<script type="text/javascript">

$(document).ready(function() {
    tinymce.init({
        selector: "textarea",
        theme: "modern",
        paste_data_images: true,
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern"
        ],
        toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
        toolbar2: "print preview media | forecolor backcolor emoticons",
        image_advtab: true,
        file_picker_callback: function(callback, value, meta) {
            if (meta.filetype == 'image') {
                $('#upload').trigger('click');
                $('#upload').on('change', function() {
                    var file = this.files[0];
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        callback(e.target.result, {
                            alt: ''
                        });
                    };
                    reader.readAsDataURL(file);
                });
            }
        },
        templates: [{title: 'Test template 1',content: 'Test 1'}, {title: 'Test template 2',content: 'Test 2'}]
    });
});
</script>
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

@endsection