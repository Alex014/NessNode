<?php
require_once '../internals/Launcher.php';

use internals\Launcher;

$launcher = Launcher::getInstance();
$launcher->runControllers(require 'config/patch.php');