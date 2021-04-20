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
            <form enctype="multipart/form-data" class="form-horizontal" method="post" name="frm" id="frm" novalidate="novalidate"> {{ csrf_field() }}
              @if($errors->any())
                <div class="alert alert-danger">
                  @foreach($errors->all() as $error)
                    {{ $error }} <br>
                  @endforeach
                </div>
              @endif
              <input type="hidden" name="id" value="{{ $user->id }}" style="border: none;">
              <div class="item form-group">
                  <label class="control-label col-md-2 col-sm-2 col-xs-12" for="title">Name <span class="required">*</span>
                  </label>
                  <div class="col-md-7 col-sm-7 col-xs-12">
                      <input type="text" name="name" required="required" class="form-control col-md-7 col-xs-12" value="{{ $user->name }}" style="border: none;" />
                  </div>
              </div>
              <div class="item form-group">
                  <label class="control-label col-md-2 col-sm-2 col-xs-12" for="title">Contact Name
                  </label>
                  <div class="col-md-7 col-sm-7 col-xs-12">
                      <input type="text" name="contact_name" class="form-control col-md-7 col-xs-12" value="{{ $user->contact_name }}" style="border: none;"/>
                  </div>
              </div>
              <div class="item form-group">
                  <label class="control-label col-md-2 col-sm-2 col-xs-12" for="title">Email<span class="required">*</span>
                  </label>
                  <div class="col-md-7 col-sm-7 col-xs-12">
                      <input type="text" name="email" required="required" readonly="readonly" class="form-control col-md-7 col-xs-12" value="{{ $user->email }}" />
                  </div>
              </div>
              <div class="item form-group">
                  <label class="control-label col-md-2 col-sm-2 col-xs-12" for="title">Phone Number<span class="required">*</span>
                  </label>
                  <div class="col-md-7 col-sm-7 col-xs-12">
                      <input type="text" name="phone_number" required="required" class="form-control col-md-7 col-xs-12" value="{{ $user->phone_number }}" style="border: none;"/>
                  </div>
              </div>
              
              <div class="item form-group">
                  <label class="control-label col-md-2 col-sm-2 col-xs-12" for="title">Address 1</label>
                  <div class="col-md-7 col-sm-7 col-xs-12">
                      <input type="text" name="address_1" value="{{ $user->address_1 }}" style="border: none;"/>
                  </div>
              </div>
              <div class="item form-group">
                  <label class="control-label col-md-2 col-sm-2 col-xs-12" for="title">Address 2</label>
                  <div class="col-md-7 col-sm-7 col-xs-12">
                      <input type="text" name="address_2" required="required" class="form-control col-md-7 col-xs-12" value="{{ $user->address_2 }}" style="border: none;"/>
                  </div>
              </div>
              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">
                  <button type="submit" class="btn btn-Info"><a href="{{ route('admin.back')}}">Back</a></button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="clear"></div>                
    </div>

@endsection