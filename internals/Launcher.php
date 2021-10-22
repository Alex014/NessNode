<?php
namespace internals;

require_once 'lib/exceptions/EControllerNotFound.php';
require_once 'lib/exceptions/EControllerMethodNotFound.php';
require_once 'lib/exceptions/EControllerPathException.php';
require_once 'lib/exceptions/EServiceNotFound.php';
require_once 'lib/interfaces/iPatchResolver.php';

use \internals\lib\exceptions\EControllerNotFound;
use \internals\lib\exceptions\EControllerMethodNotFound;
use \internals\lib\exceptions\EControllerPathException;
use \internals\lib\exceptions\EServiceNotFound;
use \internals\lib\interfaces\iPatchResolver;

class Launcher {
    private iPatchResolver $patchResolver;
    public string $service;
    public string $service_path_string;
    public array $path;
    public array $service_path;

    private static $instance;

    public function __construct(iPatchResolver $patchResolver) {
        $this->patchResolver = $patchResolver;

        spl_autoload_register(function ($class) {
            require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR,  $class) . '.php';
        });

        $this->path = $this->patchResolver->getPath();
        $this->service = $this->path[0];
        $this->service_path = array_slice($this->path, 1);
        $this->service_path_string = implode(DIRECTORY_SEPARATOR, $this->service_path);
    }

    public static function getInstance(iPatchResolver $patchResolver = null) {
        if (empty(self::$instance)) {
            if (empty($patchResolver)) {
                throw new \Exception('Class Launcher not initialised, you must set valid $patchResolver param.');
            }

            self::$instance = new Launcher($patchResolver);
        }

        return self::$instance;
    }

    private function runController(string $class_path, string $method = 'index', array $params = []) {
        if (! class_exists($class_path)) {
            throw new EControllerNotFound($class_path);
        }

        $class = new $class_path();

        if (! method_exists($class, $method)) {
            throw new EControllerMethodNotFound($class_path, $method);
        }

        call_user_func(array($class, $method), $params);
    }

    public function runControllers (array $controllers_list) {
        if (isset($controllers_list[$this->service_path_string])) {
            $full_controller = $controllers_list[$this->service_path_string];

            if (!is_array($full_controller) || (count($full_controller) < 2) || ((count($full_controller) >= 3) && !is_array($full_controller[2]))) {
                throw new EControllerPathException("The value must be in format "
                    . "'$this->service_path_string' => [comtroller_class_full_name, controller_method] or "
                    . "'$this->service_path_string' => [comtroller_class_full_name, controller_method, [param1, ...]]"
                );
            }

            if (!isset($full_controller[2])) {
                $full_controller[2] = [];
            }

            $this->runController($full_controller[0], $full_controller[1], $full_controller[2]);
        } else {
            if (!isset($controllers_list[''])) {
                throw new EControllerPathException("Default pacth not found ");
            }
        }
    }

    public function runServices() {
        $run_filename = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'services'
            . DIRECTORY_SEPARATOR . $this->service . DIRECTORY_SEPARATOR . 'run.php';

        if (!file_exists($run_filename)) {
            throw new EServiceNotFound($this->service, $run_filename);
        }

        return require $run_filename;
    }
}
