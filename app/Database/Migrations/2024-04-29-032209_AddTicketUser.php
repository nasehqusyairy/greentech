<?php

namespace App\Database\Migrations;

use App\Helpers\Migration\Blueprint;

class AddTicketUser extends Blueprint
{
    public function up()
    {
        $this->create('ticket_user', function (Blueprint $table) {
            $table->uuid();
            $table->text('proof');
            $table->text('attachment')->nullable();
            $table->foreignId('status_id')->constrained('statuses')->cascadeOnDelete()->add();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->add();
            $table->foreignUuid('ticket_id')->constrained('tickets')->cascadeOnDelete()->add();
            $table->timestamps();
            $table->softDelete();
        });
    }

    public function down()
    {
        $this->dropIfExists('ticket_user');
    }
}
