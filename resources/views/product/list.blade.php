@extends('layout')

@section('title', '商品一覧')
@section('content')
    <div class="content">
        @if (session('err_msg'))
            <p class="text-danger">
                {{ session('err_msg') }}
            </p>
        @endif
        <div class="m-5">
            <form class="form-inline" action="{{ route('list') }}">
                <input type="text" name="keyword" class="form-control" placeholder="商品名を入力してください">
                <input type="submit" value="検索" class="btn btn-info">
            </form>
        </div>
        <div  class="m-5">
            <form class="form-inline" action="{{ route('list') }}">
                <select class="form-control" id="tag-id" name="manufacture">
                    @foreach (Config::get('array.manufacture') as $key => $val)
                        <option value="{{ $key }}">{{ $val }}</option>
                    @endforeach
                </select>
                <input type="submit" value="検索" class="btn btn-info">
            </form>
        </div>
        <table class="table">
            <thead>
                <tr>
                <th style="width: 10%" scope="col">商品ID</th>
                <th style="width: 10%" scope="col">メーカー</th>
                <th style="width: 10%" scope="col">商品名</th>
                <th style="width: 10%" scope="col">値段</th>
                <th style="width: 10%" scope="col">在庫数</th>
                <th style="width: 20%" scope="col">登録日</th>
                <th style="width: 10%" scope="col">画像</th>
                <th></th>
                <th></th>
                <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td width: 10%>{{ $product->id }}</td>
                    <td width: 10%>{{ $product->manufacture }}</td>
                    <td width: 10%>{{ $product->product_name }}</td>
                    <td width: 10%>{{ $product->price }}</td>
                    <td width: 10%>{{ $product->stock }}</td>
                    <td width: 20%>{{ $product->created_at }}</td>
                    <td ><img src="{{ asset('/storage/' . $product->image_path) }}" alt="写真" width=100% /></td>
                    <td><a href="{{ route('detail', $product->id) }}">詳細表示</a></td>
                    <form method="POST" action="{{ route('delete', $product->id) }}" onSubmit="return checkDelete()">
                    @csrf
                    <td><button type="submit" class="btn btn-primary">削除</button></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <script>
    function checkDelete() {
      if(window.confirm('削除してよろしいですか')) {
        return true;
      } else {
        return false;
      }
    }
    </script>
@endsection
