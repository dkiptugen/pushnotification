<?php

namespace App\Jobs;

use App\Utils\TelegramPost;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TelegramPush implements ShouldQueue
    {
        use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
        public $stories;
        /**
         * Create a new job instance.
         *
         * @return void
         */
        public function __construct($stories)
            {
                $this->stories = $stories;
            }

        /**
         * Execute the job.
         *
         * @return void
         */
        public function handle()
            {
                if(!is_null($this->stories->product->telegram_channel))
                    {
                        $telegram   =   new TelegramPost([  'title'                 =>  $this->stories->title,
                                                            'telegram_access_token' =>  $this->stories->product->telegram_access_token,
                                                            'telegram_channel'      =>  $this->stories->product->telegram_channel,
                                                            'image'                 =>  $this->stories->thumbnail,
                                                            'url'                   =>  $this->stories->link,
                                                            'content'               =>  $this->stories->summary
                                                        ]);
                        $telegram->post_data();
                    }
                //Log::info(json_encode($stories));
            }
    }
