<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Notifications\PushNotifications;
use App\Models\Guest;
use Auth;
use DB;
use Notification;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class PushController extends Controller
{

     
    public function __construct(){
        ini_set('memory_limit', '3000M');
        ini_set('max_execution_time', '0');
    }
    

    /**
     * Store the PushSubscription.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request){
        $this->validate($request,[
            'endpoint'    => 'required',
            'keys.auth'   => 'required',
            'keys.p256dh' => 'required'
        ]);
        $endpoint = $request->endpoint;
        $token = $request->keys['auth'];
        $key = $request->keys['p256dh'];
        //$user = Auth::user();
        $user = Guest::firstOrCreate([
            'endpoint' => $endpoint
        ]);
        $user->updatePushSubscription($endpoint, $key, $token);
        
        
        return response()->json(['success' => true],200);
    }

    public function push(){
        
        
        $response = Http::withHeaders([
            'appkey' => '3UhZEQ9pSQ6GxGh4hZbwvzWRvLqX6CrrNjH49MkLxxXSF'
        ])->get('https://www.standardmedia.co.ke/analytics/stories', [
            'size' => 1,
            'offset' => 1,
        ])->json()[0];

        Guest::chunk(200, function ($guests) {
            foreach ($guests as $guest) {
                dd($guest);
            }
        });


        dd($response);


        Log::info($response);
        $notifications = Notification::send(Guest::all(),new PushNotifications($response));
       

        Log::error($notifications);
        
        //return redirect()->back();
        

    }
    
}