<?php

namespace Psf\Test\App\Controller;

use Psf\Bean\Tool;
use Psf\Di\Container;
use Swoole\Coroutine as SwCoroutine;
class BlogController
{

    public $tool;


    /**依赖注入演示
     * @param Tool $tool
     */
    public function test(Tool $tool){
        $this->tool = $tool;
        $di = Container::getInstance();
        //print_r($di);
        $person = $di['person'];
        //print_r($person);
        print_r($di[Tool::class]);
       // print_r($di->getSingletons());
        echo $this->tool->display();
    }


    public function show($id,Tool $tool)
    {
        //echo "show_______________";
        $this->tool = $tool;
        $di = Container::getInstance();
        //print_r($di->getSingletons());

        echo $this->tool->display();
        print_r($di['person']);
        //print_r($di->getSingletons());
        //print_r(get_included_files());

       // echo $ddd;

        echo "id:" . $id."\r\n";
        echo "currentSwooleCid:".SwCoroutine::getCid()."\r\n";
        echo 'runtimeMemory:'.round(memory_get_usage()/1024/1024, 2).'MB', '';
    }

    public function article($id, $title)
    {
        echo "article_______________";
        var_dump($id, $title);
    }
}