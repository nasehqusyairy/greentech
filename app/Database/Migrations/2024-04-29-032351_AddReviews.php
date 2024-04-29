<?php

namespace App\Database\Migrations;

use App\Helpers\Migration\Blueprint;

class AddReviews extends Blueprint
{
    public function up()
    {
        $this->create('reviews', function (Blueprint $table) {
            $table->id();
            $table->string('file');
            $table->text('comment');
            $table->foreignId('abstract_id')->constrained('abstracs')->cascadeOnDelete()->add();
            $table->foreignId('status_id')->constrained('statuses')->cascadeOnDelete()->add();
            $table->timestamps();
            $table->softDelete();
        });
    }

    public function down()
    {
        $this->dropIfExists('reviews');
    }
}