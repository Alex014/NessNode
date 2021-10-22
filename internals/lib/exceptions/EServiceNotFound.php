<?php
namespace internals\lib\exceptions;

class EServiceNotFound extends \Exception {
    public function __construct(string $service, string $run_filename, int $code = 0, ?\Throwable $previous = null) {
        parent::__construct("Service '$service' runfile '$run_filename' not found.", $code, $previous);
    }
}