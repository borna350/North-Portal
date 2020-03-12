<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddOrderValToPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::table('permissions', function (Blueprint $table) {
            $table->smallInteger('orderval')->default(0)->after('guard_name');
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->smallInteger('orderval')->default(0)->after('guard_name');
        });

        DB::statement('TRUNCATE TABLE role_has_permissions');
        DB::statement('TRUNCATE TABLE permissions');
        DB::statement('TRUNCATE TABLE roles');

        DB::statement('INSERT INTO roles (id, name, guard_name, orderval) VALUES (1, "Admin", "web", 1), (2, "Employee", "web", 1)');
        DB::statement('INSERT INTO permissions (id, name, guard_name, orderval) VALUES (1,"mileage","web",1),
(2,"expenses","web",1),
(3,"maintenance","web",1),
(4,"pay-statement","web",1),
(5,"benefits","web",1),
(6,"classroom","web",1)
');
        DB::statement('INSERT INTO role_has_permissions (permission_id, role_id) VALUES (1,2),(2,2),(3,2),(4,2),(5,2),(6,2)');

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn('orderval');
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn('orderval');
        });
    }
}
