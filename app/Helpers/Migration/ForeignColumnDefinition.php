<?php

namespace App\Helpers\Migration;

class ForeignColumnDefinition
{
  protected $name;
  protected $blueprint;
  protected $table;
  protected $columnName = 'id';
  protected $onDelete = 'RESTRICT';
  protected $onUpdate = 'RESTRICT';


  public function __construct(Blueprint $blueprint, $name)
  {
    $this->blueprint = $blueprint;
    $this->name = $name;
  }

  public function constrained($table, $columnName = 'id'): ForeignColumnDefinition
  {
    $this->table = $table;
    $this->columnName = $columnName;
    return $this;
  }

  public function cascadeOnDelete(): ForeignColumnDefinition
  {
    $this->onDelete = 'CASCADE';
    return $this;
  }

  public function cascadeOnUpdate(): ForeignColumnDefinition
  {
    $this->onUpdate = 'CASCADE';
    return $this;
  }

  public function add(): void
  {
    $column =  $this->blueprint->bigInteger($this->name)->unsigned();
    $column->getForge()->addForeignKey($column->getName(), $this->table, $this->columnName, $this->onUpdate, $this->onDelete);
  }
}
