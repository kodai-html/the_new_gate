<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB; //追記※

class Sale extends Model
{
    //テーブル名
    protected $table = 'sales';

    protected $dates =  ['created_at', 'updated_at'];

    //可変項目
    protected $fillable = [
        'id',
        'product_id'
    ];

    public function getWithId($id) {
        $sale = Sale::select('products.id as products.id', 'sales.product_id as sales.product_id', 'products.stock as stock')
        ->where('products.id', $id)
        ->first();

        return $sale;
    }

    public function subtraction() {

        $sale = \DB::table('sales')
        ->select('products.id as products.id', 'sales.product_id as sales.product_id', 'products.stock as stock', 'sales.id as sale_id')
        ->join('products', 'products.id', '=', 'sales.product_id')
        ->get();
        
        return $sale;
    }
}
