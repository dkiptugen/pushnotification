<?php

namespace App\Jobs;

use App\Models\Guest;
use App\Notifications\PushNotifications;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;


class Sender implements ShouldQueue
    {
        use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

        /**
         * Create a new job instance.
         *
         * @return void
         */
        public function __construct()
            {
                //
            }

        /**
         * Execute the job.
         *
         * @return void
         */
        public function handle()
            {
                 $Guest = Guest::chunk(500, function ($guests) {
                     foreach ($guests as $guest) {
                         Notification::send($guest, new PushNotifications($this->response));
                     }
                 });


            }
    }
