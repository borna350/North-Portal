<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveOldFromAgreements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agreements', function (Blueprint $table) {
            $table->dropColumn('old_agreement');
            $table->integer('parent_id')->nullable()->unsigned()->after('id')->index();
        });

        Schema::table('codeofconducts', function (Blueprint $table) {
            $table->dropColumn('old_coc');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agreements', function (Blueprint $table) {
            $table->string('old_agreement')->nullable()->after('agreement');
            $table->dropColumn('parent_id');
        });

        Schema::table('codeofconducts', function (Blueprint $table) {
            $table->string('old_coc')->nullable()->after('coc_agreement');
        });
    }
}
