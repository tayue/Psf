<?php
/**
 * 容器接口
 */

namespace Psf\Di\Contract;


interface ContainerInterface
{
    public function get($id);

    public function has($id);
}