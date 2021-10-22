<?php
namespace modules\emer\exceptions;

use \Throwable;

class ENodeNotFound extends \Exception {
    public function __construct(string $node, int $code = 0, Throwable $previous = null)
    {
        parent::__construct('Node "' .  $node . '" not found', $code, $previous);
    }
}
