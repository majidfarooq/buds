<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $field = array(
            array(
                'name' => 'user',
            ),
            array(
                'name' => 'vendor',
            ),
        );
        DB::table('roles')->insert($field);
    }
}
