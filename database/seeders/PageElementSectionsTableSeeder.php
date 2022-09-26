<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageElementSectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sections = array(
            array(
                'title' => 'Single Section',
                'slug' => 'single-section',
            ),
            array(
                'title' => 'Double Section',
                'slug' => 'double-section',
            ),
            array(
                'title' => 'Triple Section',
                'slug' => 'triple-section',
            ),
        );
        DB::table('page_element_sections')->insert($sections);
    }
}
