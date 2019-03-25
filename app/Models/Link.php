<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cache;
class Link extends Model
{
    //
    protected $fillable=['title','link'];
    public $cache_key='larabss_links';
    protected $cache_expire_in_minutes=1440;

    public function getAllCached(){
        //常识从缓存中取出cache_key对应的值,如果能取到就直接返回
        //否则就运行匿名函数中的代码来取出links表中的所有数据,返回的同时做了缓存
        return Cache::remember($this->cache_key,$this->cache_expire_in_minutes,  function () {
            return $this->all();
        });
    }
}
