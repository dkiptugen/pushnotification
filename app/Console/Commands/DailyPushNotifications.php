<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;


use App\Notifications\PushNotifications;
use App\Models\Guest;
use Notification;
use Illuminate\Support\Facades\Http;

class DailyPushNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'PushNotification:Daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute daily push notification to the users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public $response;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->response = Http::withHeaders([
            'appkey' => '3UhZEQ9pSQ6GxGh4hZbwvzWRvLqX6CrrNjH49MkLxxXSF'
        ])->get('https://www.standardmedia.co.ke/analytics/stories', [
            'size' => 1,
            'offset' => 3,
            'source' => 'business',
        ])->json()[0];
        

        $Guest = Guest::chunk(200, function ($guests) {
            foreach ($guests as $guest) {
                Notification::send($guest, new PushNotifications($this->response));
            }
        });
         
        $this->info('Notification sent!!');
    }
}
