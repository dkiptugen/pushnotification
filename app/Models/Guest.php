<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Notifications\Notifiable;
use NotificationChannels\WebPush\HasPushSubscriptions;

class Guest extends Model
{
    use HasFactory, Notifiable, HasPushSubscriptions;

    protected $fillable = [
        'endpoint','product_id'
    ];
    public function product()
        {
            return $this->belongsTo(Product::class);
        }
    /**
     * Determine if the given subscription belongs to this user.
     *
     * @param  \NotificationChannels\WebPush\PushSubscription $subscription
     * @return bool
     */

    public function pushSubscriptionBelongsToUser($subscription){
        return (int) $subscription->subscribable_id === (int) $this->id;
    }

}
