<?php

namespace App\Helpers\Migration;

use CodeIgniter\Database\Forge;

class ColumnDefinition
{
  protected $forge;
  private $name;
  private $type;
  private $length;
  private $isUnsigned = false;
  private $isAutoIncrement = false;
  private $isNullable = false;
  private $default = null;
  private $comment = null;
  private $isPrimaryKey = false;
  private $isUnique = false;

  public function __construct(Forge $forge)
  {
    $this->forge = $forge;
  }

  public function getForge()
  {
    return $this->forge;
  }

  public function setName(string $name)
  {
    $this->name = $name;
    return $this;
  }

  public function getName()
  {
    return $this->name;
  }

  public function setType(string $type)
  {
    $this->type = $type;
    return $this;
  }

  public function getType()
  {
    return $this->type;
  }

  public function setLength(int $length)
  {
    $this->length = $length;
    return $this;
  }

  public function getLength()
  {
    return $this->length;
  }

  public function getIsUnsigned()
  {
    $this->isUnsigned = true;
    return $this;
  }

  public function setIsUnsigned(bool $isUnsigned)
  {
    $this->isUnsigned = $isUnsigned;
    return $this;
  }

  public function getIsAutoIncrement()
  {
    $this->isAutoIncrement = true;
    return $this;
  }

  public function setIsAutoIncrement(bool $isAutoIncrement)
  {
    $this->isAutoIncrement = $isAutoIncrement;
    return $this;
  }

  public function getIsNullable()
  {
    $this->isNullable = true;
    return $this;
  }

  public function setIsNullable(bool $isNullable)
  {
    $this->isNullable = $isNullable;
    return $this;
  }

  public function getDefault()
  {
    return $this->default;
  }

  public function setDefault($default)
  {
    $this->default = $default;
    return $this;
  }

  public function getComment()
  {
    return $this->comment;
  }

  public function setComment(string $comment)
  {
    $this->comment = $comment;
    return $this;
  }

  public function getIsPrimaryKey()
  {
    $this->isPrimaryKey = true;
    return $this;
  }

  public function setIsPrimaryKey(bool $isPrimaryKey)
  {
    $this->isPrimaryKey = $isPrimaryKey;
    return $this;
  }

  public function getIsUnique()
  {
    $this->isUnique = true;
    return $this;
  }

  public function setIsUnique(bool $isUnique)
  {
    $this->isUnique = $isUnique;
    return $this;
  }

  public function default($value)
  {
    $this->default = $value;
    return $this;
  }

  public function unsigned()
  {
    $this->isUnsigned = true;
    return $this;
  }

  public function autoIncrement()
  {
    $this->isAutoIncrement = true;
    return $this;
  }

  public function nullable($nullable = true)
  {
    $this->isNullable = $nullable;
    return $this;
  }

  public function comment($comment)
  {
    $this->comment = $comment;
    return $this;
  }

  public function primaryKey()
  {
    $this->isPrimaryKey = true;
    return $this;
  }

  public function unique()
  {
    $this->isUnique = true;
    return $this;
  }

  public function add()
  {
    $columnInfo = ['type' => $this->type];

    if ($this->length !== null) {
      $columnInfo['constraint'] = $this->length;
    }

    if ($this->isUnsigned) {
      $columnInfo['unsigned'] = true;
    }

    if ($this->isAutoIncrement) {
      $columnInfo['auto_increment'] = true;
    }

    if ($this->isNullable) {
      $columnInfo['null'] = true;
    }

    if ($this->default !== null) {
      $columnInfo['default'] = $this->default;
    }

    if ($this->comment !== null) {
      $columnInfo['comment'] = $this->comment;
    }

    if ($this->isPrimaryKey) {
      $columnInfo['primary_key'] = true;
    }

    if ($this->isUnique) {
      $columnInfo['unique'] = true;
    }

    return [
      $this->name => $columnInfo
    ];
  }
}
