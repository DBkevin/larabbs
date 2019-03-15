<?php
function route_class(){
    //获取当前路由名称,吧'.'替换为-后返回
    return str_replace('.','-',Route::currentRouteAction());
}