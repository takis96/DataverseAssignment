<?php

class CreateDvUsersRolesTable extends Migration
{
    public function up()
    {
        Schema::create('dv_users_roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('is_active')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dv_users_roles');
    }
}
