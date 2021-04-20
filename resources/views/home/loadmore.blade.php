@foreach($products as $p)
<a href="{{ route('product.details',$p->id) }}">
  <div class="col-md-4">
    <div class="coffe_types_Sec">
      <img src="{{ asset('/images/admin/products/'.$p->image) }}" alt="">
      <a class="cofe_link" href="{{ route('product.details',$p->id) }}">{{ $p->product_name }}</a>
      <p><span class="cofe_price">{{ $p->price }}</span> SAR</p>
      <a href="{{ route('product.details',$p->id) }}" class="adto_Cart">ADD TO CART</a>
    </div>
  </div>
</a>
@endforeach