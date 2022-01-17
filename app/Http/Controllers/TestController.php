<?php

namespace App\Http\Controllers;

use Goutte\Client;
use App\Utils\TelegramPost;
use Illuminate\Http\Request;

class TestController extends Controller
    {
        public function feed()
            {
               $xml = simplexml_load_string(file_get_contents('https://citizen.digital/sitemap.xml'));
               foreach($xml as $value)
                   {
                       preg_match('/\-n[0-9]+/',$value->loc,$match);
                       if(isset($match[0]))
                           {
                               $client = new Client();

                                $crawler = $client->request('GET', $value->loc);

                                $crawler->filter('div.article-content')->each(function ($node)
                                   {
                                         dd($node.filter('h2.page-title'));
                                   });
                           }

                            echo $value->loc.' : '.(int)str_replace('-n','',$match[0]).'</br>';

                   }
            }
    }
