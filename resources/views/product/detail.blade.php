@extends('layout')

@section('title', '商品情報')
@section('content')
    <div class="content">
        <div class="table">
            <tr>
                <td>商品ID：{{ $product->id }}</td>
                <br>
                <td class="m-5">商品名：{{ $product->product_name }}</td>
                <br>
                <td>メーカー：{{ $product->manufacture }}</td>
                <br>
                <td class="mt-5">値段：{{ $product->price }}円</td>
                <br>
                <td class="mt-5">残り：{{ $product->stock }}本</td>
                <br>
                <td class="mt-5">コメント：{{ $product->comment }}。</td>
                <br>
                <td ><img src="{{ asset('/storage/' . $product->image_path) }}" alt="写真" width=20%/></td>
                <br>
                <td><a href="{{ route('edit', $product->id) }}" class="btn btn-primary">編集</a></td>
                <a href="{{ route('list') }}" class="ml-3">一覧へ戻る</a>
            </tr>
        </div>
    </div>
@endsection
