<?php

namespace App\Http\Controllers;

use Goutte\Client;
use App\Utils\TelegramPost;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
                                $d  =   [];
                                $crawler = $client->request('GET', $value->loc);

                                $d['content'] = $crawler->filter('.the-content ')->each(function ($node)
                                   {
                                         return strip_tags($node->html(),'<p><br><h4><h3><h1><h2><h5><h6><a>');
                                   });
                               $d['title'] = $crawler->filter('h2.page-title ')->each(function ($node)
                                   {
                                       return $node->text();
                                   });
                               $d['author'] = $crawler->filter('.authorinfo a')->each(function ($node)
                                   {
                                       return $node->text();
                                   });
                               $d['time'] = $crawler->filter('.datepublished')->each(function ($node)
                               {
                                   return date("D, d M Y H:i:s T", str_replace('Published on: ','',$node->text()));
                               });
                                dump($d);
                           }

                            echo $value->loc.' : '.(int)str_replace('-n','',$match[0]).'</br>';
                       break;

                   }
            }
    }
