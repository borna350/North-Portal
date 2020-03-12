<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('projects')->insert(array(
		array(
		'projectname' => 'project1'
		),
		array(
		'projectname' => 'project2'
		)
		));
    }
}
