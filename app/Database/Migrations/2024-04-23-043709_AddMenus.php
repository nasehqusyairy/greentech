<?php

namespace App\Database\Migrations;

use App\Helpers\Migration\Blueprint;

class AddMenus extends Blueprint
{
    public function up()
    {
        $this->create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('order')->default(1);
            $table->timestamps();
            $table->softDelete();
        });
    }

    public function down()
    {
        $this->dropIfExists('menus');
    }
}
