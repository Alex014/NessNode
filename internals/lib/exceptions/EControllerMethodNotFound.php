<?php
namespace internals\lib\exceptions;

class EControllerMethodNotFound extends \Exception {
    public function __construct(string $class_path, string $method, int $code = 0, ?\Throwable $previous = null) {
        parent::__construct("Error finding controller method '$class_path' -> '$method' ", $code, $previous);
    }
}