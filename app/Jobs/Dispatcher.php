<?php

namespace App\Jobs;

use App\Models\Dispatch;
use App\Models\Guest;
use App\Models\Stories;
use App\Utils\TelegramPost;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class Dispatcher implements ShouldQueue
    {
        use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

        /**
         * Create a new job instance.
         *
         * @return void
         */
        public $data;
        public function __construct($data)
            {
                $this->data = $data;
            }

        /**
         * Execute the job.
         *
         * @return void
         */
        public function handle()
            {
                //Log::info($this->data->product_id);

                Guest::where('product_id',$this->data->product_id)
                    ->chunk(2000, function ($subscriptions) {
                        if(!is_null($subscriptions))
                            {
                                foreach ($subscriptions as $subscription)
                                    {
                                        $dt[] = ['story_id' =>$this->data->id,'guest_id'=>$subscription->id,'status'=>0 ];
                                    }

                                if(!is_null($dt))
                                    Dispatch::insert($dt);
                            }

                    });
                Sender::dispatch($this->data->id);
                $story          =   Stories::find($this->data->id);
                $story->status  =   1;
                $story->save();

            }
    }
