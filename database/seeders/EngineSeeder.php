<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EngineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

            // $table->string('code');
            // $table->integer('displacement');
            // $table->integer('cylinder_count');
            // $table->integer('firing_order_degree');
            // $table->dateTime('created_at');
            // $table->dateTime('updated_at');

         DB::table('engines')->insert([
            'code' => Str::random(10),
            'displacement' => rand(100, max: 2000),
            'cylinder_count' => rand(1, 4)
        ]);
    }
}
