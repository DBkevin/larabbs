<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // 允许写入字段,使用protected 不允许别的地方修改
    protected $fillable=[
        'name','description',
    ];
}
