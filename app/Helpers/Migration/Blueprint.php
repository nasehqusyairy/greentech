<?php

namespace App\Helpers\Migration;

use CodeIgniter\Database\Migration;

class Blueprint extends Migration
{
  public $fields = [];

  public function up()
  {
  }

  public function down()
  {
  }

  public function string($name, $length = 255): ColumnDefinition
  {
    $column = new ColumnDefinition($this->forge);
    $column->setName($name);
    $column->setType('VARCHAR');
    $column->setLength($length);
    array_push($this->fields, $column);
    return $column;
  }

  public function char($name, $length): ColumnDefinition
  {
    $column = new ColumnDefinition($this->forge);
    $column->setName($name);
    $column->setType('CHAR');
    $column->setLength($length);
    array_push($this->fields, $column);
    return $column;
  }

  public function text($name): ColumnDefinition
  {
    $column = new ColumnDefinition($this->forge);
    $column->setName($name);
    $column->setType('TEXT');
    array_push($this->fields, $column);
    return $column;
  }

  public function integer($name, $length = 11): ColumnDefinition
  {
    $column = new ColumnDefinition($this->forge);
    $column->setName($name);
    $column->setType('INT');
    $column->setLength($length);
    array_push($this->fields, $column);
    return $column;
  }

  public function bigInteger($name, $length = 20): ColumnDefinition
  {
    $column = new ColumnDefinition($this->forge);
    $column->setName($name);
    $column->setType('BIGINT');
    $column->setLength($length);
    array_push($this->fields, $column);
    return $column;
  }

  public function float($name, $length = 8): ColumnDefinition
  {
    $column = new ColumnDefinition($this->forge);
    $column->setName($name);
    $column->setType('FLOAT');
    $column->setLength($length);
    array_push($this->fields, $column);
    return $column;
  }

  public function double($name, $length = 8): ColumnDefinition
  {
    $column = new ColumnDefinition($this->forge);
    $column->setName($name);
    $column->setType('DOUBLE');
    $column->setLength($length);
    array_push($this->fields, $column);
    return $column;
  }

  public function decimal($name, $length = 8): ColumnDefinition
  {
    $column = new ColumnDefinition($this->forge);
    $column->setName($name);
    $column->setType('DECIMAL');
    $column->setLength($length);
    array_push($this->fields, $column);
    return $column;
  }

  public function boolean($name): ColumnDefinition
  {
    $column = new ColumnDefinition($this->forge);
    $column->setName($name);
    $column->setType('TINYINT');
    $column->setLength(1);
    array_push($this->fields, $column);
    return $column;
  }

  public function date($name): ColumnDefinition
  {
    $column = new ColumnDefinition($this->forge);
    $column->setName($name);
    $column->setType('DATE');
    array_push($this->fields, $column);
    return $column;
  }

  public function dateTime($name): ColumnDefinition
  {
    $column = new ColumnDefinition($this->forge);
    $column->setName($name);
    $column->setType('DATETIME');
    array_push($this->fields, $column);
    return $column;
  }

  public function timestamp($name): ColumnDefinition
  {
    $column = new ColumnDefinition($this->forge);
    $column->setName($name);
    $column->setType('TIMESTAMP');
    array_push($this->fields, $column);
    return $column;
  }

  public function id($name = 'id')
  {
    $this->bigInteger($name)->unsigned()->autoIncrement()->primaryKey();
    $this->forge->addPrimaryKey($name);
  }

  public function uuid($name = 'id')
  {
    $this->char($name, 36)->unique();
    $this->forge->addPrimaryKey($name);
  }

  public function timestamps()
  {
    $this->dateTime('created_at')->nullable();
    $this->dateTime('updated_at')->nullable();
  }

  public function softDelete()
  {
    $this->dateTime('deleted_at')->nullable();
    $this;
  }

  public function foreignId($name = 'id'): ForeignIdColumnDefinition
  {
    return new ForeignIdColumnDefinition($this, $name);
  }

  public function foreignUuid($name = 'id'): ForeignUuidColumnDefinition
  {
    return new ForeignUuidColumnDefinition($this, $name);
  }

  public function create($table, $callback)
  {
    $callback($this);
    $fields = [];
    foreach ($this->fields as $field) {
      $fields = array_merge($fields, $field->add());
    }
    $this->forge->addField($fields);
    $this->forge->createTable($table, true);
  }

  public function dropIfExists($table)
  {
    $this->forge->dropTable($table, true, true);
  }
}
