<?php
namespace internals\lib\interfaces;

/**
 * Path extractor
 */
interface iPatchResolver {
    /**
     * Get path as array (example ['modules', 'get', 'all'])
     *
     * @return array
     */
    static public function getPath(): array;
}