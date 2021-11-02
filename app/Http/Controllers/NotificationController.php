<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddNotification;
use App\Jobs\Dispatcher;
use App\Jobs\TelegramPush;
use App\Models\Guest;
use App\Models\Product;
use App\Models\Stories;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class NotificationController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Illuminate\View\View
         */
        public function index($productid)
            {
                $this->data['product']  =   Product::find($productid);
                return view('modules.posts.index',$this->data);
            }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Illuminate\View\View
         */
        public function create($productid)
            {
                $this->data['product']  =   Product::find($productid);
                return view('modules.posts.add',$this->data);
            }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return array|\Illuminate\Http\RedirectResponse
         */
        public function store($productid,AddNotification $request)
            {
                $validateddata = $request->validated();
                if($validateddata)
                    {

                        $stories = Stories::create([
                                                        "title"         =>  $request->title,
                                                        "link"          =>  $request->link,
                                                        "thumbnail"     =>  $request->thumbnail,
                                                        "ttl"           =>  ($request->ttl * 3600 * 24),
                                                        "publishdate"   =>  Carbon::parse($request->publishdate)->format('Y-m-d H:i:s'),
                                                        "summary"       =>  strip_tags($request->summary),
                                                        "product_id"    =>  $productid,
                                                        "user_id"       =>  Auth::user()->id
                                                   ]);

                        if ($stories)
                            {

                                $to     =   Carbon::createFromFormat('Y-m-d H:i a', $request->publishdate);
                                $from   =   Carbon::now();
                                $time   =   $to->diffInMinutes($from);
                                Log::info($time);
                                //dd($time);
                                if($time >= 1)
                                    {
                                        Dispatcher::dispatch($stories)->delay($time*60);
                                        TelegramPush::dispatch($stories)->delay($time*60);
                                    }
                                else
                                    {
                                        Dispatcher::dispatch($stories);
                                        TelegramPush::dispatch($stories);
                                    }
                                return self::success('Notification','queued successfully',route('product.notification.index',$productid));
                            }
                        return self::fail('Notification', 'Failed to queue notification',route('product.notification.index',$productid));
                    }
                return self::fail('Notification', $validateddata,route('product.notification.index',$productid));

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
        public function subscribers($limit,$start=0)
            {
                $subscribers = Guest::offset($start)
                                    ->limit($limit)
                                    ->get();
                return $subscribers->toJson();
            }
        public function subscribe(Request $request)
            {
                Log::error('Re :',$request->all());
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
                return response()->json(['success' => true], 200);

            }
        public function unsubscribe(Request $request,$id)
            {
                $user = Guest::find($id);
                $user->deletePushSubscription($request->endpoint);

            }
        public function pd($publishdate)
            {

                $otherDate  =   Carbon::parse($publishdate);
                $nowDate    =   Carbon::now();
                $result     =   $nowDate->gt($otherDate);
                return $result;

            }
        public function get($id,Request $request)
            {
                $columns = array(
                                    0   =>  'id',
                                    1   =>  'title',
                                    2   =>  'created_at',
                                    3   =>  'user_id',
                                    4   =>  'status'

                                );

                $totalData      =   Stories::where('product_id',$id)
                                            ->count();
                $totalFiltered  =   $totalData;
                $limit          =   $request->input('length');
                $start          =   $request->input('start');
                $order          =   $columns[$request->input('order.0.column')];
                $dir            =   $request->input('order.0.dir');
                if(empty($request->input('search.value')))
                    {
                        $posts = Stories::where('product_id',$id)
                                        ->offset($start)
                                        ->limit($limit)
                                        ->orderBy($order,$dir)
                                        ->get();
                    }
                else
                    {
                        $search =   $request->input('search.value');

                        $posts  =   Stories::where('product_id',$id)
                                            ->whereHas("product",function ($subquery) use($search){
                                                                    $subquery->where('name','LIKE',"%{$search}%");
                                                                })
                                            ->orWhere('title','LIKE',"%{$search}%")
                                            ->offset($start)
                                            ->limit($limit)
                                            ->orderBy($order,$dir)
                                            ->get();

                        $totalFiltered =Stories::where('product_id',$id)
                                                ->whereHas("product",function ($subquery) use($search){
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
                                $nestedData['clicks']           =   $post->clicks;
                                $nestedData['publishdate']      =   $post->publishdate;
                                $nestedData['onschedule']       =   $this->pd($post->publishdate)?'Yes':'No';
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
