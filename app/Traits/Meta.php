<?php


namespace App\Traits;
use Illuminate\Contracts\Bus\Dispatcher;

trait Meta
    {
        public static function site_def() :array
            {
                return  [
                            'name'          =>  'The Standard Notification System',
                            'title'         =>  'Web Push Notification System',
                            'description'   =>  'The biggest push notification platform',
                            'keywords'      =>  'Web push, alert, telegram',
                            'author'        =>  'Dennis Kiptugen',
                            'logo'          =>  'assets/img/logo.png'
                        ];
            }
        public static function success($title,$message,$redirecturl="") : array
            {
                return  [
                            'status'    =>  TRUE,
                            'msg'       =>  $message,
                            'header'    =>  $title,
                            'url'       =>  $redirecturl
                        ];
            }

        public static function fail($title,$message,$redirecturl="") : array
            {
                return [
                            'status'    =>  FALSE,
                            'msg'       =>  $message,
                            'header'    =>  $title,
                            'url'       =>  $redirecturl
                        ];
            }

        public static  function custom_dispatch($job): int
            {
                return app(Dispatcher::class)->dispatch($job);
            }
        public static function renderArticle($story)
            {
                $story  =   str_replace(array("\n", "\r"), '', $story);
                $data   =   preg_replace('/<img .*? src="([^"]*)" .*?>/','<img src="$1" width="800" height="500">',$story);
                $data   =   preg_replace('/<iframe .*? src="([^"]*)" .*?>/','<iframe width="800" height="500" src="$1"> </iframe>', $data);
                $data   =   preg_replace('/<a .*? href="([^"]*)" .*?>([^"]*)<\/a>/','<a href="$1" >$2</a>',$data);
                $data   =   preg_replace('/<a .*? data-ft="([^"]*)" .*?>/','',$data);
                $data   =   preg_replace('/<span.*?>/','<span>',$data);
                $data   =   preg_replace('/<hr.*?>/','<hr>',$data);
                $data   =   preg_replace('/<ul.*?>/','<ul>',$data);
                $data   =   preg_replace('/<div.*?>/','<div>',$data);
                $data   =   preg_replace('/<br.*?>/','<br>',$data);
                $data   =   preg_replace('/<em.*?>/','<em>',$data);
                $data   =   preg_replace('/<blockquote.*?>/','<blockquote>',$data);
                $data   =   preg_replace( '/<strong.*?>/','<strong>',$data);
                $data   =   preg_replace('/<p.*?>/','<p>',$data);
                $data   =   preg_replace("/<ol.*?>(.)?<\/ol>/im","$1",$data);
                $data   =   preg_replace("/<ul.*?>(.)?<\/ul>/im","$1",$data);
                $data   =   preg_replace("/<li.*?>(.)?<\/li>/im","$1",$data);
                $data   =   preg_replace("/<font.*?>(.)?<\/font>/im","$1",$data);
                $data   =   preg_replace("/<table.*?>(.)?<\/table>/im","$1",$data);
                $data   =   preg_replace("/<tr.*?>(.)?<\/tr>/im","$1",$data);
                $data   =   preg_replace("/<td.*?>(.)?<\/td>/im","$1",$data);
                $data   =   preg_replace('/(<[^>]+) style=".*?"/i', '$1', $data);
                $data   =   str_replace('target="_hplink"', "", $data);
                $data   =   str_replace('http://', "https://", $data);
                $data   =   preg_replace('/(\>)\s*(\<)/m', '$1$2', $data);
                $data   =   preg_replace('/(<figcaption[^>]*>)<p>/', '$1', $data);
                $data   =   preg_replace('/<\/p>(<\/figcaption[^>]*>)/', '$1', $data);
                $data   =   preg_replace('#<script(.*?)>(.*?)</script>#is', '', $data);
                return strip_tags($data,'<h1><h2><h3><h4><a><h5><h6><p><ul><ol><li><strong><em><code><svg><article><section><header><footer><aside><figure><div><hr><small><br><iframe>');
            }

    }
