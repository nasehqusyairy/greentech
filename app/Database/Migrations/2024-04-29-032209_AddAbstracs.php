<?php

namespace App\Database\Migrations;

use App\Helpers\Migration\Blueprint;

class AddAbstracs extends Blueprint
{
    public function up()
    {
        $this->create('abstracs', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->string('authors');
            $table->text('emails');
            $table->text('text');
            $table->foreignId('creator_id')->constrained('users')->cascadeOnDelete()->add();
            $table->foreignId('topic_id')->constrained('topics')->cascadeOnDelete()->add();
            $table->foreignId('reviewer_id')->constrained('users')->cascadeOnDelete()->add();
            $table->timestamps();
            $table->softDelete();
        });
    }

    public function down()
    {
        $this->dropIfExists('abstracs');
    }
}