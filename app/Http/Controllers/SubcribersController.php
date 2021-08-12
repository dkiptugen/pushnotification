<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;

class SubcribersController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Illuminate\View\View
         */
        public function index()
            {
                return view('modules.subscribers.index',$this->data);
            }
        public function get(Request $request)
            {
                $columns = array(
                    0   =>  'id',
                    1   =>  'endpoint',
                    2   =>  'product_id',
                    3   =>  'status',
                    4   =>  'created_at',
                    5   =>  'updated_at'

                );

                $totalData      =   Guest::count();
                $totalFiltered  =   $totalData;
                $limit          =   $request->input('length');
                $start          =   $request->input('start');
                $order          =   $columns[$request->input('order.0.column')];
                $dir            =   $request->input('order.0.dir');
                if(empty($request->input('search.value')))
                    {
                        $posts = Guest::offset($start)
                                        ->limit($limit)
                                        ->orderBy($order,$dir)
                                        ->get();
                    }
                else
                    {
                        $search =   $request->input('search.value');

                        $posts  =   Guest::whereHas("product",function ($subquery) use($search){
                                                $subquery->where('name','LIKE',"%{$search}%");
                                            })

                                        ->orWhere('endpoint','LIKE',"%{$search}%")
                                        ->offset($start)
                                        ->limit($limit)
                                        ->orderBy($order,$dir)
                                        ->get();

                        $totalFiltered =Guest::whereHas("product",function ($subquery) use($search){
                                                            $subquery->where('name','LIKE',"%{$search}%");
                                                        })
                                                ->orWhere('endpoint','LIKE',"%{$search}%")
                                                ->count();
                    }
                $data = array();
                if(!empty($posts))
                    {
                        $pos    =   $start+1;
                        foreach ($posts as $post)
                        {

                            $nestedData['pos']              =   $pos;
                            $nestedData['endpoint']         =   substr($post->endpoint,27);
                            $nestedData['product']          =   $post->product->name;
                            $nestedData['status']           =   ($post->status == 1)?"Active":"Inactive";
                            $nestedData['created']          =   $post->created_at->format('h:ia d-m-Y');
                            $nestedData['updated']          =   $post->updated_at->format('h:ia d-m-Y');


                            $data[] = $nestedData;
                            $pos++;
                        }
                    }

                $json_data = array("draw" => (int)$request->input('draw'), "recordsTotal" => $totalData, "recordsFiltered" => $totalFiltered, "data" => $data);
                echo json_encode($json_data);
            }
    }
