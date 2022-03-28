<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Product extends Model
{


    public function searchProduct($keyword, $maker, $rowPrice, $highPrice, $rowStock, $highStock) {
        $product = DB::table('products')
        ->select('products.id as product_id', 'image_path as image_path', 'company_id as company_id', 'product_name as product_name', 'price as price', 'stock as stock', 'comment as comment', 'companies.company_name as company_name')
        ->join('companies','products.company_id','=','companies.id');

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

    //テーブル名
    protected $table = 'products';

    //可変項目
    protected $fillable = [
        'product_name',
        'company_id',
        'price',
        'stock',
        'comment',
        'image_path'
    ];

}
