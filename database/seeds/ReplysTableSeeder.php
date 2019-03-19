<?php

use Illuminate\Database\Seeder;
use App\Models\Reply;
use App\Models\User;
use App\Models\Topic;
class ReplysTableSeeder extends Seeder
{
    public function run()
    {
        //所有用户ID,如:[1,2,3,4]
        $users_id=User::all()->pluck('id')->toArray();
        //所有帖子ID,如:[1,3,4,5]
        $topics_id=Topic::all()->pluck('id')->toArray();
        //获取faker实例
        $faker=app(Faker\Generator::class);
        $replys=factory(Reply::class)
                        ->times(1000)
                        ->make()
                        ->each(function ($reply,$index)
                           use ($users_id,$topics_id,$faker)
        {
            $reply->user_id=$faker->randomElement($users_id);
            $reply->topic_id=$faker->randomElement($topics_id);
        });

        Reply::insert($replys->toArray());
    }

}

