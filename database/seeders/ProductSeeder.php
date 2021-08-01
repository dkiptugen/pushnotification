<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        (new Product)->upsert([
            [
                'name' => 'Kenyans',
                'domain' =>  'kenyans.co.ke',
                'user_id'=>1
            ],

        ], ['name'], ['domain','user_id']);
    }
}
