<?php

namespace App\Http\Controllers\Prime;

use App\Http\Requests\AddContent;
use App\Models\Content;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContentController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Illuminate\View\View
         */
        public function index()
            {
                return view('modules.prime.content.index',$this->data);
            }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Illuminate\View\View
         */
        public function create()
            {
                return view('modules.prime.content.add',$this->data);
            }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return array
         */
        public function store(AddContent $request)
            {
                $validateddata  =   $request->validated();

                if($validateddata)
                    {
                        $content                =   new Content();

                        $res                    =   $content->save();
                        if($res)
                            return self::success('Content','success',route('prime.content.index'));
                        return self::fail('Content','failed',route('prime.content.index'));
                    }
                return self::fail('Content',$validateddata,route('prime.content.index'));
            }

        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Illuminate\View\View
         */
        public function show($id)
            {
                $this->data['content']  =   Content::find($id);
                return view('modules.prime.content.view',$this->data);
            }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Illuminate\View\View
         */
        public function edit($id)
            {
                $this->data['content']  =   Content::find($id);
                return view('modules.prime.content.edit',$this->data);
            }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  int  $id
         * @return array
         */
        public function update(Request $request, $id)
            {
                $validateddata  =   $request->validated();

                if($validateddata)
                {
                    $content                =   new Content();

                    $res                    =   $content->save();
                    if($res)
                        return self::success('Content','success',route('prime.content.index'));
                    return self::fail('Content','failed',route('prime.content.index'));
                }
                return self::fail('Content',$validateddata,route('prime.content.index'));
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

        public function get(Request $request)
            {
                $columns        =   array( 0 => 'id' , 1 => 'message', 2 => 'publishdate', 3 => 'senddate');
                $totalData      =   Content::count();
                $totalFiltered  =   $totalData;
                $limit          =   $request->input('length');
                $start          =   $request->input('start');
                $order          =   $columns[$request->input('order.0.column')];
                $dir            =   $request->input('order.0.dir');

                if( empty(  $request->input('search.value') )  )
                    {
                        $posts  =   Content::offset($start)
                                            ->limit($limit)
                                            ->orderBy($order,$dir)
                                            ->get();
                    }
                else
                    {

                        $search         =   $request->input('search.value');
                        $posts          =   Content::where('message','LIKE',"%{$search}%")
                                                ->orWhere('publishdate', 'LIKE',"%{$search}%")
                                                ->offset($start)
                                                ->limit($limit)
                                                ->orderBy($order,$dir)
                                                ->get();

                        $totalFiltered  =   Content::where('message','LIKE',"%{$search}%")
                                                ->orWhere('publishdate', 'LIKE',"%{$search}%")
                                                ->count();
                    }

                $data = array();
                if(!empty($posts))
                {
                    foreach ($posts as $post)
                    {

                        $nestedData['id']               =   $post->id;
                        $nestedData['attempts']         =   $post->attempts;
                        $nestedData['queue']            =   $post->queue;
                        $nestedData['payload']          =   $post->payload;
                        $nestedData['reserved_at']      =   $post->reserved_at;
                        $nestedData['available_at']     =   $post->available_at;
                        $nestedData['created_at']       =   $post->created_at;
                        $data[]                         =   $nestedData;

                    }
                }

                $json_data = array( "draw" => (int)$request->input('draw') , "recordsTotal" => $totalData , "recordsFiltered" => $totalFiltered , "data" => $data );

                echo json_encode($json_data);
            }
    }
