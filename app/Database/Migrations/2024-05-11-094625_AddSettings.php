<?php

namespace App\Database\Migrations;

use App\Helpers\Migration\Blueprint;

class AddSettings extends Blueprint
{
    public function up()
    {
        $this->create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
            $table->softDelete();
        });
    }

    public function down()
    {
        $this->dropIfExists('settings');
    }
}