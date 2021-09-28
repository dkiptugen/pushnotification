<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddProduct;
use App\Http\Requests\EditProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProductsController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Illuminate\View\View
         */
        public function index()
            {
                return view('modules.products.index',$this->data);
            }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Illuminate\View\View
         */
        public function create()
            {
                return view('modules.products.add',$this->data);
            }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return array|\Illuminate\Http\Response
         */
        public function store(AddProduct $request)
            {
                $validateddata  = $request->validated();
                if($validateddata)
                    {
                        $product            =   new Product();

                        if($request->hasFile('image'))
                            {
                                $file               =   $request->file('image') ;
                                $fileName           =   time().'.'.$file->getClientOriginalName() ;
                                $destinationPath    =   public_path().'/uploads' ;
                                $file->move($destinationPath,$fileName);
                                Log::info($fileName);
                                $product->logo      =   'uploads/'.$fileName;
                            }


                        $product->name      =   $request->name;
                        $product->domain    =   trim(strtolower(str_replace('www.','',$request->domains)));
                        $product->status    =   1;
                        $product->user_id   =   Auth::user()->id;
                        $res                =   $product->save();
                        if($res)
                            return self::success('Product',"Added successfully",url('backend/products'));
                        return self::fail('Product',"Failed to add product",url('backend/products'));
                    }
                return self::fail('Product',$validateddata,url('backend/products'));
            }

        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Illuminate\View\View
         */
        public function show($id)
            {
                return view('modules.products.view',$this->data);
            }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Illuminate\View\View
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
         * @return array
         */

        public function update(EditProduct $request, $id)
            {
                $validateddata  = $request->validated();
                if($validateddata)
                    {
                        $product            =   Product::find($id);
                        if($product->name == 'System Generated')
                            $product->user_id   =   Auth::user()->id;

                        if($request->hasFile('image'))
                            {
                                $file               =   $request->file('image') ;
                                $fileName           =   time().'.'.$file->getClientOriginalName() ;
                                $destinationPath    =   public_path().'/uploads' ;
                                $file->move($destinationPath,$fileName);
                                $product->logo      =   'uploads/'.$fileName;
                                Log::info($fileName);
                            }

                        $product->name      =   $request->name;
                        $product->domain    =   trim(strtolower(str_replace('www.','',$request->domains)));
                        $product->status    =   1;
                        $res                =   $product->save();
                        if($res)
                            return self::success('Product',"Added successfully",url('backend/products'));
                        return self::fail('Product',"Failed to add product",url('backend/products'));
                    }
                return self::fail('Product',$validateddata,url('backend/products'));
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
                                $nestedData['author']           =   $post->user->name??'';
                                $nestedData['subscribers']      =   $post->subscriptions;
                                $nestedData['datecreated']      =   $post->created_at->format('d-m-Y');
                                $nestedData['status']           =   ($post->status == 1)?"Active":"inactive";
                                $nestedData['action']           =   "<a href='".route('product.edit',$post->id)."' class='text text-dark'><i class='fas fa-edit'></i></a>";

                                $data[] = $nestedData;
                                $pos++;
                            }
                    }

                $json_data = array("draw" => (int)$request->input('draw'), "recordsTotal" => $totalData, "recordsFiltered" => $totalFiltered, "data" => $data);
                echo json_encode($json_data);
            }
    }
