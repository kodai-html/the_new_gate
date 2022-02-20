<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
      }

    /**
     * 商品一覧を表示する
     * 
     * @return view
     */
    public function showList(Request $request) {

        $keyword = $request->input('keyword');

        $maker = $request->input('company_id');

        $model = new Product();

        $query = Product::query();

        $companies = Company::all();

        if(!empty($keyword) && !empty($maker)) {
            $products = $model->getBothProduct($maker, $keyword);

            return view('product.list', ['products' => $products], ['companies' => $companies]);
        }

        if(empty($keyword) && !empty($maker)) {

            $products = $model->getMakerProduct($maker);

            return view('product.list', ['products' => $products], ['companies' => $companies])
            ->with('maker',$maker)
            ->with('company_id');
        }

        if(!empty($keyword) && empty($maker)) {

            $products = $model->getKeywordProduct($keyword);

            return view('product.list', ['products' => $products])
            ->with('keyword',$keyword)
            ->with('product_name');
        }
        
        if(empty($keyword) && empty($maker)) {

            $products = $model->getAllProduct();
            
            return view('product.list', ['products' => $products], ['companies' => $companies]);
        }
    }

    /**
     * 詳細を表示する
     * @param int $id
     * @return view
     */
    public function showDetail($id) {

        $model = new Product();
        $product = $model->getProduct($id);

        if (is_null($product)) {
            \Session::flash('err_msg', 'データがありません。');
            return redirect(route('list'));
        }

        return view('product.detail', ['product' => $product]);
    }
    /**
     * 投稿画面を表示
     * 
     * @return view
     */
    public function showCreate() {

        $companies = Company::all();
        
        return view('product.form', ['companies' => $companies]);
    }

    /**
     * 登録処理
     * 
     * @return view
     */
    public function exeStore(ProductRequest $request) {
        $inputs = $request->all();
        $imagefile = $request->file('image_path');


        if($request->hasFile('image_path')){
            $pass = \Storage::put('/public', $imagefile);
            $pass = explode('/', $pass);

            $inputs['image_path'] = $pass[1];
        } else{
            $pass = null;
        }

        \DB::BeginTransaction();
        try{
            Product::create($inputs);
            \DB::commit();
        } catch(\Throwable $e) {
            \DB::rollback();
            $e->getMessage();
            abort(500);
        }

        \Session::flash('err_msg', '商品を登録しました。');
        return redirect(route('create'));
    }

    /**
     * 編集フォームを表示する
     * @param int $id
     * @return view
     */
    public function showEdit($id) {

        $model = new Product();
        $product = $model->getProduct($id);

        // dd($product);

        if (is_null($product)) {
            \Session::flash('err_msg', 'データがありません。');
            return redirect(route('list'));
        }

        return view('product.edit', ['product' => $product])->with([
            'defaultName' => 'デフォルトの名称',
        ]);
    }
        /**
     * 情報更新処理
     * 
     * @return view
     */
    public function exeUpdate(ProductRequest $request) {
        $inputs = $request->all();
        $imagefile = $request->file('image_path');

        // dd($inputs);
        \DB::BeginTransaction();
        $product = Product::find($inputs['id']);
        if($request->hasFile('image_path')){
            $pass = \Storage::put('/public', $imagefile);
            $pass = explode('/', $pass);

            $inputs['image_path'] = $pass[1];
            
            try{
                $product->fill([
                    'image_path' => $inputs['image_path']
                ]);
                $product->save();
                \DB::commit();
            } catch(\Throwable $e) {
                \DB::rollback();
                $e->getMessage();
                abort(500);
            }
        } else{
            $pass = null;
        }

        try{
            $product->fill([
                'product_name' => $inputs['product_name'],
                'company_id' => $inputs['company_id'],
                'price' => $inputs['price'],
                'stock' => $inputs['stock'],
                'comment' => $inputs['comment'],
            ]);

            $attributes = $request->only(['product_name', 'company_id', 'price', 'stock', 'comment']);
            $product->save($attributes);
            \DB::commit();
        } catch(\Throwable $e) {
            \DB::rollback();
            $e->getMessage();
            abort(500);
        }

        \Session::flash('err_msg', '更新しました。');
        return redirect(route('edit', $product->id));
    }

    /**
     * 商品削除
     * @param $id
     * @return view
     */
    public function exeDelete($id){

        if(empty($id)){
            \Session::flash('err_msg', 'データがありません');
            return redirect(route('list'));
        }
        try{
            Product::destroy($id);

        }catch(\Throwable $e) {
            abort(500);
        }

        \Session::flash('err_msg', '削除しました。');
        return redirect(route('list'));
    }

}

