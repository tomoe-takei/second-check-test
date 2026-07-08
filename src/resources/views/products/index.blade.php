<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品一覧画面</title>

    <!-- 長いCSSの代わりに、この1行でお引越し先を呼び出します -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

<!-- 🛠 ここから【HTML（画面の部品）】エリア 🛠 -->
    <div class="header-container"><!-- ヘッダー全体を囲む大きな箱のスタート -->
        <h1>商品一覧</h1><!-- 部品① -->
        <!-- 右上の追加ボタン -->
        <a href="/products/register" class="add-button">+商品を追加</a><!-- 部品② -->
    </div>    <!-- 📦 大きな箱の終わり -->
    
    <!-- メインエリア（左サイドバーと右商品一覧のドッキング） -->
     <!-- 左サイドバーと、右のカード一覧を1つにまとめる超巨大な箱のスタート -->
    <div class="main-container">

        <!-- 左サイドバー 250px の専用エリア：検索・並び替え -->
        <aside class="sidebar"><!-- 左側  補足情報を置くためのasideタグ-->
            <!-- 検索の箱 -->
            <div class="search-container"><!-- 検索パーツ一式を綺麗に中央寄せしたり、まわりに余白を作るための箱 -->
                <!-- 1. 検索欄 & 検索ボタン（商品名の一部でも検索できる設定） -->
                <form action="/products/search" method="GET" class="search-form">
                    <!-- キーワード入力欄と検索ボタンを縦に並べるための小さな箱 -->
                    <div class="search-box">
                        <!-- 文字を打ち込む四角い箱。name="keyword"という名前の箱に文字が入って送信されます -->
                        <input type="text" name="keyword" placeholder="商品名を入力">
                        <!-- フォーム送信用のボタン。これを押すと検索（通信）が走ります -->
                        <button type="submit" class="search-button">検索</button>
                    </div>

                    <!-- 4. 並び替えボタン（クリックすると下のモーダルが開く） -->
                     <!-- モーダルを開くためのボタン。type="button"なので、これ単体では通信（送信）はしません -->
                <!-- onclick="..."はクリックされた瞬間に、すぐ下のdialog（モーダル）を開きなさいというJavaScriptの命令 -->
                    <button type="button" class="modal-open-btn" onclick="document.getElementById('sort-modal').showModal()">
                        価格順で表示
                    </button>

                    <!-- 4. 並び替え条件のモーダル本体（dialogタグ） -->
                     <!-- id="sort-modal"という背番号がついているので、上のボタンから指名されます -->
                    <dialog id="sort-modal" class="sort-modal">
                        <!-- モーダルの「上の部屋」。見出しと「×」ボタンが入る場所 -->
                        <div class="modal-header">
                            <h3>価格順で表示</h3>

                            <!-- 5. 「×」ボタン（モーダルを閉じて検索をリセットする） -->
                            <button type="button" class="modal-close-btn" onclick="document.getElementById('sort-modal').close()">×
                            </button>
                        </div>
                        <!-- モーダルの「下の部屋」。選択肢と、決定ボタンが入る場所 -->
                        <div class="modal-body">
                            <!-- 1.2. 並び替えのセレクトボックス -->
                             <!-- ドロップダウンの選択肢の箱。name="sort_order"というデータの名前でPHPに送られます -->
                            <select name="sort_order">
                                <!-- デフォルト表示 -->
                                <option value="price_default">価格で並び替え</option><!-- 最初に見えている初期値 -->

                                <!-- 選択肢 -->
                                <option value="price_desc">高い順に表示</option><!-- 選ぶと「price_desc」がPHPに届く -->
                                <option value="price_asc">低い順んい表示</option><!-- 選ぶと「price_asc」がPHPに届る -->
                            </select>

                            <!-- モーダル内で選んだ条件を、検索キーワードと一緒にまとめて「送信」する最終決定ボタン -->
                            <button type="submit" class="sort-apply-button">適用して表示</button>
                        </div>
                    </dialog>
                </form>
            </div>
        </aside>

        <!-- 右側：メインコンテンツ（果物カード 6枚 + ページネーション） -->
    <main class="main-content">
        <!-- 商品カードが並ぶ箱（横3枚・縦2枚） -->
        <div class="product-grid">

            <!-- 📦 ベルトコンベアのスタート！ -->
            <!-- 「届いたダンボール箱（$products）」から、果物を【1個ずつ】取り出して流す。 -->
            <!-- その流れてくる【今目の前にある1個】のことを、これからは $product と呼ぶ！ -->
            @foreach ($products as $product)
            <!-- 💡 カード全体を <a> タグで囲んで、クリックしたら詳細ページ（products.show）へ進むように繋ぎました！ -->
        <!-- 指示書に合わせて商品の背番号（$product->id）を一緒に持って進む設定です -->
                <a href="{{ route('products.show', $product->id) }}" class="product-card-link"><!-- 「これは商品カードを囲う専用のリンクだよ」と名前（class）をつける -->
            <!-- ここから1個分の果物カードの型 -->
                <div class="product-card">
                    <div class="product-image-box">
                    <!-- 倉庫に保存されている画像の名前（kiwi.pngなど）を自動でここにハメ込みます -->
                        <img src="{{ asset('storage/images/' . $product->image) }}" alt="商品画像">
                    </div>
                    <!-- 倉庫に保存されている「商品名」を自動で表示します（1周目はキウイ、2周目はストロベリー...） -->
                    <h4 class="product-name">{{ $product->name }}</h4>
                    <!-- 倉庫に保存されている「価格」を自動で表示します -->
                    <p class="product-price">¥{{ $product->price }}</p>
                </div>
                </a><!-- ここまで1個分の果物カードの型 -->
            @endforeach    <!-- 📦 ベルトコンベアの終わり！ -->
        </div><!-- product-grid の終わり -->

        <!-- ページネーション（1, 2, 次へボタン） -->
        <!-- ❌ 修正前 -->
        <!-- <div class="pagination-box"> {{ $products->links() }} </div> -->

        <!-- ⭕️ 修正後：CSSのデザインとピタッと名札（クラス名）を合わせて挟み込みます！ -->
        <div class="pagination">
            {{ $products->links() }}
        </div>

        <!-- 💡 そして、このファイルの「一番下（</html>の手前）」に、念のためこの強制横並びの魔法も貼り付けておきます -->
        <style>
        /* 縦並びの黒丸を、その場で強制的に横一列の美しいボタンに変身させます */
            .pagination ul {
                display: flex !important;         /* 縦並びを禁止して、横一列にする */
                list-style: none !important;      /* 邪魔な黒丸・テンを絶対に消し去る */
                padding: 0 !important;
                justify-content: center !important; /* 画面の真ん中に置く */
                margin: 20px 0 !important;
            }
            .pagination li {
               margin: 0 5px !important;         /* ボタン同士のすき間 */
            }
            .pagination li a,
            .pagination li span {
                display: block !important;
                padding: 6px 12px !important;
                border: 1px solid #ddd !important; /* きれいな四角い枠線をつける */
                border-radius: 4px !important;
                color: #007bff !important;
                text-decoration: none !important;
            }
            .pagination li.active span {
                background-color: #007bff !important; /* いま開いているページを青くする */
                color: #fff !important;
                border-color: #007bff !important;
            }
        </style>

    </main><!-- ⭕️ main-content の終わり -->
        
    
</body>
</html>

