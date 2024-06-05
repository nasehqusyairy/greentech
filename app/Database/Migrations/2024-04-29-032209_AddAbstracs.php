<?php

namespace App\Database\Migrations;

use App\Helpers\Migration\Blueprint;

class AddAbstracs extends Blueprint
{
    public function up()
    {
        $this->create('abstracs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('creator_id')->constrained('users')->cascadeOnDelete()->add();
            $table->foreignId('topic_id')->constrained('topics')->cascadeOnDelete()->add();
            $table->string('title');
            $table->string('authors');
            $table->text('emails');
            $table->text('text');
            $table->string('file');
            $table->foreignId('status_id')->constrained('statuses')->cascadeOnDelete()->add();
            $table->foreignId('reviewer_id')->constrained('users')->cascadeOnDelete()->nulllable()->add();
            $table->foreignUuid('ticket_id')->constrained('tickets')->cascadeOnDelete()->nulllable()->add();
            $table->timestamps();
            $table->softDelete();
        });
    }

    public function down()
    {
        $this->dropIfExists('abstracs');
    }
}
