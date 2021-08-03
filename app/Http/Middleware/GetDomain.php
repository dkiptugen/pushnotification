<?php

namespace App\Http\Middleware;

use App\Models\Product;
use Closure;
use Illuminate\Http\Request;

class GetDomain
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
        {
            $domain     =   strtolower(str_replace('www.','',$request->server->get('SERVER_NAME')));
            $product    =   Product::where('domain','like','%'.$domain.'%')
                                    ->first();
            if(is_null($product))
                {
                    (new Product)->upsert([
                        [
                            'name'      =>  'System Generated',
                            'domain'    =>  $domain,
                            'user_id'   =>  1
                        ],

                    ], ['domain'], ['name','user_id']);
                }
            $request->request->add(['domain'=>$domain]);
            return $next($request);
        }
}
