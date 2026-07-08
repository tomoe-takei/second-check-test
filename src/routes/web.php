<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/products', function () { return view('products.index'); });
// コントローラーを通さずに、直接products/indexの画面を開く（テスト用）
// 1. ユーザーが「/products」にアクセスしたら、ProductControllerの「indexアクション」を起動しなさい。        あだ名を'products.index'つけておくと書き換えをしなくて済む
Route::get('/products',[ProductController::class,'index'])->name('products.index');

// 2. 検索ボタンを押したときの進む先（/products/search）を追加
Route::get('/products/search',
[ProductController::class,'search'])->name('products.search');

// 💡 注意：詳細ページ（{product_id}）よりも必ず「上（手前）」に書きます！
// 1. 商品登録画面を表示するURLを追加
Route::get('products/register',[ProductController::class,'create'])->name('products.create');
// 💡 データを「保存（POST）」するためのURLを追加します
Route::post('/products/store' , [ProductController::class,'store'])->name('products.store');

// 💡【新着追加】背番号（product_id）の果物をデータベースから完全に消去するURL（POST送信）
Route::post('/products/{product_id}/destroy',[ProductController::class,'destroy'])->name('products.destroy');

// 商品詳細ページ（URLの後ろに商品の背番号をくっつけて進む設定です）
Route::get('/products/detail/{product_id}',[ProductController::class,'show'])->name('products.show');

// 💡【新着追加①】編集（変更）画面を表示するURL（GET送信）
Route::get('products/{product_id}/edit',[ProductController::class,'edit'])->name('products.edit');

// 💡【新着追加②】編集されたデータを実際に上書き保存するURL（POST送信）
Route::post('/products/{product_id}/update',[ProductController::class,'update'])->name('products.update');
