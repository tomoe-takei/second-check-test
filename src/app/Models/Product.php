<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
// 💻 Product.php の中に書くトンネルのコード
    public function seasons()
    {// 「Season（季節）と多対多で繋がります。 product_season という席次表を使いなさい」という命令
        return $this->belongsToMany(Season::class,'product_season','product_id','season_id');
    }
}
