<?php


namespace App\Traits;


trait Meta
    {
        public static function site_def() :array
            {
                return  [
                            'name'          =>  'BoxAlert',
                            'title'         =>  'BoxAlert',
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

    }
