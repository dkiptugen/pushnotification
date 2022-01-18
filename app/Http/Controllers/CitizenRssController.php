<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessFeed;
use App\Models\Info;
use Goutte\Client;
use http\Env\Response;
use Illuminate\Http\Request;

class CitizenRssController extends Controller
    {

        public function index()
            {


                $xml = "<rss version='2.0'>" . PHP_EOL;
                $xml .= "<channel>" .PHP_EOL;
                $xml .= "<title>Citizen.digital | RSS</title>" . PHP_EOL;
                $xml .= "<description>Citizen Digital feed RSS</description>";
                $xml .= "<language>en-us</language>" . PHP_EOL;
                foreach(Info::orderBy('id','desc')->limit(100)->get() as $value)
                    {
                        $xml .= "<item xmlns:dc='ns:1'>" . PHP_EOL;
                        $xml .= "<title><![CDATA[" . $value->title . "]]></title>" . PHP_EOL;
                        $xml .= "<description><![CDATA[" . $value->content . "]]></description>" . PHP_EOL;
                        $xml .= "<link>" . $value->loc . "</link>" . PHP_EOL;
                        $xml .= "<guid>" . md5($value->title) . "</guid>" . PHP_EOL;
                        $xml .= "<pubDate>" .$value->time . "</pubDate>" . PHP_EOL;
                        $xml .= "<dc:creator>" . $value->author . "</dc:creator>" . PHP_EOL;
                        $xml .= "</item>" . PHP_EOL;

                    }

                $xml .= "</channel>".PHP_EOL;
                $xml .= "</rss>".PHP_EOL;
                return response($xml, 200)
                    ->header('Content-Type', 'text/xml');
            }
    }
