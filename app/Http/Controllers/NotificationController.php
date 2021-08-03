<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddNotification;
use App\Jobs\Dispatcher;
use App\Models\Guest;
use App\Models\Product;
use App\Models\Stories;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
                $this->data['product']  =   Product::where('status',1)
                                                    ->get();
                return view('modules.posts.add',$this->data);
            }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return array|\Illuminate\Http\RedirectResponse
         */
        public function store(AddNotification $request)
            {
                $validateddata = $request->validated();
                if($validateddata)
                    {
                        $stories = Stories::create([
                                                        "title"         =>  $request->title,
                                                        "link"          =>  $request->link,
                                                        "thumbnail"     =>  $request->thumbnail,
                                                        "summary"       =>  $request->summary,
                                                        "product_id"    =>  $request->product,
                                                        "user_id"       =>  Auth::user()->id
                                                   ]);

                        if ($stories)
                        {
                            Dispatcher::dispatch($stories);
                            return self::success('Notification','queued successfully',url('backend/notification'));
                        }
                        return self::fail('Notification', 'Failed to queue notification',url('backend/notification'));
                    }
                return self::fail('Notification', $validateddata,url('backend/notification'));

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
        public function subscribers(Request $request)
            {
                $subscribers = Guest::offset($request->offset)
                                    ->limit($request->limit)
                                    ->get();
                return $subscribers->toJson();
            }
        public function subscribe(Request $request)
            {

                $this->validate($request,   [
                                                'endpoint' => 'required',
                                                'keys.auth' => 'required',
                                                'keys.p256dh' => 'required'
                                            ]);
                $endpoint   =   $request->endpoint;
                $token      =   $request->keys['auth'];
                $key        =   $request->keys['p256dh'];
                $product_id =   Product::where('domain', $request->domain)
                                        ->first()
                                        ->id;
                $check  =   Guest::where('endpoint',$request->endpoint)
                                ->first();
                if(is_null($check))
                    {
                        $user = Guest::firstOrCreate([
                                                        'endpoint' => $endpoint,
                                                        'product_id' => $product_id
                                                    ]);

                        if($user)
                            {
                                $product        =   Product::find($product_id);
                                $product->increment('subscriptions');
                                $product->save();
                            }
                        $user->updatePushSubscription($endpoint, $key, $token);
                        return response()->json(['success' => true], 200);
                    }
                return response()->json(['success' => false], 200);
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
                        $nestedData['date']             =   $post->created_at->format('h:ia d-m-Y');
                        $nestedData['deliveries']       =   $post->deliveries;
                        $nestedData['author']           =   $post->user->name;
                        $nestedData['status']           =   ($post->status == 2)?"sent":(($post->status == 1)?'picked':'pending');
                        $nestedData['product']          =   $post->product->name;

                        $data[] = $nestedData;
                        $pos++;
                    }
                }

                $json_data = array("draw" => (int)$request->input('draw'), "recordsTotal" => $totalData, "recordsFiltered" => $totalFiltered, "data" => $data);
                echo json_encode($json_data);
            }
    }
