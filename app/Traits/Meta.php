<?php


namespace App\Traits;


trait Meta
    {
        public static function site_def() :array
            {
                return  [
                            'name'          =>  'Pusher',
                            'title'         =>  '',
                            'description'   =>  '',
                            'keywords'      =>  '',
                            'author'        =>  '',
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
    }
