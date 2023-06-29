<?php

namespace App\Utils;

use app\Constants\KonnectParameters;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class Konnect
    {
        public static function login()
            {
                $data   =   Http::withHeaders(['Content-Type'=>'application/json','accept'=>'application/json'])
                                ->withOptions(['verify'=>app_path('/Resources/cacert.pem'),''])
                                ->post(KonnectParameters::loginUrl,['login_id'=>KonnectParameters::login_id,'password'=>KonnectParameters::pass]);
                if($data->successful())
                    return $data->object();
            }
        public static function charge(Request $request)
            {
                $query = <<<GQL
                                mutation {
                                    chargeRequest(subscriptionId:$request->subscription_id, phoneNumber:$request->phone_no,offerCode:$request->offercode,amount:$request->amount,serviceId:$request->service_id) {
                                       message
                                       code
                                       recordId
                                    }
                                }
                                GQL;

                $response = Http::withHeaders(['Content-Type' => 'application/json','Authorization'=>'Basic '.base64_encode(KonnectParameters::login_id.':'.KonnectParameters::pass)])
                    ->withOptions(['debug' => true,'verify'=>app_path('Resources/cacert.pem')])
                    ->post(KonnectParameters::graphql, ['query' => $query]);

                if($response->successful())
                    return $response->json();

            }
        public static function checkPayment(Request $request)
            {

                $query      =   <<<GQL
                                      query{
                                          subscriber(id:$request->id){
                                            id
                                            phone_number_id
                                            service_id status,
                                            first_name
                                            service{id name}
                                            last_name
                                            phone_number
                                            updated_at
                                            created_at
                                            }
                                        }
                                GQL;

                $response = Http::withHeaders(['Content-Type' => 'application/json','Authorization'=>'Basic '.base64_encode(KonnectParameters::login_id.':'.KonnectParameters::pass)])
                                    ->withOptions(['debug' => true,'verify'=>app_path('Resources/cacert.pem')])
                                    ->post(KonnectParameters::graphql, ['query' => $query]);

                if($response->successful())
                    return $response->json();
            }
        public static function sendsms(Request $request)
            {
                $callback   =   KonnectParameters::smscallback;
                $query      =   <<<GQL
                                      mutation{
                                            sendMtBulk(addressBookIds: [],contacts: $request->phone_no,message:$request->message,serviceId:$request->sevice_id,"callbackUrl":$callback){
                                                code
                                                message
                                                recordId
                                                }
                                            }
                                GQL;

                $response = Http::withHeaders(['Content-Type' => 'application/json','Authorization'=>'Basic '.base64_encode(KonnectParameters::login_id.':'.KonnectParameters::pass)])
                                ->withOptions(['debug' => true,'verify'=>app_path('Resources/cacert.pem')])
                                ->post(KonnectParameters::graphql, ['query' => $query]);

                if($response->successful())
                    return $response->json();

            }
        public static function subscribe(Request $request)
            {

                $query = <<<GQL
                                mutation {
                                     triggerSubscribeRequest( phoneNumber: $request->phone_no, serviceId:$request->service_id){
                                            message
                                            code
                                            recordId
                                            }
                                    }
                     GQL;

                $response = Http::withHeaders(['Content-Type' => 'application/json','Authorization'=>'Basic '.base64_encode(KonnectParameters::login_id.':'.KonnectParameters::pass)])
                    ->withOptions(['debug' => true,'verify'=>app_path('Resources/cacert.pem')])
                    ->post(KonnectParameters::graphql, ['query' => $query]);

                if($response->successful())
                    return $response->json();

            }
        public static function unsubscribe(Request $request)
            {

                $query = <<<GQL
                                        mutation {
                                            triggerUnsubscribeRequest( phoneNumber: $request->phone_no, serviceId:$request->service_id){
                                                    message
                                                    code
                                                    recordId
                                                    }
                                            }
                             GQL;

                $response = Http::withHeaders(['Content-Type' => 'application/json','Authorization'=>'Basic '.base64_encode(KonnectParameters::login_id.':'.KonnectParameters::pass)])
                    ->withOptions(['debug' => true,'verify'=>app_path('Resources/cacert.pem')])
                    ->post(KonnectParameters::graphql, ['query' => $query]);

                if($response->successful())
                    return $response->json();

            }

    }
