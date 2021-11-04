<?php

namespace App\Http\Controllers;

use app\Constants\KonnectParameters;

use App\Http\Requests\AddSubscription;

use App\Models\Charge;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cookie;
use Jenssegers\Agent\Agent;
use App\Utils\Konnect;

class PrimeController extends Controller
    {

        public function checkdevice(Request $request)
            {
                $agent          =   new Agent();
                if($agent->isMobile() && !Cookie::has('msisdn'))
                    {
                        if($request->hasHeader('msisdn'))
                            {

                                Cookie::queue('msisdn', $request->header('msisdn'), $this->time());
                                return TRUE;
                            }
                        return redirect('prime/subscription');
                    }
                elseif($agent->isMobile() && Cookie::has('msisdn') )
                    {
                        return TRUE;
                    }
                return FALSE;
            }
        public function time()
            {
                $end    =   Carbon::parse('now')->endOfDay();
                $start  =   Carbon::parse('now');
                return $end->diffInMinutes($start);
            }
        public function checkpayment(Request $request)
            {
                $checkdevice    =   $this->checkdevice($request);

                if($checkdevice)
                    {
                        $checkcharge    =   Charge::whereHas('subscription',function($subquery){
                                                            $subquery->where('msisdn',Cookie::get('msisdn'))
                                                                ->where('status',1);
                                                        })
                                                    ->where('charge_status',1)
                                                    ->whereDate('timecharged',date('Y-m-d'))
                                                    ->first();
                        if(!is_null($checkcharge))
                            {
                                Cookie::queue('subscribed', $request->header('msisdn'), $this->time());
                                return True;
                            }
                        return redirect('prime/subscription');
                    }
                return False;
            }
        public function index(Request $request)
            {

                if($this->checkpayment($request))
                    {
                        return view('frontend.modules.home',$this->data);
                    }

                return redirect('https://www.kenyans.co.ke');
            }
        public function article(Request $request,$slug)
            {
                $this->data['article']  =   Article::where('slug',$slug)
                                                   ->limit(1)
                                                   ->first();
                if($this->checkpayment($request))
                    {
                        return view('frontend.modules.article',$this->data);
                    }
                return redirect($this->data['article']->redirectUrl);
            }
        public function subscription_page()
            {
                return view('frontend.modules.subscribe',$this->data);
            }
        public function subscribe(AddSubscription $subscription)
            {
                $validateddata  = $subscription->validated();
                if($validateddata)
                    {
                        $sub        =   new Request();

                        $sub->request->add(['phone_no'=>$subscription->msisdn,'service_id'=>KonnectParameters::service_id]);
                        $sub->setMethod('post');
                        $subscribe  =   Konnect::subscribe($sub);
                        $data =  Subscription::firstOrCreate(['id'=>$subscribe->recordId,'msisdn'=>$subscription->msisdn]);
                        if($data)
                            {
                                return self::success('subscription','subscription successful');
                            }
                        return self::fail('subscription','subscription already exists');
                    }
                return self::fail('subscription',$validateddata);
            }
    }
