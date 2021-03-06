<?php 

use App\Models\Category;

return [
    'title'=>'分类',
    'single'=>'分类',
    'model'=>Category::class,
    
    //对CRUD动作的单独权限控制,其他动作不指定默认为通过
    'action_permission'=>[
        //对删除权限控制
        'delete'=>function (){
            //只有站长才能删除分类话题
            return Auth::user()->hasRole('Founder');
        },
    ],
    'columns'=>[
        'id'=>[
            'title'=>'ID',
        ],
        'name'=>[
            'title'=>'名称',
            'sortable'=>false,
        ],
        'description'=>[
            'title'=>'描述',
            'sortable'=>false,
        ],
        'operation'=>[
           'title' =>"管理",
           'sortable'=>false,
        ],
    ],
    'edit_fields'=>[
        'name'=>[
            'title'=>'名称',
        ],
        'description'=>[
            'title'=>"描述",
            'type'=>'textarea',
        ],
    ],
    'filters'=>[
        'id'=>[
            'title'=>'分类ID',
        ],
        'name'=>[
            'title'=>"名称",
        ],
        'description'=>[
            'title'=>'描述',
        ],
    ],
    'rules'=>[
        'name'=>'required|min:1|unique:categories'
    ],
    'messages'=>[
        'name.unique'=>"分类名在数据库中存在,请选用其他名称",
        'name.required'=>'请确保名称在一个字符以上',
    ],
];