@extends('layouts.adminlayout.admin_design')
@section('content')
<div role="main">
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
	<div class="row top_tiles">
		<div class="page-title">
	        <div class="title_left">
	            <h3>Order Detail</h3>
	        </div>
	    </div>
	        
		<form class="pull-right" method="post" action="{{ route('order.status') }}">{{ csrf_field() }}
			<label >Status:</label>
			<input type="hidden" name="order_id" value="{{ $details->id }}">
		  	<select id="status" name="status">
			    <option value="pending">Pending</option>
			    <option value="approved">Approved</option>
			    <option value="cancel">Cancel</option>
			    <option value="complete">Complete</option>
		    </select>
		    <button type="submit" value="submit">Submit</button>
		</form>			 
		<div class="row">
			<div class="col-md-12">
				<table class="table table-striped responsive-utilities jambo_table">
					<tr>
						<th class="headings">Name</th>
						<td>{{ $details->name }}</td>
						<th class="headings">Email</th>
						<td>{{ $details->user_email }}</td>
					</tr>
					<tr>
						<th class="headings">Phone</th>
						<td>{{ $details->mobile }}</td>
						<th class="headings">Discount Code</th>
						<td>{{ $details->coupon_code }}</td>
					</tr>
					<tr>
						<th class="headings">Payment Method</th>
						<td>{{ $details->payment_method }}</td>
						<th class="headings">Total</th>
						<td>{{ $details->grand_total }} SAR</td>
					</tr>
					<tr>
						<th class="headings">Discount Amount</th>
						<td>{{ $details->coupon_amount }}</td>
						<th class="headings">Status</th>
						<td>{{ $details->status }}</td>
					</tr>
				</table>
				@if($details->type == "coffee")
				<table id="example" class="table table-striped responsive-utilities jambo_table">
					<thead>
						<tr class="headings">
							<th>Product Name</th>
							<th>Product price</th>
							<th>Product Quantity</th>
							<th class=" no-link last"><span class="nobr">Total</span>
							</th>
						</tr>
					</thead>
					<tbody>
					@foreach($details->order_details as $d)
						<tr class="odd pointer">
							<td class=" ">{{ $d->product_name }}</td>
							<td class=" ">{{ $d->price }} SAR</td>
							<td>{{ $d->quantity }}</td>
							<td class=" last">
								{{ $d->price*$d->quantity }}
							</td>
						</tr>
					@endforeach
						<tr>
							<td colspan="3" align="right"><b>Total</b></td>
							<td>{{ $details->grand_total }} SAR</td>
						</tr>	
					</tbody>
				</table>
				@endif
				@if($details->type == "training")
				<table id="example" class="table table-striped responsive-utilities jambo_table">
					<thead>
						<tr class="headings">
							<th>Course Name</th>
							<th>Level</th>
							<th>Level Duration</th>
							<th>Schedule Date</th>
							<th>Price</th>
							</th>
						</tr>
					</thead>
					<tbody>
					@foreach($details->order_details as $d)
					@php 
						$level_name = App\Level::where('id', $d->level_id)->pluck('name')->first();
                  		$level_duration = App\Level::where('id', $d->level_id)->pluck('duration')->first();
					@endphp
						<tr class="odd pointer">
							<td class=" ">{{ $d->product_name }}</td>
							<td class=" ">{{ $level_name }}</td>
							<td class=" ">{{ $level_duration }}</td>
							<td>{{ Carbon\Carbon::parse($d->schedule_date)->format('d F Y') }}</td>
							<td class=" ">{{ $d->price }}</td>
						</tr>
					@endforeach
						<tr>
							<td colspan="3" align="right"><b>Total</b></td>
							<td>{{ $details->grand_total }} SAR</td>
						</tr>	
					</tbody>
				</table>
				@endif
			</div>
		</div> 
	</div>
</div>
@endsection
@section('script')
<script type="text/javascript">
$(document).ready(function(){
	$("#status").val('{{ $details->order_status }}');
    /*$("select.status").change(function(){
        var selectedstatus = $(this).children("option:selected").val();
    });*/
});
</script>
@endsection