<?php

require_once './vendor/autoload.php';
$config = include_once './config.php';
ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);
use Psf\Di\Container;
use Psf\Bean\Person;
use Psf\Server\ServerManager;
use Psf\Test\App\Controller\BlogController;
//$res = new Container();
//$res['person'] = [
//    'class' => Person::class
//];
//print_r($res->get('person')->action());die("---");
//print_r($res['person']);
//print_r($res);
//$person = $res->getSingleton(Person::class);
//print_r($person);
ServerManager::getInstance()->setConfig($config)->createServer()->run();



