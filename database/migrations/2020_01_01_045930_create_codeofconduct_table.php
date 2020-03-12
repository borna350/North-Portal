<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCodeofconductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('codeofconducts', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('emp_id');
			$table->string('coc_agreement');
			$table->string('old_coc');
			$table->enum('status', ['A', 'D']);
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
        Schema::dropIfExists('codeofconducts');
    }
}
