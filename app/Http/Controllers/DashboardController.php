<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Product;
use App\Models\Stories;
use Illuminate\Http\Request;

class DashboardController extends Controller
    {
        public function index(Request $request)
            {
                foreach(Product::where('status',1)->get() as $value)
                    {
                        if($request->has('startdate'))
                            {
                                $this->data['product'][$value->name]['subscriptions']     =   Guest::where('product_id',$value->id)
                                                                                                        ->whereDate('created_at','>=',$request->startdate)
                                                                                                        ->whereDate('created_at','<=',$request->enddate)
                                                                                                        ->count();
                                $this->data['product'][$value->name]['notifications']     =   Stories::where('product_id',$value->id)
                                                                                                        ->whereDate('created_at','>=',$request->startdate)
                                                                                                        ->whereDate('created_at','<=',$request->enddate)
                                                                                                        ->count();
                            }
                        else
                            {
                                $this->data['product'][$value->name]['subscriptions']     =   Guest::where('product_id',$value->id)
                                                                                                        ->count();
                                $this->data['product'][$value->name]['notifications']     =   Stories::where('product_id',$value->id)
                                                                                                        ->count();
                            }
                    }
                return view('modules.dashboard.index',$this->data);
            }
    }
