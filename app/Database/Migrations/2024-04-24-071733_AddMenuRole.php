<?php

namespace App\Database\Migrations;

use App\Helpers\Migration\Blueprint;

class AddMenuRole extends Blueprint
{
    public function up()
    {
        $this->create('menu_role', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained('menus')->cascadeOnDelete()->add();
            $table->foreignId('role_id')->constrained('roles')->cascadeOnDelete()->add();
            $table->timestamps();
            $table->softDelete();
        });
    }

    public function down()
    {
        $this->dropIfExists('menu_role');
    }
}
