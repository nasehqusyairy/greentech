<?php

namespace App\Libraries;

use CodeIgniter\Debug\BaseExceptionHandler;
use CodeIgniter\Debug\ExceptionHandlerInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Throwable;

class HTTPExceptionHandler extends BaseExceptionHandler implements ExceptionHandlerInterface
{
  public function handle(
    Throwable $exception,
    RequestInterface $request,
    ResponseInterface $response,
    int $statusCode,
    int $exitCode
  ): void {
    if (in_array($statusCode, [403, 404, 405])) {
      $this->render($exception, $statusCode, $this->viewPath . "$statusCode.php");
    } else {
      $this->render($exception, $statusCode, $this->viewPath . "500.php");
    }

    exit($exitCode);
  }
}
