<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Reply;

class TopicReplied extends Notification  implements ShouldQueue
{
    use Queueable;
    public $reply;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Reply $reply)
    {
        $this->reply=$reply;
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        //return ['mail'];
        return ['database','mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url=$this->reply->topic->like(['#reply'.$this->reply->id]);
        $reply_name=$this->reply->user->name;
        $reply_content=$this->reply->content;
       return (new MailMessage)
              ->line($reply_name.'回复了您的话题')
              ->line('内容是'.$reply_content)
              ->action('查看回复',$url);

    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
    public function toDatabase($notifiable){
        $topic=$this->reply->topic;
        $link=$topic->like(['#reply'.$this->reply->id]);
        //存入数据库
        return[
            'reply_id'=>$this->reply->id,
            'reply_content'=>$this->reply->content,
            'user_id'=>$this->reply->user->id,
            'user_name'=>$this->reply->user->name,
            'user_avatar'=>$this->reply->user->avatar,
            'topic_link'=>$link,
            'topic_id'=>$topic->id,
            'topic_title'=>$topic->title,
        ];
    }
}
