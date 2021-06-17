<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PosterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'user_id' => 1,
                'logo' => 'logo.png',
                'background' => 'background.png',
                'title' => 'Toyota Corolla',
                'description' => 'RS 6000/Day',
                'contact' => '+923135500075',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('posters')->insert($data);
    }
}
