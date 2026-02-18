<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Season;
use App\Models\ProductSeason;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    public function getProducts()
    {
        $products = Product::all();
        $perPage = 6;
        $page = Paginator::resolveCurrentPage('page');
        $pageData = $products->slice(($page - 1) * $perPage, $perPage);
        $options = [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page'
        ];

        $products = new LengthAwarePaginator($pageData, $products->count(), $perPage, $page, $options);

        return view('list', compact('products'));
    }

    



    public function getDetail($product_id)
    {
        $product = Product::with('seasons')->find($product_id);
        $seasons = Season::all();

        return view('detail', compact('product','seasons'));
    }
    

    public function upload(ProductRequest $request)
    {
        $dir = 'images';
        $file_name = $request->file('product_image')->getClientOriginalName();
        $request->file('product_image')->storeAs('public/' . $dir, $file_name);

        $product_data = new Product();
        $product_data->name = $_POST["product_name"];
        $product_data->price = $_POST["product_price"];
        $product_data->image = 'storage/' . $dir . '/' . $file_name;
        $product_data->description = $_POST["product_description"];
        $product_data->save();


        $product_seasons = $request->input('product_season', []);
        $new_product_id =  Product::count();

        foreach($product_seasons as $product_season){

            $product_season_data = new ProductSeason();
            $product_season_data->product_id = $new_product_id;
            $product_season_data->season_id = $product_season;
            $product_season_data->save();
        }

        $products = Product::all();
        $perPage = 6;
        $page = Paginator::resolveCurrentPage('page');
        $pageData = $products->slice(($page - 1) * $perPage, $perPage);
        $options = [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page'
        ];

        $products = new LengthAwarePaginator($pageData, $products->count(), $perPage, $page, $options);

        return redirect('/products');
    }



}
