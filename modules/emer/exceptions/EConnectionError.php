<?php
namespace modules\emer\exceptions;

use \Throwable;

class EConnectionError extends \Exception {
    public function __construct(array $config, string $err, int $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            "Can not connect with params (host:$config[host] port:$config[port] user:$config[user] password:$config[password] ) output message ($err)" , 
            $code, 
            $previous
        );
    }
}
