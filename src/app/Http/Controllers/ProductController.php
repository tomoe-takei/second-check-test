<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Season;
use App\Models\ProductSeason;


use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    public function index()/*** 商品一覧画面を表示するメソッド（機能）*/
    {
        // 1. Productモデル（オブジェクト）の paginate メソッドを使って、
        //    データベースから商品を【1ページにつき6件ずつ】小分けにして取得し、変数 $products に入れます。
        $products = Product::paginate(6);

        // 2. あなたが作ったHTMLを開きなさい、という命令。
        //    その際、取ってきた $products（6件のデータ）を、画面側に一緒に手渡します（compact）。
        return view('products.index', compact('products'));
        // $products という変数（箱）の中身に、『products』という名前（キー）の付箋を貼って、HTML画面へ宅配便で送りなさい
    }

    /**
     * 2. 検索ボタン、またはモーダルの適用ボタンを押したとき（/products/search）
     */
    public function search(Request $request)
    {
         // 検索条件を組み立てる準備。 検索や並び替えの条件を後から追加できる
        $query = Product::query();
        // 【商品名検索】
        $keyword = $request->input('keyword');
            if(!empty($keyword))
            {//$keyword が空ではない場合、検索処理を実行します
                $query->where('name', 'LIKE', '%' .$keyword .'%');
            }
        // 【価格の並び替え】
        $sortOrder = $request->input('sort_order');
        if($sortOrder === 'price_desc') {
            // ➔ もし、ユーザーが選んだ条件が「price_desc（高い順）」と完全に一致（===）したら、
            $query->orderBy('price','desc');// 高い順
            // ➔ 質問箱（$query）に「価格（price）が 高い順（desc）に並べ替えろ」という命令を追加せよ！
        } elseif ($sortOrder ==='price_asc'){
            // ➔ そうじゃなくて、もし選んだ条件が「price_asc（低い順）」だったら、
            $query->orderBy('price','asc');// 低い順
            // ➔ 質問箱に「価格（price）が 安い順（asc）に並べ替えろ」という命令を追加せよ！
        }
        // 条件に一致した商品を「1ページにつき6件ずつ」取得
        $products = $query->paginate(6);
        // 検索結果も、最初と同じ「商品一覧のHTML（index.blade.php）」に流し込んで表示
        return view('products.index', compact('products'));
    }

    /**
     * 3. 商品詳細ページを表示するアクション
     */
    public function show($product_id )// 💡URLから送られてきた商品の背番号（$id）を受け取ります
    {
        // 倉庫（Productモデル）から、その背番号の果物を1件だけ探し出しなさい！
        // もし見つからなかったら「404エラー画面」を自動で出しなさい、という強力な命令です
        $product = Product::findOrFail($product_id);

        //$product = Product::with('seasons')->find($product_id);
        //dd($product_id);
        //$seasons = Season::all();
        //dd($seasons);

        // 新しく作る詳細画面「products.show」を開き、その果物データ（$product）を1件手渡す
        return view('products.show',compact('product'));
    }

    /**
     * 商品登録画面を表示するアクション
     */
    public function create()
    {
        // 先ほど作った「products/create.blade.php」を開きなさいという命令です
        return view('products.create');
    }

    public function store(ProductRequest $request)// 💡画面から届いた文字荷物（$request）を受け取ります
    {
    // 1. 倉庫（Productモデル）に、新しく「完全に空っぽの1行（データ）」を組み立てなさいという命令
    $product = new Product();
    // 2. ユーザーが入力した文字を、1つずつデータベースの引き出し（カラム）に詰め込みます
    $product->name = $request->input('name');// 商品名の引き出しへ
    $product->price = $request->input('price');// 値段の引き出しへ
    $product->description = $request->input('description');// 商品説明の引き出しへ

    // 💡【新機能】1. 画面から送られてきた「本物の画像ファイル」を掴み取ります
    if ($request->hasFile('product_image')) {
        $file = $request->file('product_image');
        // 💡 2. さっき勉強した「名前の重複」を防ぐために、今日の日付や時間を名前にくっつけて自動改名（整える）します
        //    例：20260627_153000.png みたいな絶対に被らない名前に変わります
        $fileName = time() . '_' . $file->getClientOriginalName();
        // 💡 3. 指示書通り、ワープトンネル（シンボリックリンク）が開通している「storage/images」フォルダへ本物の写真を保存します
        $file->storeAs('public/images',$fileName);
        // 💡 4. データベースの引き出しには、本物の写真ではなく、その新しくついた【名前（文字）】だけを保存します！
        $product->image = $fileName;
    } else {
        // もし万が一画像がなかったら、仮の画像名を入れます
        $product->image = 'kiwi.png';
    }

    // 💡画像と季節は、今の段階ではエラーを防ぐための「仮の文字（kiwi.pngやspring）」を入れておきます
    // （次のステップで、画像アップロードと中間テーブルの本物の機能にグレードアップします！）
    //$product->image ='kiwi.png';
    // 3. 最後に「保存ボタン（save）」を押して、データベース（倉庫）への書き込みを確定します！
    $product->save();

    $product->seasons()->sync($request->input('seasons'));
        // 4. 保存がすべて終わったら、指示書通り「商品一覧ページ」へ自動で画面をジャンプ（転送）させなさい！
    return redirect()->route('products.index');
    }

        /**
     * 6. 商品の変更（編集）画面を表示するアクション
     */
    public function edit($product_id)// 💡指示書に合わせて、商品の背番号（$product_id）を受け取ります
    {
        // 1. 倉庫（Productモデル）から、その背番号の果物を1件だけ探し出しなさい！
        //    もし存在しない背番号だったら、自動で404エラー画面を出しなさい、という安全な命令（復習！）
        $product = Product::findOrFail($product_id);
        
        // 2. 新しく作る変更画面（products.edit）を開き、その果物データ（$product）を1件手渡します
        return view('products.edit', compact('product'));
    }


    public function update(ProductRequest $request,$product_id)
    {
        // 💡【ここが登録と違う！】
        // 新規登録の時は「new Product()」で新品の1行を作りましたが、
        // 更新の時は、URLの背番号（$product_id）を使って、倉庫から「今ある既存の1行」を引っ張り出してきます！
        $product = Product::findOrFail($product_id);

         // 画面から届いた新しい文字で、引き出しの中身をガサッと書き換えます
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->description =$request->input('description');
        
        // 【画像アップロード機能】もし新しい写真が選ばれていたら、改名してフォルダへ保存します（storeの時と100%同じ！
        if($request->hasFile('product_image')) {
            $file = $request->file('product_image');
            $fileName = time() . '_' .$file->getClientOriginalName();
            $file->storeAs('public/images',$fileName);

             // データベースの引き出しを、新しい画像の名前に上書きします
            $product->image = $fileName;
        }

        // 最後に「上書き保存（save）」を実行して、データベースへの書き込みを確定します！
        $product->save();

        // 🔥【ココに書く！】2. セーブした直後に、あなたがステップ②で作ったトンネル（seasons()）を指差して、
        // 画面から届いた季節データをノートに同期（sync）させなさい！という命令をここに1行追記します！
        $product->seasons()->sync($request->input('seasons'));

         // 全てが終わったら、指示書通り「商品一覧ページ」へ自動でジャンプ（転送）させなさい！
        return redirect('products');
    }

     /**
     * 8. 商品のデータをデータベースから完全に削除するアクション
     */
    public function destroy($product_id)// 💡消したい商品の背番号（$product_id）を受け取ります
    {
        // 1. 倉庫（Productモデル）から、その背番号の果物を1件だけ探し出します！
        $product = Product::findOrFail($product_id);

        // 2. 掴み取ったその果物データに向かって、木っ端微塵に消え去りなさい（delete）！と命令します
        $product->delete();

         // 3. 削除がすべて終わったら、自動で「商品一覧ページ」へ画面をジャンプさせて戻します
         return redirect()->route('products.index');
    }
}