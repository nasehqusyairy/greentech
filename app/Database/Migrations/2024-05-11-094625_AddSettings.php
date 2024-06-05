<?php

namespace App\Database\Migrations;

use App\Helpers\Migration\Blueprint;

class AddSettings extends Blueprint
{
    public function up()
    {
        $this->create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('description');
            $table->string('value')->nullable();
            $table->timestamps();
            $table->softDelete();
        });
    }

    public function down()
    {
        $this->dropIfExists('settings');
    }
}
