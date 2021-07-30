<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    public function get(Request $request)
    {
        $columns = array(
            0   =>  'id',
            1   =>  'name',
            2   =>  'email',
            3   =>  'status',
            4   =>  'role'

        );

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

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data,

        );

        echo json_encode($json_data);
    }
    public function get_roles(Request $request)
    {
        $columns = array(
            0   =>  'id',
            1   =>  'name'

        );
        $totalData      = Role::count();

        $totalFiltered  = $totalData;

        $limit  =   $request->input('length');
        $start  =   $request->input('start');
        $order  =   $columns[$request->input('order.0.column')];
        $dir    =   $request->input('order.0.dir');
        if(empty($request->input('search.value')))
        {
            $posts = Role::offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else
        {
            $search         =   $request->input('search.value');


            $posts          =   Role::where('name','like',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $totalFiltered  =  Role::where('name','like',"%{$search}%")
                ->count();
        }

        $data = array();
        if(!empty($posts))
        {
            $x = $start+1;
            foreach ($posts as $post)
            {
                $perm                       =   array_column(Permission_Role::where('role_id',$post->id)->get()->toArray(),'permission_id');
                $nestedData['pos']          =   $x;
                $nestedData['name']         =   $post->name;
                $nestedData['access']       =   Sdata::getperm($post->id) ;
                $nestedData['action']       =   '<a href="#" data-role=\''.$post.'\' data-perm=\''.json_encode($perm).'\' class="edit-role text-muted"><i class="fas fa-edit"></i></a>';
                $data[]                     =   $nestedData;
                $x++;
            }
        }

        $json_data = array(
            "draw"            => (int)$request->input('draw'),
            "recordsTotal"    => $totalData,
            "recordsFiltered" => $totalFiltered,
            "data"            => $data
        );

        echo json_encode($json_data);
    }

    public function get_permissions(Request $request)
    {
        $columns = array(
            0   =>  'id',
            1   =>  'name',
            2   =>  'action'

        );
        $totalData      = Permission::whereNotNull("name")
            ->count();

        $totalFiltered  = $totalData;

        $limit  =   $request->input('length');
        $start  =   $request->input('start');
        $order  =   $columns[$request->input('order.0.column')];
        $dir    =   $request->input('order.0.dir');
        if(empty($request->input('search.value')))
        {
            $posts = Permission::whereNotNull("name")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else
        {
            $search         =   $request->input('search.value');


            $posts          =   Permission::whereNotNull("name")
                ->where('name','like',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $totalFiltered  =  Permission::whereNotNull("name")
                ->where('name','like',"%{$search}%")
                ->count();
        }

        $data = array();
        if(!empty($posts))
        {
            $x = $start+1;
            foreach ($posts as $post)
            {
                $nestedData['pos']          =   $x;
                $nestedData['name']         =   $post->name;
                $nestedData['access']       =   $post->action;
                $nestedData['roles']        =   Sdata::getaccess($post->id);
                $nestedData['action']       =   '<a href="javascript:;"  class="text-dark mr-3 edit-permission" data-user="'.$post->id.'"><i class="fas fa-edit  "></i></a>
                                                                <a href="javascript:;"  class="text-dark mr-3 assign-role" data-user="'.$post->id.'"><i class="fas fa-plus-circle  "></i></a>' ;
                $data[]                     =   $nestedData;
                $x++;
            }
        }

        $json_data = array(
            "draw"            => (int)$request->input('draw'),
            "recordsTotal"    => (int)$totalData,
            "recordsFiltered" => (int)$totalFiltered,
            "data"            => $data
        );

        echo json_encode($json_data);
    }
}
