<?php

namespace App\Database\Migrations;

use App\Helpers\Migration\Blueprint;

class AddPermissions extends Blueprint
{
    public function up()
    {
        $this->create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('path')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        $this->dropIfExists('permissions');
    }
}
