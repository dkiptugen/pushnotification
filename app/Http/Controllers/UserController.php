<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddUser;
use App\Http\Requests\EditUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Illuminate\View\View|string
         */
        public function index()
            {
                return view('modules.users.index',$this->data);
            }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Illuminate\View\View|string
         */
        public function create()
            {
                return view('modules.users.add',$this->data);
            }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         *
         * @return array|\CodeIgniter\HTTP\RedirectResponse|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector|void
         */
        public function store(AddUser $request)
            {
                $validateddata  =   $request->validated();
                if($validateddata)
                    {

                            $usr    =   User::updateOrCreate(['email' =>  strtolower($request->email)],[ "name" => $request->name , "password" => Hash::make($request->pass) , "status" => 1 ]);
                            if($usr)
                                {
                                    return self::success('User','Added user successfully',url('manage/users'));
                                }

                            return self::fail('User','Failed to add user');

                        }

                    return self::fail('User',$validateddata);

            }

        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function show($id)
            {

            }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function edit($id)
            {

            }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function update(EditUser $request, $id)
            {

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
                $columns        =   array( 0 => 'id' , 1 => 'name' , 2 => 'email' , 3 => 'status' , 4 => 'role' );
                $totalData      =   User::count();
                $totalFiltered  =   $totalData;
                $limit          =   $request->input('length');
                $start          =   $request->input('start');
                $order          =   $columns[$request->input('order.0.column')];
                $dir            =   $request->input('order.0.dir');

                if( empty(  $request->input('search.value') )  )
                    {
                        $posts = User::offset($start)
                                        ->limit($limit)
                                        ->orderBy($order,$dir)
                                        ->get();
                    }
                else
                    {

                        $search         =   $request->input('search.value');
                        $posts          =   User::where('name','LIKE',"%{$search}%")
                                                ->orWhere('email', 'LIKE',"%{$search}%")
                                                ->orWhere('status', 'LIKE',"%{$search}%")
                                                ->offset($start)
                                                ->limit($limit)
                                                ->orderBy($order,$dir)
                                                ->get();

                        $totalFiltered  =   User::where('name','LIKE',"%{$search}%")
                                                ->orWhere('email', 'LIKE',"%{$search}%")
                                                ->orWhere('status', 'LIKE',"%{$search}%")
                                                ->count();
                    }

                $data = array();
                if(!empty($posts))
                    {
                        foreach ($posts as $post)
                            {
                                $actionbtn              =   (   $post->status == 1   )?"<a href='javascript:;' class='text text-muted chact' data-id='".$post->id."' data-table='rr_users' data-data='".json_encode(['status'=>0])."'><i class='fas fa-eye-slash'></i></a>":
                                    "<a href='javascript:;' class='text text-muted chact' data-id='".$post->id."' data-table='rr_users' data-data='".json_encode(['status'=>1])."'><i class='fas fa-eye'></i></a>";
                                $nestedData['id']       =   $post->id;
                                $nestedData['name']     =   $post->name;
                                $nestedData['email']    =   $post->email;
                                $nestedData['status']   =   ($post->status == 1)?'Active':"inactive";
                                $nestedData['role']     =   is_numeric($post->role_id)?Role::where("id",$post->role_id)->first()->name:NULL;
                                $nestedData['action']   =   '<a href="javascript:;"  class="text-dark mr-3 assign-role" data-user="'.$post->id.'"><i class="fas fa-edit  "></i></a>
                                                                            '.$actionbtn;

                                $data[]                 =   $nestedData;

                            }
                    }

                $json_data = array( "draw" => (int)$request->input('draw') , "recordsTotal" => $totalData , "recordsFiltered" => $totalFiltered , "data" => $data );

                echo json_encode($json_data);
            }



    }
