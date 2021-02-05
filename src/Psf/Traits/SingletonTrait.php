<?php
/**
 * 单例 trait
 */

namespace Psf\Traits;

trait SingletonTrait
{
    private static $instance;

    static function getInstance($args = array())
    {
        if (!isset(self::$instance)) {
            self::$instance = new self($args);
        }
        return self::$instance;
    }
}