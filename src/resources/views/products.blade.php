@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/products.css') }}">

@section('content')
<div class="products__content">
  <div class="products__heading">
    <h1>商品一覧</h1>
  </div>
  <form class="search-form" action="/products/search" method="get">
    @csrf
    <div class="search-form__item">
      <input class="search-form__item-input" type="text" />
    </div>
    <div class="search-form__button">
      <button class="search-form__button-submit" type="submit">検索</button>
    </div>
  </form>


  <img alt="画像" src="{{ asset('images/kiwi.png') }}" alt="キウイ画像">

</div>







@endsection