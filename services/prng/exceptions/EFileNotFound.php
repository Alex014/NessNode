<?php
namespace services\prng\exceptions;

use \Throwable;

class EFileNotFound extends \Exception {
    public function __construct(string $filename, int $code = 0, Throwable $previous = null)
    {
        parent::__construct('File "' .  $filename . '" not found', $code, $previous);
    }
}
