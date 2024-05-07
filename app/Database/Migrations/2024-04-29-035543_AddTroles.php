<?php

namespace App\Database\Migrations;

use App\Helpers\Migration\Blueprint;

class AddTroles extends Blueprint
{
    public function up()
    {
        $this->create('troles', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->timestamps();
            $table->softDelete();
        });
    }

    public function down()
    {
        $this->dropIfExists('troles');
    }
}
