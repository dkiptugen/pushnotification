<?php

namespace App\Http\Controllers;

use App\Utils\TelegramPost;
use Illuminate\Http\Request;

class TestController extends Controller
    {
        public function telegram()
            {
                $t  =   new TelegramPost([  'title'                 =>  '',
                                            'telegram_access_token' =>  '',
                                            'telegram_channel'      =>  '',
                                            'image'                 =>  '',
                                            'url'                   =>  '',
                                            'content'               =>  ''
                                        ]);
                $t->post_data();
            }
    }
