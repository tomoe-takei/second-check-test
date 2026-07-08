<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品登録画面</title>
    <!-- すでにある共通のスタイルシートを呼び出します -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <!-- 💡データを送信（保存）するために、全体を <form> タグで囲みました！ -->
    <!-- 画像をアップロードするときは、必ず enctype="multipart/form-data" を書くルールがあります -->
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf<!-- Laravelでデータを送信するときに必須のセキュリティお守り -->

    <div class="detail-wrapper">
            
            <!-- 【上半分】左右に分割するエリア -->
            <div class="detail-top-section">
                
                <!-- 左側：商品画像選択 ＆ ファイル選択ボタン -->
                <div class="detail-left-box">
                    <div class="detail-image-box">
                        <!-- 新規登録時はまだ画像がないので、仮のグレーの枠を出しておきます -->
                        <div style="width: 100%; height: 180px; background-color: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #aaa;">
                            画像未選択
                        </div>
                    </div>
                    <!-- 1. 商品画像をローカルから選択してアップロードするボタン -->
                    <div class="file-input-box">
                        <input type="file" name="product_image">
                    </div>
                </div>

                <!-- 右側：商品名入力 ➔ 値段入力 ➔ 季節選択 -->
                <div class="detail-right-box">
                    
                    <!-- 商品名入力グループ -->
                    <div class="input-group">
                        <label class="section-title">商品名</label>
                        <!-- 新しく入力してもらうので、value（初期値）は無しで、プレースホルダーを出します -->
                        <input type="text" name="name" class="detail-input" placeholder="商品名を入力してください">
                        @error('name')<!-- 💡 もし名前（name）にエラーがあったら、そのメッセージを出しなさいという命令 -->
                            <p style="color: red; margin: 5px 0 0  0; font-size: 14px;">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- 値段入力グループ -->
                    <div class="input-group">
                        <label class="section-title">値段</label>
                        <input type="number" name="price" class="detail-input" placeholder="価格を入力してください">
                        @error('price')
                            <p style="color: red; margin: 5px 0 0 0; font-size: 14px;">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- 季節（要件：複数選択ができるようにチェックボックスに進化させました！） -->
                    <div class="detail-season-box">
                        <p class="section-title">季節</p>
                        <!-- 💡 name="seasons[]" と後ろに四角カッコをつけることで、複数選んだ時にデータが綺麗にまとまってPHPに届きます -->
                        <!-- 💡 要件通り、最初（デフォルト）は何もチェックをつけない未選択の状態にしています -->
                        <label><input type="checkbox" name="seasons[]" value="1">春</label>
                        <label><input type="checkbox" name="seasons[]" value="2">夏</label>
                        <label><input type="checkbox" name="seasons[]" value="3">秋</label>
                        <label><input type="checkbox" name="seasons[]" value="4">冬</label>
                    </div>
                    @error('seasons')<!-- 💡注意：FormRequestのルール名に合せて「seasons」にします -->
                        <p style="color: red; margin:5px 0 0 0; font-size: 14px;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- 【下半分】商品説明入力 ＆ ボタンエリア -->
            <div class="detail-bottom-section">
                
                <!-- 商品説明入力グループ -->
                <div class="input-group">
                    <p class="section-title">商品説明</p>
                    <textarea name="description" class="detail-textarea" rows="5" placeholder="商品の説明文を入力してください"></textarea>
                    @error('description')
                        <p style="color: red; margin: 5px 0 0 0; font-size: 14px;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- アクションボタン（戻る・登録する） -->
                <div class="detail-footer-actions">
                    <!-- 左側：戻るボタン（一覧ページへ遷移するリンクです） -->
                    <a href="{{ route('products.index') }}" class="back-btn">戻る</a>
                    
                    <!-- 中央：1.「登録」ボタンをクリックするとデータベースへ商品情報が保存されるボタン -->
                    <!-- データを送信するので type="submit" になっています -->
                    <button type="submit" class="save-btn">商品情報を登録する</button>
                </div>

            </div>

        </div>

    </form>

</body>
</html>

