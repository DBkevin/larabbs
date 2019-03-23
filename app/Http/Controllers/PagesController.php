<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    //
    public function root(){
        return view('pages.root');
    }
    public function help(){
        return view('pages.help');
    }
    public function about(){
        return view('pages.about');
    }
    public function permissionDenied(){
        //如果当前用户有全新访问后台,直接跳转访问
        if(config('administrator.permission')()){
            return redirect(url(config('administrator.uri')), 302);
        }
        //否则使用视图
        return view('pages.permission_denied');
    }
}
