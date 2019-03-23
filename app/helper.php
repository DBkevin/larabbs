<?php
function route_class()
{
    //获取当前路由名称,吧'.'替换为-后返回
    return str_replace('.', '-', Route::currentRouteAction());
}
/**
 * 判定是否给active
 *
 * @param [int] $category_id
 * @return void
 */
function category_nav_active($category_id)
{
    return  active_class(if_route('categories.show') && if_route_param('category', $category_id));
    //return  active_class(if_route('categories.show') && if_route_param('category', $category_id),"aaaa",'bbb');
}
/**
 * 生成文章摘要
 *
 * @param [string] $value
 * @param integer $length
 * @return string 文章摘要 
 */
function make_excerpt($value,$length=20){
    $excerpt=trim(preg_replace('/\r\n|\r|\n+/','',strip_tags($value)));
    return str_limit($excerpt,$length);
}

function model_admin_link($title,$model){
    return model_link($title,$model,'admin');
}
function model_link($title,$model,$prefix=''){
    //获取数据模型的复数蛇形命名
    $model_name=model_plural_name($model);
    //初始化前缀
    $prefix=$prefix? "/$prefix/":'/';
    //使用站点URL拼接全量URL
    $url=config('app.url').$prefix.$model_name.'/'.$model->id;
    //拼接HTML A标签,并返回
    return '<a href="'.$url.'"target="_blank">'.$title."</a>";
}


function model_plural_name($model){
    //从实体中获取完整类名,如:App\Models\User
    $full_class_name=get_class($model);
    //获取基础类名,例如:传参 `App\Models\User` 会得到 `User`
    $class_name=class_basename($full_class_name);
    //蛇形名,如传参 `User`  会得到 `user`, `FooBar` 会得到 `foo_bar`
    $snake_case_name=snake_case($class_name);
    //获取子串的复数行是,如传参 `user` 会得到 `users`
    return str_plural($snake_case_name);
}
