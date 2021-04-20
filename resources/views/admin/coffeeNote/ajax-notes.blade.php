<div class="row">
  @foreach($notes as $n)
  <div class="col-md-3">
    <label><input type="checkbox" name="notes[]" value="{{ $n->name }}">{{ $n->name }}</label>
  </div>
  @endforeach
</div>