<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalDevelopmentPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_development_plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('emp_id')->nullable();
            $table->text('title')->nullable();
            $table->longText('description')->nullable();
            $table->text('start_date')->nullable();
            $table->text('end_date')->nullable();
            $table->longText('comment')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('personal_development_plans');
    }
}
