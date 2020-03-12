<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->text('emp_id')->nullable();
			$table->text('company')->nullable();
			$table->text('category')->nullable();
			$table->text('purchase')->nullable();
			$table->text('project')->nullable();
			$table->text('description')->nullable();
			$table->text('date')->nullable();
			$table->text('receipt')->nullable();
			$table->text('billable')->nullable();
			$table->text('received_auth')->nullable();
			$table->text('subtotal')->nullable();
			$table->text('gst')->nullable();
			$table->text('pst')->nullable();
			$table->text('total')->nullable();
			$table->text('status')->nullable();
			$table->text('delete_status')->nullable();
			$table->text('_token')->nullable();
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
        Schema::dropIfExists('expenses');
    }
}
