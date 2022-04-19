<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Sale;
use App\Models\Product;

class SaleController extends Controller
{
    public function stockControl(Request $request)
    {
        $model = new Sale();

        $quantity = $request->num;

        $sale = $model->subtraction();

        //salesテーブルに追加
        \DB::table('sales')->insert([
            'product_id' => "$quantity"
        ]);

        $target = $sale[count($sale)-1];

        $remainder = $target->stock;

        $createdSale =  $target->sale_id +=1;

        if($remainder > 0) {

            echo '通信成功';
            //productsテーブルのstockから減算
            \DB::table('products')
            ->where('products.id', $quantity)
            ->decrement('stock', 1);

        } else {
            echo '購入できません';

            $db_data = new Sale;
            $db_data->where('sales.id', $createdSale)->delete();
        }
    }
}
