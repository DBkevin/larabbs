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

