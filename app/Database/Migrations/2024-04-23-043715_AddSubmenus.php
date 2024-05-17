<?php

namespace App\Database\Migrations;

use App\Helpers\Migration\Blueprint;

class AddSubmenus extends Blueprint
{
    public function up()
    {
        $this->create('submenus', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('menu_id')->constrained('menus')->cascadeOnDelete()->add();
            $table->string('name');
            $table->string('url');
            $table->string('icon');
            $table->boolean('is_path')->default(true);
            $table->timestamps();
            $table->softDelete();
        });
    }

    public function down()
    {
        $this->dropIfExists('submenus');
    }
}
