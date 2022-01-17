<?php

namespace App\Http\Controllers;

use Sunra\PhpSimple\HtmlDomParser;
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
                               $content = HtmlDomParser::file_get_html($value->loc);
                               dd($content);
                               foreach($content->find('div.article-content') as $val)
                                   {
                                       dd(val);
                                       $details["title"]			= 	strip_tags($val->getElementByTagName("h2")->innertext);
                                   }
                           }

                            echo $value->loc.' : '.(int)str_replace('-n','',$match[0]).' - '.$details["title"].'</br>';
                   }
            }
    }
