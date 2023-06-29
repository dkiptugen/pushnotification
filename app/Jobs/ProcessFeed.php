<?php

namespace App\Jobs;

use Goutte\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessFeed implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $data;
    /**
     * Create a new job instance.
     *
     * @return void
     *
     */
    public function __construct($data)
        {
            $this->data = $data;
        }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
        {

            $this->data->chunk(20,function ($xml){
                $x = 0;
                foreach($xml as $value) {
                    preg_match('/\-n[0-9]+/', $value->loc, $match);

                    if (isset($match[0])) {
                        $client = new Client();
                        $crawler = $client->request('GET', $value->loc);

                        $d[$x]['content'] = $crawler->filter('.the-content ')->each(function ($node) {
                            return strip_tags($node->html(), '<p><br><h4><h3><h1><h2><h5><h6><a>');
                        });
                        $d[$x]['title'] = $crawler->filter('h2.page-title ')->each(function ($node) {
                            return $node->text();
                        });
                        $d[$x]['author'] = $crawler->filter('.authorinfo a')->each(function ($node) {
                            return $node->text();
                        });
                        $d[$x]['time'] = $crawler->filter('.datepublished')->each(function ($node) {
                            return date("D, d M Y H:i:s T", strtotime(str_replace('Published on: ', '', $node->text())));
                        });
                        $d[$x]['id'] = (int)str_replace('-n', '', $match[0]);
                        $d[$x]['link'] = (string)$value->loc;
                        $x++;
                    }
                    if ($x == 2)
                        break;
                }
            });


            }
}
