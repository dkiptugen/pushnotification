<?php

namespace App\Utils;

use app\Constants\KonnectParameters;
use Illuminate\Support\Facades\Http;

class Konnect
    {
        public function login()
            {
                $data   =   Http::withHeaders(['Content-Type'=>'application/json','accept'=>'application/json'])
                                ->withOptions(['verify'=>app_path('/Resources/cacert.pem'),''])
                                ->post(KonnectParameters::loginUrl,['login_id'=>KonnectParameters::login_id,'password'=>KonnectParameters::pass]);
                if($data->successful())
                    return $data->object();
            }
        public function charge($id)
            {

                $query = <<<GQL
                        query {
                            user(id: $id) {
                                id
                                name
                                email
                            }
                        }
                        GQL;

                $response = Http::withHeaders(['Content-Type' => 'application/json',])
                                ->post(KonnectParameters::chargeurl, ['query' => $query]);

                if($response->successful())
                    return $response->json();
            }
        public function checkPayment()
            {

            }
        public function sendsms($id)
            {

                $query = <<<GQL
                                query {
                                    user(id: $id) {
                                        id
                                        name
                                        email
                                    }
                                }
                                GQL;

                $response = Http::withHeaders(['Content-Type' => 'application/json',])
                    ->post(KonnectParameters::chargeurl, ['query' => $query]);

                if($response->successful())
                    return $response->json();
            }
    }
