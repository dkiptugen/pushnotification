<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        (new User)->upsert([
            [
                'name' => 'Isaac',
                'email' =>  'ikiplel@standardmedia.co.ke',
                'email_verified_at' => now()->format('Y-m-d H:i:s'),
                'remember_token' => Str::random(10)
            ],
            [
                'name' => 'Jared',
                'email' =>  'jkidambi@standardmedia.co.ke',
                'email_verified_at' => now()->format('Y-m-d H:i:s'),
                'remember_token' => Str::random(10)
            ],
            [
                'name' => 'Lynn',
                'email' =>  'lkinyanjui@standardmedia.co.ke',
                'email_verified_at' => now()->format('Y-m-d H:i:s'),
                'remember_token' => Str::random(10)
            ],
            [
                'name' => 'Matthew',
                'email' =>  'mshahi@standardmedia.co.ke',
                'email_verified_at' => now()->format('Y-m-d H:i:s'),
                'remember_token' => Str::random(10)
            ],
        ], ['email'], ['name', 'email_verified_at', 'remember_token']);

    }
}
