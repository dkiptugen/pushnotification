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
    }
