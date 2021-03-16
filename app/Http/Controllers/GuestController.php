<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guest;

class GuestController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $subscribers = Guest::chunk(5000, function ($guests) {
            return view('subscribers', ['subscribers' => $subscribers]);
            /*
            foreach ($guests as $guest) {
                Notification::send($guest, new PushNotifications($this->response));
            }
            */
        });
       // $subscribers = Guest::all();

        //return view('subscribers', ['subscribers' => $subscribers]);
    }

    public function fetch_subscribed_users()
    {

        $subscribers = Guest::all();
        dd(json_encode($subscribers));
        //return view('subscribers', ['subscribers' => $subscribers]);
    }
}
