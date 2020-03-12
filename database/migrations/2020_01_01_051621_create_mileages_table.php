<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMileagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mileages', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('emp_id');
			$table->string('company');
			$table->string('date');
			$table->string('vehicle');
			$table->string('kilometers');
			$table->string('reasonmileage');
			$table->enum('status',['A','D'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mileages');
    }
}
