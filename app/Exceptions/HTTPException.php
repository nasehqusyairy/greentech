<?php

namespace App\Exceptions;

use CodeIgniter\Exceptions\HTTPExceptionInterface;

class HTTPException extends \Exception implements HTTPExceptionInterface
{
  private $descriptions = [];

  public function __construct(string $message, int $code, array $descriptions = [], \Throwable $previous = null)
  {
    $this->descriptions = $descriptions;
    parent::__construct($message, $code, $previous);
  }

  public function getDescriptions(): array
  {
    return $this->descriptions;
  }
}
