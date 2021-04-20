@extends('layouts.homelayout.front_design')
@section('content')
<style type="text/css">
  @media screen and (min-width: 768px) {
  .modal-dialog { 
    width: 70%; 


  }
</style>
<div class="inner_pages_title">
  <div class="container">
    <div class="courses_title">
    <!--   <h6>Details</h6><a href="javascript:" class="update_btn_db" onclick="order()" style="float: right;">Order</a> -->

    </div>

  </div>
</div>
<div class="container">
  @include('home.partials.message')
  @if($errors->any())
      <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">x</button>
        @foreach($errors->all() as $error)
          <strong>{{ $error }}</strong><br>
        @endforeach
      </div>
  @endif

  <div class="cart_section_main">
 
    <div class="col-md-12">
      <div class="cart_left_col">

        <div class="cart_resposive_mobile">
          <table class="table" style="text-align: center;">
            <thead>
              <tr>             
                <th>Product Name</th>
                <th>Product Code</th>  
                <th>Price</th>
                <th>Quantity</th>
                <th>Remaining Quantity</th>
                <th>Bag Size</th>
                <th>Action</th>
                <th></th>
              </tr>
            </thead>
            <tbody>  

            @if(isset($orders))   
              
            @foreach($orders as $d)
            @php $remaining = App\order_item_requested::where('user_id', \Auth::user()->id)->where('order_id', $d->order_id)->where('product_id', $d->product_id)->orderBy('id', 'desc')->pluck('remaining')->first(); 
            
            @endphp
           <tr >                       
              <td style="text-align: left;"><span style="cursor: pointer;">{{$d->product_name}}</span></td>
              <td >{{$d->product_code}}</td>  
              <td>{{$d->price}}</td>
              <td>{{$d->quantity}}</td>
              <td>@if($remaining =="") {{$rem=$d->quantity}} @else {{ $rem=$remaining }} @endif</td>
              <td>{{$d->bag_size}}</td>
              <td> <a href="javascript:;"  onclick="order('{{ $d->product_id }}','{{ $d->product_name }}','{{ $d->quantity }}','@if($remaining =="") {{$rem=$d->quantity}} @else {{ $rem=$remaining }} @endif','{{ $d->price }}','{{ $d->user_id }}','{{ $d->order_id }}')" class="btn btn-info btn-md">Order</a></td>   


            </tr>
            @endforeach

            @else
              <h2 style="color: blue; font-size: 40px;">All orders are take placed! </h2>
            @endif
            </tbody>
          </table>      
        </div>
     </div>
   </div>


<!-- Modal -->
    <div class="modal" id="orderDetail">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header courses_title" >
            <div >
              <h6>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Item Details </h6>
            </div>            
            </div>
            <div class="modal-body">
            <div id="msg"></div>
            <table class="table" style="text-align: center;">
              <thead>
                <tr style="color: #8D132A;">

                  <th>Product name</th>  
                  <!-- <th>Price</th> -->
                  <th>Quantity</th>
                  <th>Remaining Quantity</th>
                  <!-- <th>Totall Price</th> -->
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

                <tr style="text-align: center;">  
                 <form  method="post" action="{{route('store.itemquantity')}}" id="frm">
                 <input type="hidden" id="product_id" name="product_id">  
                 <input type="hidden" id="order_id" name="order_id">  
                 <input type="hidden" id="user_id" name="user_id">
                 <input type="hidden" id="price" name="price">  
                <input type="hidden" id="available" name="available">
                <input type="hidden" id="sub_total" name="sub_total">
                  {{csrf_field()}}           
                    <td style="text-align:left;"><span  ><input type="text" style="border: none;"  id="product_name" name="product_name"></span>
                    <!-- </td>
                    <td> -->
                                                
                        
                      </td>  
                      <td>
                        <input  type="text" name="quantity" id="quantity" onchange="updateQuantity()" class="form-control" value="" required="required">
                      </td>
                      <td>
                        <input style="border: none;" id="remaining" name="remaining" value="" readonly="readonly">

                      </td>
                        <td style="text-align: left;">
                        <a href="javascript:" class="btn btn-info" id="order_place" onclick="submitForm()">Order Place</a>  
                      </td>
                      <td>
                     
                   
                      </td>
                    
                  
                </tr>
                 </form>
            
            
                <script type="text/javascript">
                </script>
              </tbody>
            </table>
           
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" ><span onclick="document. getElementById('orderDetail').style.display='none'"class="w3-button w3-display-topright">Close</span>
            </button>
          </div>
        </div>
      </div>
    </div>

      <!-- /Order pop_up form -->  
    </div>
 
</div>
@endsection
@section('script') 


  <script type="text/javascript">

    function order(product_id,product_name,quantity,rem,price,user_id,order_id){   
    emptyModel()
    $("#product_id").val(parseInt(product_id));
    $("#product_name").val(product_name);
    $("#price").val(parseFloat(price));
    $("#available").val(parseInt(quantity));

   
    $("#user_id").val(parseInt(user_id));
    $("#order_id").val(parseInt(order_id));
    $("#remaining").val(parseInt(rem));
    $("#orderDetail").show();

   }
   function emptyModel(){
    $("#product_id").val("");
    $("#product_name").val("");
    $("#price").val("");
    $("#user_id").val("");
    $("#order_id").val("");
    $("#remaining").val("");
    $("#quantity").val("");
    $("#available").val("");
    $("#sub_total").val("");

    $("#msg").hide();
   }

   function updateQuantity(){
    var user_input = $("#quantity").val();
    var remaining = $("#remaining").val();
    var available = $("#available").val();
    if( parseInt(user_input) > parseInt(remaining)){      
      $("#msg").show();
      $("#msg").html('<h5 style="color:red">Remaining quantity is less than you requested!</h5>');
      return false;
    }
    $("#msg").hide();
    var price = $("#price").val();
    var total_remaining = parseInt(remaining) - parseInt(user_input);
    $("#remaining").val(total_remaining);
      var price = $("#price").val();   //product price
      var available = $("#available").val();  //Qunatity available
      var total = parseInt(user_input) * parseFloat(price);
      $("#sub_total").val(total); //SubTotall
  }
  
  </script>


  <script>
    function dismiss() { 
      $('$orderDetail').hide();
    }
  </script>


  <script type="text/javascript">
    function submitForm(x){

      $('#frm').submit();
      //alert("Form Submitted Successfully!");
    }
  </script>
  <script>
  // Get the modal
  var modal = document.getElementById('orderDetail');

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }
  </script>

@endsection