@extends('layout')

@section('title', '商品一覧')
@section('content')
    <div class="content">
    <a href="{{ route('create') }}" class="btn btn-primary">商品投稿</a>
        @if (session('err_msg'))
            <p class="text-danger">
                {{ session('err_msg') }}
            </p>
        @endif
        <div class="m-5">
            <form class="form-inline">
                <input type="text" name="keyword" class="keyword form-control" placeholder="商品名を入力してください">
          
                <select class="maker form-control ml-3" id="tag-id" name="company_id">

                    {{ $num = 0 }}
                    <option value=""></option>
                    @foreach($companies as $company)
                    {{ $num += 1 }}
                    <option value ="{{ $num }}">{{ $company->company_name }}</option>

                    @endforeach
                </select>
                <input type="integer" name="rowPrice" class="rowPrice form-control ml-3" placeholder="下限金額を入力してください">
                <p>〜</p>
                <input type="integer" name="highPrice" class="highPrice form-control ml-3" placeholder="上限金額を入力してください">
                <br>
                <input type="integer" name="rowStock" class="rowStock form-control ml-3" placeholder="下限在庫を入力してください">
                <p>〜</p>
                <input type="integer" name="highStock" class="highStock form-control ml-3" placeholder="上限在庫を入力してください">

                <input type="submit" value="検索" class="btn btn-info ml-3">
            </form>
        </div>

        <form method="post" action="{{ route('orderID') }}">
            <div class="form-check form-check-inline">
                <input type="radio" name="release" class="form-check-input" id="release1" value="昇順" checked>
                <label for="release1" class="form-check-label">ID昇順</label>
            </div>
            <div class="form-check form-check-inline">
                <input type="radio" name="release" class="form-check-input" id="release2" value="降順" >
                <label for="release2" class="form-check-label">ID降順</label>
            </div>
        <p><input type="submit" value="並び替え"></p>

        <table id="sortTable" class="table sortTable">
            <thead>
                <tr>
                    <th style="width: 10%" scope="col">商品ID</th>
                    <th style="width: 10%" scope="col">メーカー</th>
                    <th style="width: 10%" scope="col">商品名</th>
                    <th style="width: 10%" scope="col">値段</th>
                    <th style="width: 10%" scope="col">在庫数</th>
                    <th style="width: 10%" scope="col">画像</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>

            <tbody id="products-list">
            @foreach($products as $product)
                <tr>
                    <td  width: 10%>{{ $product->product_id }}</td>
                    <td  width: 10%>{{ $product->company_name }}</td>
                    <td  width: 10%>{{ $product->product_name }}</td>
                    <td  width: 10%>{{ $product->price }}</td>
                    <td  width: 10%>{{ $product->stock }}</td>
                    <td ><img src="{{ asset('/storage/' . $product->image_path) }}" alt="写真" width=100% /></td>
                    <td><a href="{{ route('detail', $product->product_id) }}" class="btn btn-primary">詳細表示</a></td>
                    <!-- <form method="POST" action="{{ route('delete', $product->product_id) }}" onSubmit="return checkDelete()"> -->
                    @csrf
                    <!-- <td><button type="submit" data-product-id="{{ $product->product_id  }}" class="product-delete-button btn btn-primary">削除</button></td> -->
                    <td><a href="#" id="product-delete-button" data-product-id="{{ $product->product_id  }}" class="product-delete-button btn btn-primary">削除</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
