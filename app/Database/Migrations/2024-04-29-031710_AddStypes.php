<?php

namespace App\Database\Migrations;

use App\Helpers\Migration\Blueprint;

class AddStypes extends Blueprint
{
    public function up()
    {
        $this->create('stypes', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->timestamps();
            $table->softDelete();
        });
    }

    public function down()
    {
        $this->dropIfExists('stypes');
    }
}
