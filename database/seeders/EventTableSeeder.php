<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EventTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\Event::truncate(); // 既存データを削除する場合のみ
        \App\Models\Event::factory()->count(10)->create();
    }
}
