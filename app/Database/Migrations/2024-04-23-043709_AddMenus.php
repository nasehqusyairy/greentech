<?php

namespace App\Database\Migrations;

use App\Helpers\Migration\Blueprint;

class AddMenus extends Blueprint
{
    public function up()
    {
        $this->create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    }

    public function down()
    {
        $this->dropIfExists('menus');
    }
}
