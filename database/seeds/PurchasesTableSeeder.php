<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class PurchasesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('purchases')->insert(array(
		array(
		'purchasename' => 'cash'
		),
		array(
		'purchasename' => 'credit card'
		),
		array(
		'purchasename' => 'cheque'
		)
		));
    }
}
