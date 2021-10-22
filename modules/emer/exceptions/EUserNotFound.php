<?php
namespace modules\emer\exceptions;

use \Throwable;

class EUserNotFound extends \Exception {
    public function __construct(string $username, int $code = 0, Throwable $previous = null)
    {
        parent::__construct('User "' .  $username . '" not found', $code, $previous);
    }
}
