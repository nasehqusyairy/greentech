<?php

namespace App\Database\Migrations;

use App\Helpers\Migration\Blueprint;

class AddRoles extends Blueprint
{
    public function up()
    {
        $this->create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->timestamps();
            $table->softDelete();
        });
    }

    public function down()
    {
        $this->dropIfExists('roles');
    }
}
