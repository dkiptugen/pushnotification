<?php

namespace App\Console\Commands;

use App\Models\Info;
use Goutte\Client;
use Illuminate\Console\Command;

class ProcessSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process citizens sitemap';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
        {
            set_time_limit(0);

            $xml = simplexml_load_string(file_get_contents('https://citizen.digital/sitemap.xml'));

            foreach($xml as $value)
                {
                    preg_match('/\-n[0-9]+/', $value->loc, $match);

                    if (isset($match[0]))
                        {
                            $id = (int)str_replace('-n', '', $match[0]);
                            $check = Info::find($id);
                            if(is_null($check))
                                {
                                    $client = new Client();
                                    $crawler = $client->request('GET', $value->loc);

                                    $content = $crawler->filter('.the-content ')->each(function ($node) {
                                        return strip_tags($node->html(), '<p><br><h4><h3><h1><h2><h5><h6><a>');
                                    });
                                    $title = $crawler->filter('h2.page-title ')->each(function ($node) {
                                        return $node->text();
                                    });
                                    $author = $crawler->filter('.authorinfo a')->each(function ($node) {
                                        return $node->text();
                                    });
                                    $time = $crawler->filter('.datepublished')->each(function ($node) {
                                        return date("D, d M Y H:i:s T", strtotime(str_replace('Published on: ', '', $node->text())));
                                    });

                                    $link = (string)$value->loc;


                                    $info = new Info();
                                    $info->id = $id;
                                    $info->title = $title[0];
                                    $info->content = $content[0];
                                    $info->time = $time[0];
                                    $info->author = $author[0];
                                    $info->link = $link;
                                    $info->save();
                                }
                            else
                                {

                                    return 'no new record';
                                }
                        }



                }
                return 'proccessed successfully';
        }
}
