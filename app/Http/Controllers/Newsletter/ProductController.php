<?php

namespace App\Http\Controllers\Newsletter;

use App\Http\Controllers\Controller;
use App\Http\Requests\addNewsletterProduct;
use App\Http\Requests\editNewsletterProduct;
use App\Models\NewsletterProducts;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('modules.newsletter.products.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('modules.newsletter.products.add', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Http\Response
     */
    public function store(addNewsletterProduct $request)
        {
            $validateddata = $request->validated();
            if($validateddata)
                {

                        $product                =   new NewsletterProducts();
                        $product->name          =   $request->name;
                        $product->feedlink      =   $request->feedlink;
                        $product->status        =    1;
                        $res                    =   $product->save();
                        if($res)
                            return self::success('Newsletter Products','added successfully',route('newsletter_product.index'));

                    return self::fail('Newsletter Products', 'Failed to add newsletter product',route('newsletter_product.index'));
                }
                return self::fail('Newsletter Products', $validateddata,route('newsletter_product.index'));
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
        {
            $this->data['product'] = NewsletterProducts::find($id);
            return view('modules.newsletter.products.edit', $this->data);
        }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return array|\Illuminate\Http\Response
     */
    public function update(editNewsletterProduct $request, $id)
        {
            $validateddata = $request->validated();
            if($validateddata)
                {

                    $product                =   NewsletterProducts::find($id);
                    $product->name          =   $request->name;
                    $product->feedlink      =   $request->feedlink;
                    $product->status        =    1;
                    $res                    =   $product->save();
                    if($res)
                        return self::success('Newsletter Products','queued successfully',route('newsletter_product.index'));

                    return self::fail('Newsletter Products', 'Failed to queue notification',route('newsletter_product.index'));
                }
            return self::fail('Newsletter Products', $validateddata,route('newsletter_product.index'));
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
            2   =>  'feedlink',
            3   =>  'status'
        );

        $totalData      =   NewsletterProducts::count();
        $totalFiltered  =   $totalData;
        $limit          =   $request->input('length');
        $start          =   $request->input('start');
        $order          =   $columns[$request->input('order.0.column')];
        $dir            =   $request->input('order.0.dir');
        if(empty($request->input('search.value')))
        {
            $posts = NewsletterProducts::offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else
        {
            $search =   $request->input('search.value');

            $posts  =   NewsletterProducts::where('name','LIKE',"%{$search}%")
                                            ->orWhere('feedlink','LIKE',"%{$search}%")
                                            ->offset($start)
                                            ->limit($limit)
                                            ->orderBy($order,$dir)
                                            ->get();

            $totalFiltered =    NewsletterProducts::where('name','LIKE',"%{$search}%")
                                                    ->orWhere('feedlink','LIKE',"%{$search}%")
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
                $nestedData['feedlink']         =   $post->feedlink;
                $nestedData['datecreated']      =   Carbon::parse($post->created_at)->format('d-m-Y');
                $nestedData['status']           =   ($post->status == 1)?"Active":"inactive";
                $nestedData['action']           =   "<a href='".route('newsletter_product.edit',$post->id)."' class='text text-dark'><i class='fas fa-edit'></i></a>";
                $data[]                         =   $nestedData;
                $pos++;
            }
        }

        $json_data = array("draw" => (int)$request->input('draw'), "recordsTotal" => $totalData, "recordsFiltered" => $totalFiltered, "data" => $data);
        echo json_encode($json_data);
    }
}
