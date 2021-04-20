@extends('layouts.adminlayout.admin_design')
@section('content')
<div class="">
	<div class="row top_tiles">
	 	<div class="row">
			<div class="col-md-12">
				<h3>Contact Queries</h3>
				<table id="example" class="table table-striped responsive-utilities jambo_table">
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