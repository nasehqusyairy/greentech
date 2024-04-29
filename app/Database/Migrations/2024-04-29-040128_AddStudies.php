<?php

namespace App\Database\Migrations;

use App\Helpers\Migration\Blueprint;

class AddStudies extends Blueprint
{
    public function up()
    {
        $this->create('studies', function (Blueprint $table) {
            $table->id();
            $table->integer('code');
            $table->string('name');
            $table->timestamps();
            $table->softDelete();
        });
    }

    public function down()
    {
        $this->dropIfExists('studies');
    }
}