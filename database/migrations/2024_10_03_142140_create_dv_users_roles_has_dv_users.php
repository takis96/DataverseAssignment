<?php

class CreateDvUsersRolesHasDvUsersTable extends Migration
{
    public function up()
    {
        Schema::create('dv_users_roles_has_dv_users', function (Blueprint $table) {
            $table->foreignId('dv_users_roles_id')->constrained('dv_users_roles');
            $table->foreignId('dv_users_id')->constrained('dv_users');
            $table->primary(['dv_users_roles_id', 'dv_users_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('dv_users_roles_has_dv_users');
    }
}
