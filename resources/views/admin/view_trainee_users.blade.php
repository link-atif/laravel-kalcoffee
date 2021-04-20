@extends('layouts.adminlayout.admin_design')
@section('content')
<!-- page content -->
  <div role="main">
    <div class="x_content content">
      <div class="page-title">
        <div class="title_left">
            <h3>{{ $page_title }}</h3>
        </div>
        <div class="title_right">
          <form name="frm" action="{{ route('search.trainee') }}" id="frm">
            <div class="col-md-10 col-sm-5 col-xs-12 pull-right top_search">
              <div class="col-md-5 col-sm-5 col-xs-12 pull-right top_search">
                <div class="input-group">
                  <input type="text" class="form-control" name="name" value="{{ (Request::input('name'))?? "" }}" placeholder="Search User..." value="">
                  <span class="input-group-btn">
                    <button class="btn btn-default" type="submit">Go!</button>
                  </span>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="clearfix"></div>
      @if(Session::has('flash_message_error'))
        <div class="alert alert-error alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button> 
                <strong>{!! session('flash_message_error') !!}</strong>
        </div>
      @endif   
      @if(Session::has('flash_message_success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button> 
                <strong>{!! session('flash_message_success') !!}</strong>
        </div>
      @endif
      <div class="table-responsive">
        <table id="example" class="table table-striped responsive-utilities jambo_table">
          <thead>
            <tr class="headings">
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Phone Number</th>
              <th>Interests</th>
              <th>Address</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($users as $f)
            <tr class="gradeX">
              <td>{{ $f->id }}</td>
              <td>{{ $f->name }}</td>
              <td>{{ $f->email }}</td>
              <td>{{ $f->phone_number }}</td>
              <td>{{ $f->interests }}</td>
              <td>{{ $f->address_1 }}</td>
              <td class="center"><a href="{{ url('/admin/edit-trainee-user/'.$f->id) }}" class="btn btn-primary btn-sm">Edit</a> <a id="delCat" href="{{ url('/admin/delete-user/'.$f->id) }}" class="btn btn-danger btn-sm">Delete</a></td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <p>{{ $users->links() }}</p>    
    </div>
    <div class="clear"></div>
  </div>
@endsection