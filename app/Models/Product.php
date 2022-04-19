<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable; //追加


class Product extends Model
{
    // use Sortable;  // 追加

    public function searchProduct($order, $keyword, $maker, $rowPrice, $highPrice, $rowStock, $highStock) {
        $product = DB::table('products')
        ->select('products.id as product_id', 'image_path as image_path', 'company_id as company_id', 'product_name as product_name', 'price as price', 'stock as stock', 'comment as comment', 'companies.company_name as company_name')
        ->join('companies','products.company_id','=','companies.id');

        if($order == 'ID昇順') {
            $product->orderby('product_id', 'asc');
        }
        if($order == 'ID降順') {
            $product->orderby('product_id', 'desc');
        }
        if($order == 'メーカー昇順') {
            $product->orderby('company_id', 'asc');
        }
        if($order == 'メーカー降順') {
            $product->orderby('company_id', 'desc');
        }
        if($order == '商品名昇順') {
            $product->orderby('product_name', 'asc');
        }
        if($order == '商品名降順') {
            $product->orderby('product_name', 'desc');
        }
        if($order == '値段昇順') {
            $product->orderby('price', 'asc');
        }
        if($order == '値段降順') {
            $product->orderby('price', 'desc');
        }
        if($order == '在庫数昇順') {
            $product->orderby('stock', 'asc');
        }
        if($order == '在庫数降順') {
            $product->orderby('stock', 'desc');
        }

        if($keyword) {
            $product->where('products.product_name', 'LIKE', '%'.$keyword.'%');
        }

        if($maker) {
            $product->where('company_id', $maker);
        }

        if(isset($rowPrice) && isset($highPrice)) {
            $product->whereBetween('price', [$rowPrice, $highPrice]);
        }

        if(isset($rowPrice) && empty($highPrice)) {
            $product->whereBetween('price', [$rowPrice, 999999999]);
        }

        if(empty($rowPrice) && isset($highPrice)) {
            $product->whereBetween('price', [0, $highPrice]);
        }

        if(isset($rowStock) && isset($highStock)) {
            $product->whereBetween('stock', [$rowStock, $highStock]);
        }

        if(isset($rowStock) && empty($highStock)) {
            $product->whereBetween('stock', [$rowStock, 999999999]);
        }

        if(empty($rowStock) && isset($highStock)) {
            $product->whereBetween('stock', [0, $highStock]);
        }

        if(is_null($keyword) && is_null($maker)) {

        }

        return $product->get();
    }

    //クエリビルダを取得
    public function getProduct($id) {
        // productsテーブルからデータを取得

        $product = DB::table('products')
        ->where('products.id', $id)
        ->select('products.id as product_id', 'image_path as image_path', 'company_id as company_id', 'product_name as product_name', 'price as price', 'stock as stock', 'comment as comment', 'companies.company_name as company_name')
        ->join('companies','products.company_id','=','companies.id')
        ->first();

        return $product;
    }

    public function getAllProduct(){

        $product_query = Product::select('products.id as product_id', 'image_path as image_path', 'company_id as company_id', 'product_name as product_name', 'price as price', 'stock as stock', 'comment as comment', 'companies.company_name as company_name')
        ->join('companies','products.company_id','=','companies.id')
        ->get();

        // dd($product_query);

        return $product_query;
    }

    public function getMakerProduct($maker){

        $product_query = Product::select('products.id as product_id', 'image_path as image_path', 'company_id as company_id', 'product_name as product_name', 'price as price', 'stock as stock', 'comment as comment', 'companies.company_name as company_name')
        ->join('companies','products.company_id','=','companies.id')
        ->orderBy('products.created_at','asc')
        ->where('company_id', $maker)
        ->get();

        return $product_query;
    }

    public function getKeywordProduct($keyword){

        $product_query = Product::select('products.id as product_id', 'image_path as image_path', 'company_id as company_id', 'product_name as product_name', 'price as price', 'stock as stock', 'comment as comment', 'companies.company_name as company_name')
        ->join('companies','products.company_id','=','companies.id')
        ->orderBy('products.created_at','asc')
        ->where('product_name','like','%'.$keyword.'%')
        ->get();

        return $product_query;
    }

    public function getBothProduct($maker, $keyword){

        $product_query = Product::select('products.id as product_id', 'image_path as image_path', 'company_id as company_id', 'product_name as product_name', 'price as price', 'stock as stock', 'comment as comment', 'companies.company_name as company_name')
        ->join('companies','products.company_id','=','companies.id')
        ->orderBy('products.created_at','asc')
        ->where('company_id', $maker)
        ->where('product_name','like','%'.$keyword.'%')
        ->get();

        return $product_query;
    }

    public function getDeleteProduct($id) {
        $product_query = Product::select('products.id as product_id', 'image_path as image_path', 'company_id as company_id', 'product_name as product_name', 'price as price', 'stock as stock', 'comment as comment', 'companies.company_name as company_name')
        ->where('products.id', $id)
        ->first();

        return $product_query;
    }

    public function orderID() {

        $sort_query = DB::table('products')
                ->orderBy('id', 'desc')
                ->get();
        // $sort_query = DB::table('products')->oldest()->get();

        return $sort_query;
    }

    public function orderMaker() {

    }

    public function orderName() {

    }

    public function orderPrice() {

    }

    public function orderStock() {

    }


    //テーブル名
    protected $table = 'products';

    //可変項目
    protected $fillable = [
        'id',
        'product_name',
        'company_id',
        'price',
        'stock',
        'comment',
        'image_path'
    ];

}
