<?php

namespace App\Http\Controllers\Newsletter;

use App\Http\Controllers\Controller;
use App\Models\Newsletter\Template;
use Illuminate\Http\Request;

class TemplateController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Illuminate\View\View
         */
        public function index()
            {
                return view('modules.newsletter.template.index', $this->data);
            }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Illuminate\View\View
         */
        public function create()
            {
                return view('modules.newsletter.template.add', $this->data);
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
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Illuminate\View\View
         */
        public function show($id)
            {
                $this->data['template'] =   Template::find($id);
                return view('modules.newsletter.template.view', $this->data);
            }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Illuminate\View\View
         */
        public function edit($id)
            {
                $this->data['template'] =   Template::find($id);
                return view('modules.newsletter.template.edit', $this->data);
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
                    2   =>  'product_id',
                    3   =>  'noofposts',
                    4   =>  'status',
                    5   =>  'created_at',
                    6   =>  'user_id'

                );

                $totalData      =   Template::count();
                $totalFiltered  =   $totalData;
                $limit          =   $request->input('length');
                $start          =   $request->input('start');
                $order          =   $columns[$request->input('order.0.column')];
                $dir            =   $request->input('order.0.dir');
                if(empty($request->input('search.value')))
                    {
                        $posts  =   Template::offset($start)
                                        ->limit($limit)
                                        ->orderBy($order,$dir)
                                        ->get();
                    }
                else
                    {
                        $search =   $request->input('search.value');

                        $posts  =   Template::whereHas("user",function ($subquery) use($search){
                                                    $subquery->where('name','LIKE',"%{$search}%")
                                                        ->orWhere('email','LIKE',"%{$search}%");
                                                })
                                            ->orWhereHas("product",function ($subquery) use($search){
                                                    $subquery->where('name','LIKE',"%{$search}%");
                                                })
                                            ->orWhere('name','LIKE',"%{$search}%")
                                            ->offset($start)
                                            ->limit($limit)
                                            ->orderBy($order,$dir)
                                            ->get();

                        $totalFiltered =    Template::whereHas("user",function ($subquery) use($search){
                                                            $subquery->where('name','LIKE',"%{$search}%")
                                                                ->orWhere('email','LIKE',"%{$search}%");
                                                        })
                                                    ->orWhereHas("product",function ($subquery) use($search){
                                                            $subquery->where('name','LIKE',"%{$search}%");
                                                        })
                                                    ->orWhere('name','LIKE',"%{$search}%")
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
                                $nestedData['product']          =   $post->product->name??'';
                                $nestedData['author']           =   $post->user->name??'';
                                $nestedData['noofposts']        =   $post->noofposts;
                                $nestedData['createddate']      =   $post->created_at->format('d-m-Y');
                                $nestedData['status']           =   ($post->status == 1)?"Active":"inactive";
                                $nestedData['action']           =   "<a href='".route('newsletter-template.edit',$post->id)."' class='text text-dark'>
                                                                        <i class='fas fa-edit'></i>
                                                                     </a>";
                                $data[]                         =   $nestedData;
                                $pos++;
                            }
                    }

                $json_data = array("draw" => (int)$request->input('draw'), "recordsTotal" => $totalData, "recordsFiltered" => $totalFiltered, "data" => $data);
                return response()->json($json_data);

            }
    }
