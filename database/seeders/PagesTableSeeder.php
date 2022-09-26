<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pages')->insert([
            'title' => 'home',
            'slug' => 'home',
            'meta_title' => 'Home',
            'meta_keywords' => 'Your Website Meta Keywords',
            'meta_description' => 'Your Website Meta Description',
            'is_home' => 1,
            'banner' => '/public/storage/placeholder.jpg',
            'banner_content' => '<h1>Home</h1>',
        ]);
    }
}
