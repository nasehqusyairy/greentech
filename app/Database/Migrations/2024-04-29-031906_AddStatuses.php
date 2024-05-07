<?php

namespace App\Database\Migrations;

use App\Helpers\Migration\Blueprint;

class AddStatuses extends Blueprint
{
    public function up()
    {
        $this->create('statuses', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('text');
            $table->string('color');
            $table->foreignId('stype_id')->constrained('stypes')->cascadeOnDelete()->add();
            $table->timestamps();
            $table->softDelete();
        });
    }

    public function down()
    {
        $this->dropIfExists('statuses');
    }
}
