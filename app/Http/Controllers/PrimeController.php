<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class PrimeController extends Controller
    {
        public function index(Request $request)
            {
                $agent = new Agent();
                if($agent->isMobile())
                    {
                        if($request->hasHeader('msisdn'))
                            {

                                return view('frontend.modules.home',$this->data);
                            }
                        return redirect('subscription');
                    }

                return redirect('https://www.kenyans.co.ke');
            }
        public function article(Request $request,$slug)
            {
                return view('frontend.modules.article',$this->data);
            }
        public function subscription_page(Request $request)
            {
                return view('frontend.modules.subscribe',$this->data);
            }
    }
