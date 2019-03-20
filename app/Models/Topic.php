<?php

namespace App\Models;

class Topic extends Model
{
    protected $fillable = ['title', 'body', 'category_id',  'excerpt', 'slug'];
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

    public function replies(){
        return $this->hasMany(Reply::class);
    }
    public function scopeWithOrder($query,$order){
        //不同的排序,使用不同的数据读取逻辑
        switch($order){
            case'recent':
                $query->recent();
                break;
            default:
                $query->recentRepied();
                break;
        }
        //预加载,防止N+1问题
        return $query->with('user','category');
    }

    public function scopeRecentRepied($query)
    {
        //当话题有新回复时,我们将编写逻辑赖更新话题模型reply_count的属性
        //此时会自动触发框架对数据模型得updated_at进行更新
        return $query->orderBy('updated_at','desc');
    }
    public function scopeRecent($query){
        return $query->orderBy('created_at','desc');
    }

    public function like($params=[]){
      return route('topics.show', array_merge([$this->id, $this->slug], $params));
    }
    /**
     * 更新回复数量
     *
     * @return void
     */
    public function updateReplyCount(){
        $this->reply_count=$this->replies->count();
        $this->save();
    }
}
