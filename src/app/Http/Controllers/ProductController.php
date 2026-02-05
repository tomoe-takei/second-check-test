<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ProductController extends Controller
{
    public function index()
    {
        return view('products');
    }

    public function products()
    {
        $users =User::all();

        return view('products',compact('users'));
    }


}
