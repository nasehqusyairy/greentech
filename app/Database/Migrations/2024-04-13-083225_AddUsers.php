<?php

namespace App\Database\Migrations;

use App\Helpers\Migration\Blueprint;

class AddUsers extends Blueprint
{
    public function up()
    {
        $this->create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained('roles')->cascadeOnDelete()->add();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');

            $table->string('image')->nullable();
            $table->string('phone')->nullable();
            $table->string('country')->nullable();
            $table->string('callingcode')->nullable();
            $table->string('institution')->nullable();
            $table->integer('gender')->nullable();

            $table->boolean('isActive')->default(false);
            $table->string('activationCode')->nullable();
            $table->string('resetPasswordCode')->nullable();
            $table->timestamps();
            $table->softDelete();
        });
    }

    public function down()
    {
        $this->dropIfExists('users');
    }
}
