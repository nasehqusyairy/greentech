<?php

namespace App\Database\Migrations;

use App\Helpers\Migration\Blueprint;

class AddTicketUser extends Blueprint
{
    public function up()
    {
        $this->create('ticket_user', function (Blueprint $table) {
            $table->id();
            $table->text('fiile');
            $table->text('student_card');
            $table->foreignId('status_id')->constrained('statuses')->cascadeOnDelete()->add();
            $table->foreignId('abstrac_id')->constrained('abstracs')->cascadeOnDelete()->add();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->add();
            $table->foreignId('ticket_id')->constrained('tickets')->cascadeOnDelete()->add();
            $table->timestamps();
            $table->softDelete();
        });
    }

    public function down()
    {
        $this->dropIfExists('ticket_user');
    }
}