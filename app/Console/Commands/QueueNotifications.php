<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Notifications\PushNotifications;
use App\Models\Guest;
use App\Models\Stories;
use Notification;

use Illuminate\Support\Facades\DB;

class QueueNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'QueueNotifications:Daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command queues the notifications on form submission';

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
        $total_guests = DB::table('guests')->count();
        return $this->info($total_guests);
        $stories = Stories::latest('updated_at')->first();
        if($stories != null){
            if($stories->flag == 0){
                if(($stories->offset + 1000) >= $total_guests){
                    $guests = DB::table('guests')->skip($stories->offset)->take($total_guests - $stories->offset);
    
                    //create notification for this guests                    
                    Notification::send($guests, new PushNotifications($stories));
                    
                    //Update the stories flag to 1 and offset to 0
                    $stories->flag = 1;
                    $stories->offset = 0;
                    $stories->save();
    
                    return $this->info('All Notification Queued');
                    
                } else {
                    //prepare for the iterations here i.e. increment the offset value then take 1000 guests to queue them
                    $guests = DB::table('guests')->skip($stories->offset)->take(1000);
                    
                    Notification::send($guests, new PushNotifications($stories));
                    
                    //increment the offset by 1000
                    $stories->offset = $stories->offset + 1000;
                    $stories->save();
    
                    return $this->info('Notifications Batch Queued');
                }     
            } else {
                return $this->info('No New Story to Send');
            }
        } else {
            return $this->info('No story added');
        }
        
    }
}
