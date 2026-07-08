<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品変更画面</title>
    <!-- お引越しした共通のスタイルシートを呼び出します -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <!-- 💡 送信先を、指示書通りの「products.update」へ進むように設定しました！ -->
    <!-- どの果物を書き換えるのか教えるために、背番号（$product->id）を一緒に渡します -->
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf <!-- セキュリティのお守り -->

        <div class="detail-wrapper">
            
            <!-- 【上半分】左右に分割するエリア -->
            <div class="detail-top-section">
                
                <!-- 左側：現在の画像表示 ＆ 新しいファイル選択ボタン -->
                <div class="detail-left-box">
                    <div class="detail-image-box">
                        <!-- 💡 現在登録されている本物の写真を最初から画面に出しておきます -->
                        <img src="{{ asset('storage/images/' . $product->image) }}" alt="{{ $product->name }}">
                    </div>
                    <!-- 画像を変更したいときのためのファイル選択ボタン -->
                    <div class="file-input-box">
                        <input type="file" name="product_image">
                    </div>
                    @error('product_image')
                        <p style="color: red; margin: 5px 0 0 0; font-size: 14px;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 右側：商品名入力 ➔ 値段入力 ➔ 季節選択 -->
                <div class="detail-right-box">
                    
                    <!-- 商品名入力グループ -->
                    <div class="input-group">
                        <label class="section-title">商品名</label>
                        @error('name')
                            <p style="color: red; margin: 5px 0 0 0; font-size: 14px;">{{ $message }}</p>
                        @enderror
                        <!-- 💡 valueの中に、現在の名前（例：キウイ）を最初から文字としてはめ込んでおきます！ -->
                        <input type="text" name="name" class="detail-input" value="{{ $product->name }}">
                    </div>
                    
                    <!-- 値段入力グループ -->
                    <div class="input-group">
                        <label class="section-title">値段</label>
                        @error('price')
                            <p style="color: red; margin: 5px 0 0 0; font-size: 14px;">{{ $message }}</p>
                        @enderror
                        <!-- 💡 valueの中に、現在の値段（例：800）を最初から入れておきます！ -->
                        <input type="number" name="price" class="detail-input" value="{{ $product->price }}">
                    </div>

                    <!-- 季節（チェックボックス） -->
                    <!-- 100点満点の複数選択ボックスです -->
                    <div class="detail-season-box">
                        <p class="section-title">季節</p>
    
                        <label><input type="checkbox" name="seasons[]" value="1" {{ $product->seasons->contains(1) ? 'checked' : '' }}>春</label>
                        <label><input type="checkbox" name="seasons[]" value="2" {{ $product->seasons->contains(2) ? 'checked' : '' }}>夏</label>
                        <label><input type="checkbox" name="seasons[]" value="3" {{ $product->seasons->contains(3) ? 'checked' : '' }}>秋</label>
                        <label><input type="checkbox" name="seasons[]" value="4" {{ $product->seasons->contains(4) ? 'checked' : '' }}>冬</label>
                    </div>

                    @error('seasons')
                        <p style="color: red; margin: 5px 0 0 0; font-size: 14px;">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <!-- 【下半分】商品説明入力 ＆ ボタンエリア -->
            <div class="detail-bottom-section">
                
                <!-- 商品説明入力グループ -->
                <div class="input-group">
                    <p class="section-title">商品説明</p>
                    @error('description')
                        <p style="color: red; margin: 5px 0 0 0; font-size: 14px;">{{ $message }}</p>
                    @enderror
                    <!-- 💡 箱（textarea）の中に、現在の説明文を最初からはめ込んでおきます！ -->
                    <textarea name="description" class="detail-textarea" rows="5">{{ $product->description }}</textarea>
                </div>

                <!-- アクションボタン（戻る・変更を保存する） -->
                <div class="detail-footer-actions">
                    <!-- 戻るボタンを押したら詳細画面へ戻るように設定しました -->
                    <a href="{{ route('products.show', $product->id) }}" class="back-btn">戻る</a>
                    
                    <!-- データを送信するので type="submit" です。名前を「変更を保存する」にしました -->
                    <button type="submit" class="save-btn">変更を保存する</button>
                </div>

            </div>

        </div>

    </form>

</body>
</html>
