<?php

use Illuminate\Database\Seeder;
use App\Models\Topic;
use App\Models\User;
use App\Models\Category;

class TopicsTableSeeder extends Seeder
{
    public function run()
    {
        //所有用户ID的数组,如[1,2,3,4,5,6]
        $user_ids = User::all()->pluck('id')->toArray();
        //所有帖子分类ID数组,如p[1,2,3,4]
        $category_ids = Category::all()->pluck('id')->toArray();

        //获取faker实例
        $faker= app(Faker\Generator::class);
        $topics = factory(Topic::class)
            ->times(100)
            ->make()
            ->each(function ($topic, $index)
            use ($user_ids, $category_ids,$faker) {
                //从用户ID数组中随机取一个赋值给帖子
                $topic->user_id = $faker->randomElement($user_ids);
                //从分类ID里面随机取一个
                $topic->category_id = $faker->randomElement($category_ids);
            });
        //将数组集合转换为数组,并入库
        Topic::insert($topics->toArray());
    }
}
