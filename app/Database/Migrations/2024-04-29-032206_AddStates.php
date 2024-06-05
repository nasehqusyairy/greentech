<?php

namespace App\Database\Migrations;

use App\Helpers\Migration\Blueprint;

class AddStates extends Blueprint
{
    public function up()
    {
        $this->create('states', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->timestamps();
            $table->softDelete();
        });
    }

    public function down()
    {
        $this->dropIfExists('states');
    }
}
