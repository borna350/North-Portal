<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       /* DB::table('users')->insert([
            'name' => str_random(6),
            'email' => strtolower(str_random(6)).'@gmail.com',
            'password' => bcrypt('admin@123')
        ]);*/

		DB::table('users')->insert([
		    'id' => 1,
            'name' => 'Sean Glendinning',
            'email' => 'sg@49partners.com',
            'password' => bcrypt('admin@123'),
			'user_type' => 'is_admin',
            'is_admin' => 1,
            'is_ticket_admin' => 1
        ]);

		DB::table('employee_details')->insert([
		   'id' => 1,
           'firstname' => 'Sean',
           'lastname' => 'Glendinning',
           'personalemail' => 'sean@fitnessmanagement.ca'
        ]);

        DB::table('users')->insert([
            'id' => 2,
            'name' => 'Dave Leavitt',
            'email' => 'dl@49partners.com',
            'password' => bcrypt('admin@123'),
            'user_type' => 'is_admin',
            'is_admin' => 1,
            'is_ticket_admin' => 0
        ]);

        DB::table('employee_details')->insert([
            'id' => 2,
            'firstname' => 'Dave',
            'lastname' => 'Leavitt',
            'personalemail' => 'dleavitt@plaidfox.com'
        ]);

    }
}
