<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Notifications\PushNotifications;
use App\Models\Guest;
use App\Models\Epaper;


use Notification;

class EpaperOfTheDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'epaper:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Push a new epaper edition to people daily';

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
        


        $old_epaper = Epaper::latest('updated_at')->first();
        if($old_epaper != null){
            
            $dt = Carbon::parse($old_epaper->updated_at);
            $story_date = $dt->format('Y-m-d');

            // if current date is greater than updated date on db we create a new story
            if(date('Y-m-d') > $story_date){
                DB::table('epaper')->insert([
                    "title" => "The Standard Epaper is Ready - " . date('d/m/Y'),
                    "link" => "https://epaper.standardmedia.co.ke/",
                    "thumbnail" => (int)$old_epaper->thumbnail + 1,
                    "summary" => "Fetch the summary from somewhere first",
                    "created_at" => now(),
                    "updated_at" => now(),
                ]);
            }
        }
    
        $epaper = Epaper::latest('updated_at')->first();
        
        if($epaper != null){
            
            
            if($epaper->flag == 0){
                //$epaper->thumbnail = "https://epaper.standardmedia.co.ke/images/the_standard/" . "100" . "/1.jpg";
                
                $epaper->thumbnail = "https://epaper.standardmedia.co.ke/images/the_standard/" . "$epaper->thumbnail" . "/1.jpg";
                
                if(($epaper->offset + 10000) >= $total_guests){

                    $guests = Guest::skip($epaper->offset)->take($total_guests - $epaper->offset)->get();

                    foreach($guests as $guest){
                        Notification::send($guest, new PushNotifications($epaper));
                    }

                    //create notification for this guests
                    //Notification::send($guests, new PushNotifications($epaper));
                    
                    //Update the epaper flag to 1 and offset to 0
                    $epaper->flag = 1;
                    $epaper->offset = 0;
                    $epaper->save();
    
                    return $this->info('All Notification Queued');
                    
                } else {
                    //prepare for the iterations here i.e. increment the offset value then take 10000 guests to queue them
                    $guests = Guest::skip($epaper->offset)->take(10000)->get();

                    foreach($guests as $guest){
                        Notification::send($guest, new PushNotifications($epaper)); 
                    }
                    
                    //increment the offset by 10000
                    $epaper->offset = $epaper->offset + 10000;
                    $epaper->save();
    
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
