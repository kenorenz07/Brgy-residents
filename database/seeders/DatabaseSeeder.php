<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

use function PHPSTORM_META\map;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::create([
            'name' => 'admin lang',
            'password' => bcrypt(123123),
            'email' => 'admin@lang.com'
        ]);
    }
}
