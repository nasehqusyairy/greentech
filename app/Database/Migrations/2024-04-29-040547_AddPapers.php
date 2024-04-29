<?php

namespace App\Database\Migrations;

use App\Helpers\Migration\Blueprint;

class AddPapers extends Blueprint
{
    public function up()
    {
        $this->create('papers', function (Blueprint $table) {
            $table->id();
            $table->text('file');
            $table->text('provement');
            $table->foreignId('status_id')->constrained('statuses')->cascadeOnDelete()->add();
            $table->foreignId('abstrac_id')->constrained('abstracs')->cascadeOnDelete()->add();
            $table->foreignId('publication_id')->constrained('publications')->cascadeOnDelete()->add();
            $table->timestamps();
            $table->softDelete();
        });
    }

    public function down()
    {
        $this->dropIfExists('papers');
    }
}