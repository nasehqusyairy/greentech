<?php

namespace App\Database\Migrations;

use App\Helpers\Migration\Blueprint;

class AddPublications extends Blueprint
{
    public function up()
    {
        $this->create('publications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('price');
            $table->timestamps();
            $table->softDelete();
        });
    }

    public function down()
    {
        $this->dropIfExists('publications');
    }
}