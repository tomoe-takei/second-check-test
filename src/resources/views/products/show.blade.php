<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品詳細画面</title>
    <!-- 先ほどお引越ししたCSSファイルをここでも呼び出します -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <div class="detail-wrapper">
        <!-- 【上半分】左右に分割するエリア -->
        <div class="detail-top-section">
            <!-- 左側：商品画像 ＆ ファイル選択ボタン -->
            <div class="detail-left-box">
                <div class="detail-image-box">
                    <img src="{{ asset('storage/images/' . $product->image) }}" alt="{{ $product->name }}">
                </div>
                <!-- 将来、登録時に画像を変更するためのファイル選択ボタン -->
                <div class="file-input-box">
                    <input type="file" name="product_image">
                </div>
            </div>

            <!-- 右側：商品名 ➔ 入力欄 ➔ 値段 ➔ 入力欄 ➔ 季節 ➔ ラジオボタン -->
            <div class="detail-right-box">
                <!-- 商品名グループ -->
                <div class="input-group">
                    <label class="section-title">商品名</label>
                    <!-- 💡 商品名を入力できる箱（valueの中に現在の名前を自動で入れます） -->
                    <input type="text" name="name" class="detail-input" value="{{ $product->name }}">
                </div>
                <!-- 値段グループ -->
                <div class="input-group">
                    <label class="section-title">値段</label>
                    <!-- 💡 値段を入力できる箱 -->
                    <input type="number" name="price" class="detail-input" value="{{ $product->price }}">
                </div>

                <!-- 季節（ラジオボタン） -->
                <div class="detail-season-box">
                    <p class="section-title">季節</p>
                    <label><input type="radio" name="season" value="spring">春</label>
                    <label><input type="radio" name="season" value="summer">夏</label>
                    <label><input type="radio" name="season" value="autumn">秋</label>
                    <label><input type="radio" name="season" value="winter">冬</label>
                </div>
            </div>
        </div>

        <!-- 【下半分】商品説明 ＆ その下に入力できる大きな箱 -->
        <div class="detail-bottom-section">
            <div class="input-group">
                <p class="section-title">商品説明</p>
                <!-- 💡 商品説明を入力できる大きな箱（textareaタグ） -->
                <textarea name="description" class="detail-textarea" rows="5">{{ $product->description }}</textarea>
            </div>
        </div>

        <!-- アクションボタン（戻る・保存・ゴミ箱） -->
        <div class="detail-footer-actions">
            <!-- 左側：戻るボタン -->
            <a href="{{ route('products.index') }}" class="back-btn">戻る</a>
            <!-- 中央：変更を保存ボタン 後にedit画面へワープするように書き換える-->
            <!--<button type="submit" class="save-btn">変更を保存</button>-->
            <a href="{{ route('products.edit', $product->id) }}" class="save-btn" style="text-decoration: none; text-align: center;">変更画面へ進む</a>

            <!-- 右側：少し感覚をあけて配置するゴミ箱マーク --><!-- ❌ 修正前（ただの飾りのボタンでした） 
            <button type="button" class="trash-btn" title="商品を削除"> 🗑️</button>-->
            <!-- ⭕️ 修正後：削除機能（products.destroy）へ背番号を乗せて送信する、本物のフォームに変身させます！ -->
            <form action="{{ route('products.destroy',$product->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('本当に削除しますか？');">
                @csrf
                <!-- 🗑️ 本物の送信ボタン（type="submit"）にします -->
                 <button type="submit" class="trash-btn" title="商品を削除">🗑️</button>
            </form>
        </div>
    </div>
    
</body>
</html>