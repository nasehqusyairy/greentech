<?php

namespace App\Database\Migrations;

use App\Helpers\Migration\Blueprint;

class AddTopics extends Blueprint
{
    public function up()
    {
        $this->create('topics', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDelete();
        });
    }

    public function down()
    {
        $this->dropIfExists('topics');
    }
}
