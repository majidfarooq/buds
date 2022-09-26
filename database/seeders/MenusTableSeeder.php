<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menus')->delete();
        $menus = array(
            array(
            'title' => "header",
            'slug' => "header",
            'content' => "header menu",
            ),
            array(
            'title' => "footer",
            'slug' => "footer",
            'content' => "footer menu",
            )
        );
        DB::table('menus')->insert($menus);
    }
}
