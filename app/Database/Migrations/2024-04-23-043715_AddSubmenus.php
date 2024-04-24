<?php

namespace App\Database\Migrations;

use App\Helpers\Migration\Blueprint;

class AddSubmenus extends Blueprint
{
    public function up()
    {
        $this->create('submenus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained('menus')->cascadeOnDelete()->add();
            $table->string('name');
            $table->string('url');
            $table->string('icon');
            $table->timestamps();
        });
    }

    public function down()
    {
        $this->dropIfExists('submenus');
    }
}
