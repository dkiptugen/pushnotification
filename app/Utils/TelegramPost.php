<?php

namespace App\Utils;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramPost
    {
        public $data;
        public function __construct($data)
            {
                $this->data     =   $data;
            }
        public function  post_data()
            {
                $apiToken = $this->data['telegram_access_token'];
                $data = [
                            'chat_id'       =>  $this->data['telegram_channel'],
                            'parse_mode'    => 'HTML',
                            'text'          =>  $this->data['content'].'<a href="'.$this->data['url'].'">'.$this->data['title'].'</a>',
                        ];
                $response = Http::withHeaders(["Content-Type"=>"application/x-www-form-urlencoded"])->get("https://api.telegram.org/bot$apiToken/sendMessage", $data);
                Log::info($response->body());
                return $response->body();
            }
    }
