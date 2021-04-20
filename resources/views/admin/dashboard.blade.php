@extends('layouts.adminlayout.admin_design')
@section('content')
<style type="text/css">
    button{
           background-color:#2A3F54; 
           margin:2%;
           padding:60px; 
           height: 90px;
           width: 23%;
		}
	a{
       color: white;
	}
</style>
<div class="">
	<div class="row top_tiles">
	 	<div class="row">
			<div class="col-md-12">
				<h3>Dashboard </h3><br><br>
				<div class="container">
				  <button type="button" class="btn" style="margin-left:13%;"><a href="{{route('view.orders')}}">Order</a></button>
				  <button type="button" class="btn  btn-lg"><a href="{{route('show.trainee')}}">Trainers</a></button>    
				  <button type="button" class="btn  btn-lg"><a href="{{route('view.courses')}}">Courses</a></button>
				</div>
                <div class="container">
                  <button type="button" class="btn  btn-lg" style="margin-left:13%;"><a href="{{route('view.orders')}}">Inovices</a></button>
                  <button type="button" class="btn  btn-lg"><a href="{{route('view.users')}}">Clients</a></button>    
                  <button type="button" class="btn  btn-lg"><a href="{{route('attendies.show')}}">Traninig Details</a></button>
                </div>
                <div class="container">
                  <button type="button" class="btn  btn-lg" style="margin-left:13%;"><a href="{{route('view.orders')}}">Large</a></button>
                  <button type="button" class="btn  btn-lg"><a href="{{route('/')}}">Home Page</a></button>
                </div><br><br>
                    <h3>Contact Queries</h3>
				    <table id="example" class="table table-striped responsive-utilities  jambo_table">
						<thead>
							<tr class="headings">
								<th>Name</th>
								<th>Email</th>
								<th>Phone</th>
								<th>Entity Age</th>
								<th>Dealing As</th>
								<th>Detail</th>
								</th>
							</tr>
						</thead>
						<tbody>
				          	@foreach($contacts as $c)
				            <tr class="odd pointer">
				              <td>{{ $c->full_name }}</td>
				              <td>{{ $c->email }}</td>
				              <td>{{ $c->contact }}</td>
				              <td>{{ $c->entity_age }}</td>
				              <td>{{ $c->dealing_as }}</td>
				              <td>{!! substr(strip_tags($c->message),0,80) !!}</td>
				            </tr>
				          	@endforeach
			          	</tbody>
				   </table>
			    </div>
			<p>{{ $contacts->links() }}</p>
		</div>
	</div> 
</div>
@endsection