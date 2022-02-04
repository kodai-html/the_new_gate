@extends('layout')
@section('content')
<div class="m-5">
  <form method="POST" action="{{ route('store') }}" enctype='multipart/form-data'>
    @csrf
    <div class="my-5">
      <input type="file" name="image_path" />
    </div>
    <div>
      <select name= "manufacture">
        <option value = "サントリーー">サントリーー</option>
        <option value = "コカコーーラ">コカコーーラ</option>
        <option value = "イトーーエン">イトーーエン</option>
      </select>
    </div>
    <div class="mt-5">
      <label for="product_name">商品名</label>
      <br/>
      <input type="text" name="product_name">
      @if ($errors->has('product_name'))
          <div class="text-danger">
              {{ $errors->first('product_name') }}
          </div>
      @endif
    </div>
    <div class="mt-5">
      <label for="price">価格</label>
      <br/>
      <input type="text" name="price">
      @if ($errors->has('price'))
          <div class="text-danger">
              {{ $errors->first('price') }}
          </div>
      @endif
    </div>
    <div class="mt-5">
      <label for="stock">在庫数</label>
      <br/>
      <input type="text" name="stock">
      @if ($errors->has('stock'))
          <div class="text-danger">
              {{ $errors->first('stock') }}
          </div>
      @endif
    </div>
    <div class="mt-5">
      <label for="comment">コメント</label>
      <br/>
      <input type="textarea" name="comment">
      @if ($errors->has('comment'))
          <div class="text-danger">
              {{ $errors->first('comment') }}
          </div>
      @endif
    </div>
    <a href="{{ route('list') }}">キャンセル</a>
    <button type="submit">投稿する</button>
  </form>
</div>
@endsection