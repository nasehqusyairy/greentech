<?php

namespace App\Helpers\Migration;

class ForeignUuidColumnDefinition extends ForeignColumnDefinition
{
  public function add(): void
  {
    $column =  $this->blueprint->char($this->name, 36)->nullable();
    $column->getForge()->addForeignKey($column->getName(), $this->table, $this->columnName, $this->onUpdate, $this->onDelete);
  }
}
