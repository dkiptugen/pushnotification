<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use Illuminate\Support\Facades\Log;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;



class PushNotifications extends Notification implements ShouldQueue

{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    public $notificationData;
    public function __construct($response)
    {
        $this->notificationData = (object)$response;
    }



    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [WebPushChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage|WebPushMessage
     */
    public function toWebPush($notifiable, $notification)
        {

            //Notification data

            //$id = $this->notificationData->id;
            $title      =   $this->notificationData->title;
            $thumbnail  =   $this->notificationData->thumbnail;
            $url        =   $this->notificationData->link ."?utm_source=Pushnotification&utm_medium=notification&utm_campaign=". date("FY");
            $body       =   $this->notificationData->summary;
            $icon       =   asset($this->notificationData->product->logo);
            Log::info(json_encode($this->notificationData));
            $data =  (new WebPushMessage())
                        ->title($title)
                        ->icon($icon)
                        ->body($body)
                        ->action('Read More', 'view_notification')
                        ->image($thumbnail)
                        ->data(['url' => $url]);
            dd($data);

        }

}
