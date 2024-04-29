<?php

namespace App\Database\Migrations;

use App\Helpers\Migration\Blueprint;

class AddStatuses extends Blueprint
{
    public function up()
    {
        $this->create('statuses', function (Blueprint $table) {
            $table->id();
            $table->integer('code');
            $table->string('text');
            $table->string('color');
            $table->string('name');            
            $table->foreignId('type_id')->constrained('stypes')->cascadeOnDelete()->add();      
            $table->timestamps();
            $table->softDelete();
        });
    }

    public function down()
    {
        $this->dropIfExists('statuses');
    }
}