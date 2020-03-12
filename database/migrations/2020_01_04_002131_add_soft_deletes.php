<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeletes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('employee_details', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('agreements', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('codeofconducts', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('employee_details', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('agreements', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('codeofconducts', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
    }
}
