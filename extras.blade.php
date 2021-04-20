
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
            @php $remaining = App\order_item_requested::where('user_id', \Auth::user()->id)->where('order_id', $d->order_id)->where('product_id', $d->product_id)->orderBy('id', 'desc')->pluck('remaining')->first(); @endphp
           <tr >                       
              <td style="text-align: left;"><span onclick="order();" style="cursor: pointer;">{{$d->product_name}}</span></td>
              <td >{{$d->product_code}}</td>  
              <td>{{$d->price}}</td>
              <td>{{$d->quantity}}</td>
              <td>@if($remaining =="") {{$d->quantity}} @else {{ $remaining }} @endif</td>
              <td>{{$d->bag_size}}</td>
              <td> <a href="javascript:"  onclick="order()" class="btn btn-info btn-md">Order</a></td>   
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
                 @if(isset($orders))  
                <!-- @foreach($orders as $o) -->
                @php $m_remaining = App\order_item_requested::where('user_id', \Auth::user()->id)->where('order_id', $o->order_id)->where('product_id', $o->product_id)->orderBy('id', 'desc')->pluck('remaining')->first(); 
                $m_remaining = ($m_remaining != "") ? $m_remaining : $o->quantity; 
                @endphp
                <tr style="text-align: center;">  
                 <form  method="post" action="{{route('store.itemquantity')}}" id="frm_{{ $o->product_id }}" name="frm_{{ $o->product_id }}">  

                  {{csrf_field()}}           
                    <td style="text-align:left;"><span  >{{$o->product_name}}</span>
                    <!-- </td>
                    <td> -->
                        <input type="hidden" name="" id="dectection-{{$o->product_id}}" value="{{$m_remaining}}">
                        <input type="hidden" name="" id="price-{{$o->product_id}}" value="{{$o->price}}">
                        
                        <input type="hidden" name="user_id" value="{{$o->user_id}}">
                        <input type="hidden" name="order_id" value="{{$o->order_id}}">
                        <input type="hidden" name="product_id" value="{{$o->product_id}}">
                      </td>  
                      <td>
                        <input  type="text" name="quantity" id="quantity-{{$o->product_id}}" onchange="updateQuantity(this,{{$o->product_id}})" class="form-control" value="" required="required">
                      </td>
                      <td>
                        <input style="border: none;" id="remaining-{{$o->product_id}}" name="remaining" value="{{ $m_remaining }}" readonly="readonly">

                      </td>
                        <td style="text-align: left;">
                        <a href="javascript:" class="btn btn-info" id="order_place_{{ $o->product_id }}" onclick="submitForm('{{ $o->product_id }}')">Order Place</a>  
                      </td>
                      <td>
                      <input type="hidden" style="border: none;" id="total-{{ $o->product_id }}"  onchange="grandtotal" name="sub_total" value="{{$o->price}}" totall = "{{ $o->product_id }}"> 
                      <!-- <output  id="total" onchange="grandtotal" name="sub_total" value="{{$o->price}}">{{$o->price}}</output> -->
                      </td>
                    
                  
                </tr>
                 </form>
              <!--   @endforeach -->
                @endif
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
    function order(){     
      $("#orderDetail").show();
    } 
  </script>


  <script>   
   function updateQuantity(x,product_id){
      //alert($(x).val());
    var a = $("#quantity-"+product_id).val(); //Qunatity enter by client
    var d = $("#dectection-"+product_id).val();
    if(a > d){
      $("#msg").show();
      $("#msg").html('<h5 style="color:red">Remaining quantity is less than you requested!</h5>');
      return false;
    }
      
      $("#msg").hide();
      var b = $("#price-"+product_id).val();   //product price
      //var de = $("#dectection-"+product_id).val();  //Qunatity available
      var r=d-a;
      var c=a*b;
      $("#total-"+product_id).val(c);//SubTotall
      $("#remaining-"+product_id).val(r);//SubTotall
    }
  </script>


  <script>
    function dismiss() { 
      $('$orderDetail').hide();
    }
  </script>


  <script type="text/javascript">
    function submitForm(x){

      $('#frm_'+x).submit();
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