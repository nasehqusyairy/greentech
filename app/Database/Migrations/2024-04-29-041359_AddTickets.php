<?php

namespace App\Database\Migrations;

use App\Helpers\Migration\Blueprint;

class AddTickets extends Blueprint
{
    public function up()
    {
        $this->create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('attendance');
            $table->integer('price');
            $table->foreignId('ttype_id')->constrained('ttypes')->cascadeOnDelete()->add();
            $table->foreignId('trole_id')->constrained('troles')->cascadeOnDelete()->add();
            $table->foreignId('state_id')->constrained('states')->cascadeOnDelete()->add();
            $table->foreignId('study_id')->constrained('studies')->cascadeOnDelete()->add();
            $table->timestamps();
            $table->softDelete();
        });
    }

    public function down()
    {
        $this->dropIfExists('tickets');
    }
}
