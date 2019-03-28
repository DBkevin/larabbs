<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Auth;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmailContract
{
    use Traits\ActiveUserHelper;
    use Traits\LastActivedAtHelper;
    use MustVerifyEmailTrait;
    use HasRoles; //权限控制
    use Notifiable{
        notify as protected laravelNotify;
    }
    public function notify($instance){
        //如果要通知的人是当前用户,就不要用通知了
        if($this->id==Auth::id()){
            return;
        }
        //只有数据库类型通知才需要提醒,直接发送email或者其他的都pass
        if(method_exists($instance,'toDatabase')){
            $this->increment('notification_count');
        }
        $this->laravelNotify($instance);
    }
    /**
     * 清除评论
     *
     * @return void
     */
      public function markAsRead()
    {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }
    /**
     * 密码修改器
     *
     * @param [type] $value
     * @return void
     */
    public function setPasswordAttribute($value){
        //如果值得长度等于60,既认为是做过加密的情况
        if(strlen($value)!=60){
            //不等于60,做密码加密
            $value=bcrypt($value);
        }
        $this->attributes['password']=$value;
    }
    public function setAvatarAttribute($path){
        //如果不是'http'字串开头,那就是从后台上传的,需要补全URL
        if(!starts_with($path,'http')){
            //拼接完整的URL
            $path=config('app.url')."/uploads/images/avatars/$path";
        }
        $this->attributes['avatar']=$path;
    }
    /**
     * 
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'introduction', 'avatar','phone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function replies(){
        return $this->hasMany(Reply::class);
    }

    public function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }
}
