<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdditionlBenifitsSpendingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('additionl_benifits_spendings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('date')->nullable();
            $table->text('description')->nullable();
            $table->text('total')->nullable();
            $table->boolean('pay_status')->nullable();
            $table->text('status')->nullable();
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
        Schema::dropIfExists('additionl_benifits_spendings');
    }
}
