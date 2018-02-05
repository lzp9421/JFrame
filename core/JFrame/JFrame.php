<?php

namespace Core\JFrame;

use Library\Route\libRoute;
use Noodlehaus\Config;

class JFrame
{
    private $_config;

    public function __construct()
    {
        $this->_config = new Config(JFRAME_CONFIG_PATH . '/config.ini');
    }

    public function run()
    {
        // 加载路由表
        $libRoute = new libRoute();

        $router = $libRoute->dispatcher();

        $class = $this->_getClass($router);
        if(class_exists($class)){
            $controller = new $class();
            $method = "func" . ucfirst($router['method']);
            $controller->setOptions($router);
            $controller->$method();
        }else{

        }
    }

    /**
     * @param $router
     * @return Template
     */
    private function _getClass($router)
    {
        $control = "ctl" . ucfirst($router['control']);
        return "Module\\" . ucfirst($router['module']) . "\\" . $control;
    }
}