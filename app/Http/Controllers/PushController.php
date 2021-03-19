<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Notifications\PushNotifications;
use App\Models\Guest;
use App\Models\User;
use App\Models\Stories;
use Auth;

use Notification;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PushController extends Controller
{

    public $response;
    public $pushRequest;
    public $i;
    public function __construct(){

        ini_set('memory_limit', '3000M');
        ini_set('max_execution_time', '0');

    }

    public function index()
    {
        return view('stories');
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

    public function fetchStories(){

        $response = Http::withHeaders([
            'appkey' => '3UhZEQ9pSQ6GxGh4hZbwvzWRvLqX6CrrNjH49MkLxxXSF'
        ])->get('https://www.standardmedia.co.ke/analytics/stories', [
            'size' => 1,
            'source' => 'business',
        ])->json()[0];

        return $response;
    }

    public function push(){
        
        
        $this->response = $this->fetchStories();
       
        $Guest = Guest::chunk(500, function ($guests) {
            foreach ($guests as $guest) {
                Notification::send($guest, new PushNotifications($this->response));
            }
        });
        
        return redirect()->back();
    }

    public function dynamicPushNotification(Request $request)
    {
        $this->validate($request,[
            'title'    => 'required',
            'link'   => 'required',
            'thumbnail' => 'required',
            'summary' => 'required'
        ]);

        $request = $request->all();
     
        $stories = Stories::create([
            "title" => $request['title'],
            "link" => $request['link'],
            "thumbnail" => $request['thumbnail'],
            "summary" => $request['summary'],
        ]);

        Session::flash('message', 'Notifications Queued!');

        return redirect()->back();

        /*
        $this->pushRequest = $request->all();

        $Guest = Guest::chunk(500, function ($guests) {

            foreach ($guests as $guest) {
                Notification::send($guest, new PushNotifications($this->pushRequest));
            }
            sleep(10);

        });
        */
    }

    public function displayStories()
    {
        $stories = Stories::all();
        return view('display_stories',['stories' => $stories]);
    }

    public function failedJobs()
    {
        $failed_jobs = DB::table('failed_jobs')->get();

        return view('failed_jobs', ['failed_jobs' => $failed_jobs]);

    }

    public function queuedJobs()
    {

        //DB::table('jobs')->delete();
        
        $queued_jobs = DB::table('jobs')->latest('created_at')->limit(2000)->get();

        return view('queued_jobs', ['queued_jobs' => $queued_jobs]);
    }
    
    
}