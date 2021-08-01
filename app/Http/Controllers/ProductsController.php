<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index()
            {
                return view('modules.products.index',$this->data);
            }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
            {
                return view('modules.products.add',$this->data);
            }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function store(Request $request)
            {
                //
            }

        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function show($id)
            {
                return view('modules.products.view',$this->data);
            }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function edit($id)
            {
                $this->data['product']  =   Product::find($id);
                return view('modules.products.edit',$this->data);
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
        public function get(Request $request)
            {
            $columns = array(
                0   =>  'id',
                1   =>  'name',
                2   =>  'domain',
                3   =>  'user_id',
                4   =>  'created_at',
                5   =>  'status'

            );

            $totalData      =   Product::count();
            $totalFiltered  =   $totalData;
            $limit          =   $request->input('length');
            $start          =   $request->input('start');
            $order          =   $columns[$request->input('order.0.column')];
            $dir            =   $request->input('order.0.dir');
            if(empty($request->input('search.value')))
                {
                $posts = Product::offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();
                }
            else
                {
                $search =   $request->input('search.value');

                $posts  =   Product::whereHas("user",function ($subquery) use($search){
                                            $subquery->where('name','LIKE',"%{$search}%")
                                                    ->orWhere('email','LIKE',"%{$search}%");
                                        })
                                    ->orWhere('name','LIKE',"%{$search}%")
                                    ->orWhere('domain','LIKE',"%{$search}%")
                                    ->offset($start)
                                    ->limit($limit)
                                    ->orderBy($order,$dir)
                                    ->get();

                $totalFiltered =    Product::whereHas("user",function ($subquery) use($search){
                                                    $subquery->where('name','LIKE',"%{$search}%")
                                                        ->orWhere('email','LIKE',"%{$search}%");
                                                })
                                            ->orWhere('name','LIKE',"%{$search}%")
                                            ->orWhere('domain','LIKE',"%{$search}%")
                                            ->count();
                }
            $data = array();
            if(!empty($posts))
                {
                $pos    =   $start+1;
                foreach ($posts as $post)
                    {

                    $nestedData['pos']              =   $pos;
                    $nestedData['name']             =   $post->name;
                    $nestedData['domain']           =   $post->domain;
                    $nestedData['author']           =   $post->user->name;
                    $nestedData['datecreated']      =   $post->created_at->format('d-m-Y');
                    $nestedData['status']           =   ($post->status == 1)?"Active":"inactive";
                    $nestedData['action']           =   "";

                    $data[] = $nestedData;
                    $pos++;
                    }
                }

            $json_data = array("draw" => (int)$request->input('draw'), "recordsTotal" => $totalData, "recordsFiltered" => $totalFiltered, "data" => $data);
            echo json_encode($json_data);
            }
    }
