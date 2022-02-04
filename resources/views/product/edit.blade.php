@extends('layout')
@section('content')
<div class="m-5">
  <form method="POST" action="{{ route('update') }}" enctype='multipart/form-data'>
    @csrf
    <input type="hidden" name="id" value="{{ $product->id }}">
    <div class="my-5">
      <input type="file" name="image_path"/>
      @if ($product->image_path !=='')
        <img src="{{ asset('/storage/' . $product->image_path) }}" width=25px>
      @else
        <p>NO IMAGE</p>
      @endif
    </div>
    <div>
      <select name= "manufacture">
        @foreach (Config::get('array.manufacture') as $key => $val)
            <option value="{{ $key }}"
                @if ( $product->manufacture == $key ) 
                    selected
                @endif
            >{{ $val }}</option>
        @endforeach
      </select>
    </div>
    <div class="mt-5">
      <label for="product_name">商品名</label>
      <br/>
      <input type="text" name="product_name" value="{{ $product->product_name }}">
      @if ($errors->has('product_name'))
          <div class="text-danger">
              {{ $errors->first('product_name') }}
          </div>
      @endif
    </div>
    <div class="mt-5">
      <label for="price">価格</label>
      <br/>
      <input type="text" name="price" value="{{ $product->price }}">
      @if ($errors->has('price'))
          <div class="text-danger">
              {{ $errors->first('price') }}
          </div>
      @endif
    </div>
    <div class="mt-5">
      <label for="stock">在庫数</label>
      <br/>
      <input type="text" name="stock" value="{{ $product->stock }}">
      @if ($errors->has('stock'))
          <div class="text-danger">
              {{ $errors->first('stock') }}
          </div>
      @endif
    </div>
    <div class="mt-5">
      <label for="comment">コメント</label>
      <br/>
      <input type="textarea" name="comment" value="{{ $product->comment }}">
      @if ($errors->has('comment'))
          <div class="text-danger">
              {{ $errors->first('comment') }}
          </div>
      @endif
    </div>
    <a href="{{ route('list') }}">キャンセル</a>
    <button type="submit">更新する</button>
  </form>
</div>
@endsection