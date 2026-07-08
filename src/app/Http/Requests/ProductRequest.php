<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;// 💡 誰でもこのチェックを使えるように「true（許可）」に変えます
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {/**
     * 2. バリデーションルール（名札を seasons に統一しました！）
     */
        return [
            'name' => 'required' ,// 商品名は入力必須
            'price' => 'required|numeric|between:0,10000',// 値段は必須・数値のみ・0〜1万の間
            'product_image' => 'required|image|mimes:jpeg,png',// 画像は必須・jpegかpng形式のみ
            'seasons' => 'required' ,// 季節は選択必須
            'description' => 'required|max:120'//// 商品説明は必須・120文字以内

        ];
    }

    /**
     * 3. 💡【新機能】英語のエラーメッセージを日本語に翻訳する設定（追加！）
     */
    public function messages()
    {
        return [
            // 商品名
            'name.required' =>'商品名を入力してください',
            //値段
            'price.required' =>'値段で入力してください',
            'price.numeric' =>'数値で入力してください',
            'price.between' =>'0〜10000円以内で入力してください',
            //画像
            'product_image.required' =>'画像を登録してください',
            'product_image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
            //季節（s付きに統一）
            'seasons.required' => '季節を選択してください',
            //商品説明
            'description.required' => '商品説明を入力してください',
            'description.max' => '120文字以内で入力してください',
            ];
    }
}

