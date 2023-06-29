<?php

namespace App\Jobs;

use App\Models\Dispatch;
use App\Models\Guest;
use App\Models\Stories;
use App\Notifications\PushNotifications;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;


class Sender implements ShouldQueue
    {
        use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

        /**
         * Create a new job instance.
         *
         * @return void
         */
        public $msgid;
        public function __construct($msgid)
            {
                $this->msgid = $msgid;
            }

        /**
         * Execute the job.
         *
         * @return void
         */
        public function handle()
            {
                $response   =   Stories::find($this->msgid);
                $Dispatch   =   Dispatch::where('story_id',$this->msgid)
                                        ->where('status',0)
                                        ->chunkById(2000, function ($dispatches) use($response)
                                            {
                                                 foreach ($dispatches as $dispatch)
                                                    {
                                                        Notification::send($dispatch->guest, new PushNotifications($response,$dispatch->guest));
                                                        $x  =   Dispatch::find($dispatch->id);
                                                        $x->update(['status' => 1]);
                                                        $response->increment('deliveries');
                                                        $response->save();
                                                    }
                                            }, $column = 'id');
                $response->status = 2;
                $response->save();
                Dispatch::where('story_id',$this->msgid)
                        ->delete();

                //Log::info($Dispatch);
            }
    }
