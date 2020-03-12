<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            //$table->string('emp_id');
			$table->string('firstname')->nullable();
			$table->string('lastname')->nullable();
			$table->string('dob')->nullable();
			$table->string('personalemail')->nullable();
			$table->string('phone_no')->nullable();
			$table->string('address')->nullable();
			$table->string('workemail')->nullable();
			$table->string('profile_pic')->nullable();
			$table->string('marital_status')->nullable();
			$table->string('no_ofchildren')->nullable();
			$table->string('family_inarea')->nullable();
			$table->string('spclfamilycircumstace')->nullable();
			$table->string('prsnl_belief')->nullable();
			$table->string('known_medical_conditions')->nullable();
			$table->string('allergies')->nullable();
			$table->string('dietiary_restricons')->nullable();
			$table->string('known_health_concerns')->nullable();
			$table->string('aversion_phyactivity')->nullable();
			$table->string('emergency_contact_name')->nullable();
			$table->string('reltn_emergency_contact')->nullable();
			$table->string('emergency_contact_phone')->nullable();
			$table->string('emergency_contact_email')->nullable();

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
        Schema::dropIfExists('Employee_details');
    }
}
