<?php

namespace App\Observers;

use App\Models\Reply;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function creating(Reply $reply)
    {
        //
    }

    public function updating(Reply $reply)
    {
        //
    }
    public function saving(Reply $reply)
    {
        //过滤XSS
        //$reply->content=clean($reply->content,'user_topic_body');
        //判断过滤后是否为空
        $content = clean($reply->content, 'user_topic_body');
        if (empty($content)) {
            $content = '空';
        } else {
            $reply->content = $content;
            //不严谨的做法
            // $reply->topic->increment('reply_count',1);
            $reply->topic->reply_count = $reply->topic->replies->count();
            $reply->topic->save();
        }
    }
}

