<?php

namespace App\Http\Controllers;

use App\Utils\TelegramPost;
use Illuminate\Http\Request;

class TestController extends Controller
    {
        public function feed()
            {
               $xml = simplexml_load_string(file_get_contents('https://citizen.digital/sitemap.xml'));
               foreach($xml as $value)
               {
                   echo $value->loc.'</br>';
               }
            }
    }
