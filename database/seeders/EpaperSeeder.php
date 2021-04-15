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
            "thumbnail" => "101",
            "summary" => "Click read more to get to the epaper",
            "created_at" => now(),
            "updated_at" => now(),
        ]);
    }
}
