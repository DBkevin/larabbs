<?php

namespace App\Models;

class Topic extends Model
{
    protected $fillable = ['title', 'body', 'user_id', 'category_id', 'reply_count', 'view_count', 'last_reply_user_id', 'order', 'excerpt', 'slug'];
    public function category()
    { 
        //1对1关联,相对关联
        //因为一个文章只有一个分类ID
        return $this->belongsTo(Category::class);
    }
    public function user(){
        //1对1关联,相对关联用beLogsTo
        //因为一个文章只有一个用户
        return $this->belongsTo(User::class);
    }

}
