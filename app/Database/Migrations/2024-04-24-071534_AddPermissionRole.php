<?php

namespace App\Database\Migrations;

use App\Helpers\Migration\Blueprint;

class AddPermissionRole extends Blueprint
{
    public function up()
    {
        $this->create('permission_role', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permission_id')->constrained('permissions')->cascadeOnDelete()->add();
            $table->foreignId('role_id')->constrained('roles')->cascadeOnDelete()->add();
            $table->timestamps();
        });
    }

    public function down()
    {
        $this->dropIfExists('permission_role');
    }
}
