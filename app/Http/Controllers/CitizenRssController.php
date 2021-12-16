<?php

namespace App\Http\Controllers;

use App\Models\Info;
use http\Env\Response;
use Illuminate\Http\Request;

class CitizenRssController extends Controller
    {
        public function date_cleaner($date)
            {
                $date = str_replace("Published on: ","",$date);
                return date("D, d M Y H:i:s T", strtotime($date));
            }
        public function index()
            {

                $xml = "<rss version='2.0'>" . PHP_EOL;
                $xml .= "<channel>" .PHP_EOL;
                $xml .= "<title>Citizen.digital | RSS</title>" . PHP_EOL;
                $xml .= "<description>Citizen Digital feed RSS</description>";
                $xml .= "<language>en-us</language>" . PHP_EOL;
                foreach(Info::orderBy('time','desc')->get() as $value)
                    {
                        $xml .= "<item xmlns:dc='ns:1'>" . PHP_EOL;
                        $xml .= "<title><![CDATA[".$value->title."]]></title>" . PHP_EOL;
                        $xml .= "<description><![CDATA[".$value->caption."]]></description>" . PHP_EOL;
                        $xml .= "<link>".$value->link."</link>" . PHP_EOL;
                        $xml .= "<guid>".md5(rand(0,1000))."</guid>" . PHP_EOL;
                        $xml .= "<pubDate>".$this->date_cleaner($value->time)."</pubDate>" . PHP_EOL;
                        $xml .= "<dc:creator>".$value->author."</dc:creator>" . PHP_EOL;
                        $xml .= "</item>" .PHP_EOL;
                    }
                $xml .= "</channel>".PHP_EOL;
                $xml .= "</rss>".PHP_EOL;
                return response($xml, 200)
                    ->header('Content-Type', 'text/xml');
            }
    }
