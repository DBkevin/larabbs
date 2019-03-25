<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Category;
use App\Models\User;
class CategoriesController extends Controller
{
    //
    public function show(Category $category,Request $request,Topic $topic,User $user){
       // $topics=Topic::with('category','user')->where('category_id',$category->id)->paginate(20);
       $topics=$topic->withOrder($request->order)
                     ->where('category_id',$category->id)
                     ->paginate(20);
        $active_users=$user->getActiveUsers();
        return view('topics.index',compact('topics','category','active_users'));
    }
}
