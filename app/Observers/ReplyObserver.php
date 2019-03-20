<?php

namespace App\Observers;

use App\Models\Reply;

use App\Notifications\TopicReplied;
// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function created(Reply $reply)
    {
        $reply->topic->updateReplyCount();
        //通知话题作者有新评论
        $reply->topic->user->notify(new TopicReplied($reply));
    }
    public function deleted(Reply $reply)
    {
        $reply->topic->updateReplyCount();
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
            $content = "违规内容已屏蔽";
        }
        $reply->content = $content;
        //不严谨的做法
        // $reply->topic->increment('reply_count',1);
        $reply->topic->updateRepleCount();
    }
}
