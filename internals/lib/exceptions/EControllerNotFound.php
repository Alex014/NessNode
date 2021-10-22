<?php
namespace internals\lib\exceptions;

class EControllerNotFound extends \Exception {
    public function __construct(string $class_path, int $code = 0, ?\Throwable $previous = null) {
        parent::__construct("Error finding controller '$class_path' ", $code, $previous);
    }
}