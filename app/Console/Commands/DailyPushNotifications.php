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
        $response = Http::withHeaders([
            'appkey' => '3UhZEQ9pSQ6GxGh4hZbwvzWRvLqX6CrrNjH49MkLxxXSF'
        ])->get('https://www.standardmedia.co.ke/analytics/stories', [
            'size' => 1,
        ])->json()[0];

        //dd($response);

         
        Notification::send(Guest::all(),new PushNotifications($response));
         
        $this->info('Notification sent!!');
    }
}
