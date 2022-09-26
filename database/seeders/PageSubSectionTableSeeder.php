<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageSubSectionTableSeeder extends Seeder
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
                'title' => 'single_sec_col',
                'row_width' => 12,
                'section_id' => 1,
            ),
            array(
                'title' => 'single_sec_col_f',
                'row_width' => 6,
                'section_id' => 2,
            ),
            array(
                'title' => 'single_sec_col_s',
                'row_width' => 6,
                'section_id' => 2,
            ),
            array(
                'title' => 'third_sec_col_f',
                'row_width' => 4,
                'section_id' => 3,
            ),
            array(
                'title' => 'third_sec_col_sec',
                'row_width' => 4,
                'section_id' => 3,
            ),
            array(
                'title' => 'third_sec_col_th',
                'row_width' => 4,
                'section_id' => 3,
            ),
        );
        DB::table('page_sub_sections')->insert($sections);
    }
}
