<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSalaryCheckboxTextareaPositionReportsEmpIdToEmployeeDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_details', function (Blueprint $table) {

            $table->string('position')->after('lastname')->nullable();
            $table->string('base_salary')->after('lastname')->nullable();
            $table->integer('report_to')->after('lastname')->nullable(); 
            $table->boolean('benefits_opt_in')->default(0)->after('lastname');
            $table->longText('compensation_details')->after('lastname')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_details', function (Blueprint $table) {
            $table->dropColumn('position');
            $table->dropColumn('base_salary');
            $table->dropColumn('report_to');
            $table->dropColumn('benefits_opt_in');
            $table->dropColumn('compensation_details');
        });
    }
}
