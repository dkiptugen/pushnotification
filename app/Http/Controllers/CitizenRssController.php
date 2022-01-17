<?php

namespace App\Http\Controllers;

use App\Models\Info;
use Goutte\Client;
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
                                    return date("D, d M Y H:i:s T", strtotime(str_replace('Published on: ','',$node->text())));
                                });

                                $xml .= "<item xmlns:dc='ns:1'>" . PHP_EOL;
                                $xml .= "<title><![CDATA[".$d['title']."]]></title>" . PHP_EOL;
                                $xml .= "<description><![CDATA[".$d['content']."]]></description>" . PHP_EOL;
                                $xml .= "<link>".$value->loc."</link>" . PHP_EOL;
                                $xml .= "<guid>".md5(rand(0,1000))."</guid>" . PHP_EOL;
                                $xml .= "<pubDate>".$d['time']."</pubDate>" . PHP_EOL;
                                $xml .= "<dc:creator>".$d['author']."</dc:creator>" . PHP_EOL;
                                $xml .= "</item>" .PHP_EOL;
                            }



                    }



                $xml .= "</channel>".PHP_EOL;
                $xml .= "</rss>".PHP_EOL;
                return response($xml, 200)
                    ->header('Content-Type', 'text/xml');
            }
    }
