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
                       $d=[];
                       if(isset($match[0]))
                           {
                               $client = new Client();

                                $crawler = $client->request('GET', $value->loc);

                                $crawler->filter('.the-content ')->each(function ($node)
                                   {
                                         $d['content'] = strip_tags($node->html(),'<p><br><h4><h3><h1><h2><h5><h6><a>');
                                   });
                                dump($d);
                           }

                            echo $value->loc.' : '.(int)str_replace('-n','',$match[0]).'</br>';
                       break;

                   }
            }
    }
