<?php
/**
 * swoole 服务框架演示
 */

namespace Psf\Server;

use Psf\Traits\AppTrait;
use Psf\Traits\SingletonTrait;
use Swoole\Http\Server;

class ServerManager
{
    use AppTrait, SingletonTrait;
    public static $serverApp;
    public $coroutine_id;
    private $server;
    private static $instance;
    public static $config = [];

    /**设置配置
     * @param $config
     * @return $this
     */
    public function setConfig($config)
    {
        self::$config = $config;
        return $this;
    }

    /**创建服务
     * @return $this
     */
    public function createServer()
    {
        $this->server = new Server(self::$config['server']['host'], self::$config['server']['port']);
        $this->buildServerCallBack();
        return $this;
    }

    /**
     * 构建服务回调事件
     */
    public function buildServerCallBack()
    {
        $this->server->on('WorkerStart', [$this, 'WorkerStart']);
        $this->server->on('Request', [$this, 'onRequest']);
    }

    /**工作进程初始化（初始化工作进程资源）
     * @param $server
     * @param $worker_id
     */
    function WorkerStart($server, $worker_id)
    {
        self::clearCache();
        echo "onWorkerStart:" . $worker_id . "\r\n";
        $includeFiles = get_included_files();
        file_put_contents("./includeFiles.txt", var_export($includeFiles, true));
        self::$serverApp = new ServerApp();
    }

    /**
     * clearCache 清空字节缓存
     * @return  void
     */
    public static function clearCache()
    {
        if (function_exists('apc_clear_cache')) {
            apc_clear_cache();
        }
        if (function_exists('opcache_reset')) {
            opcache_reset();
        }
    }

    /**事件请求回调
     * @param $request
     * @param $response
     */
    public function onRequest($request, $response)
    {
        if ($request->server['request_uri'] == '/favicon.ico') {
            $response->status(404);
            $response->end();
            return;
        }
        ob_start();

//        $_POST = [];
//        if (isset($request->post)) {
//            foreach ($request->post as $key => $value) {
//                $_POST[strtoupper($key)] = $value;
//            }
//        }
//        $_GET = [];
//        if (isset($request->get)) {
//            foreach ($request->get as $key => $value) {
//                $_GET[strtoupper($key)] = $value;
//            }
//        }
//        $_SERVER = [];
//        if (isset($request->server)) {
//            foreach ($request->server as $key => $value) {
//                $_SERVER[strtoupper($key)] = $value;
//            }
//        }
//        if (isset($request->header)) {
//            foreach ($request->header as $key => $value) {
//                $_SERVER[strtoupper($key)] = $value;
//            }
//        }
//        $_FILES = [];
//        if (isset($request->files)) {
//            foreach ($request->files as $key => $value) {
//                $_FILES[strtoupper($key)] = $value;
//            }
//        }
        try {
            self::$serverApp->run($request, $response);
            //print_r(ServerManager::$app);
            $result = ob_get_contents();
            ob_end_clean();
            self::removeApp(); //回收协程上下文资源
            $response->header('Content-Type', 'text/html');
            $response->header('Charset', 'utf-8');
            $response->end($result);
        } catch (\Exception $e) {
            $response->end($e->getMessage());
        }

    }

    public function run()
    {
        $this->server->start();
    }


}