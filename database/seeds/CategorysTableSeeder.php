<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categorys')->insert(array(
			array(
			'categoryname' => 'category1',			
			),
			array(
			'categoryname' => 'category2',
			)
		));
    }
}
