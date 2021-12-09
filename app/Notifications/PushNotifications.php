<?php

namespace App\Notifications;

use App\Models\User;
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
    public $guest;
    public function __construct($response,$guest)
    {
        $this->notificationData =   $response;
        $this->guest            =   $guest;
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
    public function generate(string $name) : string
        {
            $words = explode(' ', $name);
            if (count($words) >= 2)
                {
                    return strtoupper(substr($words[0], 0, 1) . substr(end($words), 0, 1));
                }
            preg_match_all('#([A-Z]+)#', $name, $capitals);
            if (count($capitals[1]) >= 2)
                {
                    return substr(implode('', $capitals[1]), 0, 2);
                }
            return strtoupper(substr($name, 0, 2));
        }
    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage|WebPushMessage
     */

    public function toWebPush($notifiable, $notification)
        {
            $user       =   User::find($this->notificationData->user_id);
            $initial    =   $this->generate($user->name);
            $title      =   $this->notificationData->title;
            $thumbnail  =   $this->notificationData->thumbnail;
            $url        =   $this->notificationData->link."?utm_source=".$initial."&utm_medium=BoxAlert&utm_campaign=".$this->notificationData->title;
            $body       =   $this->notificationData->summary;
            $icon       =   url($this->notificationData->product->logo);
            $ttl        =   $this->notificationData->ttl??(3600*24*30);
            Log::info(json_encode($this->notificationData));
            if (preg_match("/\bmozilla\b/i",$this->guest))
                {
                    return  (new WebPushMessage())
                        ->title($title)
                        ->icon($thumbnail)
                        ->body(strip_tags($body))
                        ->action('Read More', 'view_notification')
                        ->image($thumbnail)
                        ->data(['url' => $url])
                        ->options(['ttl'=>$ttl,'id'=>$this->notificationData->id,'via'=>$this->notificationData->product->domain,'vibrate'=>[100,50,100]]);
                }
            else
                {
                    return  (new WebPushMessage())
                        ->title($title)
                        ->icon($icon)
                        ->body(strip_tags($body))
                        ->action('Read More', 'view_notification')
                        ->image($thumbnail)
                        ->data(['url' => $url])
                        ->options(['ttl'=>$ttl,'id'=>$this->notificationData->id,'via'=>$this->notificationData->product->domain,'vibrate'=>[100,50,100]]);
                }



        }

}
