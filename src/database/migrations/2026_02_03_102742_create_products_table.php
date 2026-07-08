<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 'products' という名前のテーブル（倉庫の棚）を作ります
        Schema::create('products', function (Blueprint $table) {
            $table->id();// 自動で1, 2, 3...と増える背番号（ID）
            $table->string('name');// 商品名を保存する場所（文字列）
            $table->integer('price'); // 価格を保存する場所（整数・数字）
            $table->string('image');// 画像ファイル名を保存する場所。
            $table->text('description',120);//description (最大120文字の文字入力欄,
            $table->timestamp('created_at')->useCurrent()->nullable();
            $table->timestamp('updated_at')->useCurrent()->nullable();
            // 作成日時と更新日時を自動で記録する場所
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');// もしすでに 'products' テーブルがあったら削除します
    }
}
