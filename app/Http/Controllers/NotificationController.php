<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Stories;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class NotificationController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Illuminate\View\View
         */
        public function index()
            {
                return view('modules.posts.index',$this->data);
            }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Illuminate\View\View
         */
        public function create()
            {
                return view('modules.posts.add',$this->data);
            }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\RedirectResponse
         */
        public function store(Request $request)
            {
                $this->validate($request, [
                    'title' => 'required',
                    'link' => 'required',
                    'thumbnail' => 'required',
                    'summary' => 'required'
                ]);

                $stories = Stories::create(["title" => $request->title, "link" => $request->link, "thumbnail" => $request->thumbnail, "summary" => $request->summary, "product_id" => $request->product]);

                if ($stories)
                    {

                        Session::flash('message', 'Notifications Queued!');

                        return redirect()->back();

                    }
                return Session::flash('error', 'Failed check your inputs');

            }

        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function show($id)
            {
                //
            }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function edit($id)
            {
                //
            }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, $id)
            {
                //
            }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function destroy($id)
            {
                //
            }
        public function subscribe(Request $request)
            {
                $this->validate($request, [
                    'endpoint' => 'required',
                    'keys.auth' => 'required',
                    'keys.p256dh' => 'required'
                ]);
                $endpoint   =   $request->endpoint;
                $token      =   $request->keys['auth'];
                $key        =   $request->keys['p256dh'];
                //$user = Auth::user();
                $user = Guest::firstOrCreate([
                    'endpoint' => $endpoint
                ]);
                $user->updatePushSubscription($endpoint, $key, $token);


                return response()->json(['success' => true], 200);
            }
        public function send(Request $request)
            {
                $url        =   'https://fcm.googleapis.com/fcm/send';
                $FcmToken   =   User::whereNotNull('device_key')->pluck('device_key')->all();

                $dt         =   [
                                    "registration_ids"  =>  $FcmToken,
                                    "notification"      =>  [
                                                                "title" => $request->title,
                                                                "body"  => $request->body,
                                                            ]
                                ];
                $data   =   Http::withHeaders(['Authorization:key=' . env('FCM_KEY'), 'Content-Type: application/json'])
                                ->withOptions(['verify'=>app_path('Resources/cacert.pem'),'http_errors'=>FALSE])
                                ->post($url,$dt);

                if($data->successful())
                    {
                        return $data->object();
                    }
            }
        public function get(Request $request)
            {
                $columns = array(
                                    0   =>  'id',
                                    1   =>  'title',
                                    2   =>  'created_at',
                                    3   =>  'user_id',
                                    4   =>  'status'

                                );

                $totalData      =   Stories::count();
                $totalFiltered  =   $totalData;
                $limit          =   $request->input('length');
                $start          =   $request->input('start');
                $order          =   $columns[$request->input('order.0.column')];
                $dir            =   $request->input('order.0.dir');
                if(empty($request->input('search.value')))
                    {
                        $posts = Stories::offset($start)
                                        ->limit($limit)
                                        ->orderBy($order,$dir)
                                        ->get();
                    }
                else
                    {
                        $search =   $request->input('search.value');

                        $posts  =   Stories::whereHas("product",function ($subquery) use($search){
                                                    $subquery->where('name','LIKE',"%{$search}%");
                                                })
                                            ->orWhere('title','LIKE',"%{$search}%")
                                            ->offset($start)
                                            ->limit($limit)
                                            ->orderBy($order,$dir)
                                            ->get();

                        $totalFiltered =Stories::whereHas("product",function ($subquery) use($search){
                                                        $subquery->where('name','LIKE',"%{$search}%");
                                                    })
                                                ->orWhere('title','LIKE',"%{$search}%")
                                                ->count();
                    }
                $data = array();
                if(!empty($posts))
                {
                    $pos    =   $start+1;
                    foreach ($posts as $post)
                    {

                        $nestedData['pos']              =   $pos;
                        $nestedData['title']            =   $post->title;
                        $nestedData['date']             =   $post->created_at;
                        $nestedData['deliveries']       =   $post->deliveries;
                        $nestedData['author']           =   $post->user->name;
                        $nestedData['status']           =   ($post->status == 2)?"sent":(($post->status == 1)?'picked':'pending');
                        $nestedData['provider']         =   $post->provider->name;

                        $data[] = $nestedData;
                        $pos++;
                    }
                }

                $json_data = array("draw" => (int)$request->input('draw'), "recordsTotal" => $totalData, "recordsFiltered" => $totalFiltered, "data" => $data);
                echo json_encode($json_data);
            }
    }
