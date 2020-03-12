<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance_tickets', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('emp_id');
			$table->string('subject');
			$table->string('website');
			$table->string('description');
			$table->string('priority');
			$table->string('category');
			$table->string('status')->nullable();
			$table->string('delete_status')->nullable();
			$table->string('_token');
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
        Schema::dropIfExists('maintenance_tickets');
    }
}
