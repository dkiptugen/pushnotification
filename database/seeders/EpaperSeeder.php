<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EpaperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('epaper')->insert([
            "title" => "The Standard Epaper is Ready - " . date('d/m/Y'),
            "link" => "https://epaper.standardmedia.co.ke/",
            "thumbnail" => "https://epaper.standardmedia.co.ke/issues/the_standard/101/1.jpg",
            "summary" => "Public schools lead private in Mt Kenya",
            "flag" => 1,
            "created_at" => now(),
            "updated_at" => now(),
        ]);
    }
}
