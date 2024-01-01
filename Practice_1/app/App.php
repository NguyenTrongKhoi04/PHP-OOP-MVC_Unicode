<?php
class App
{
    private $__controller, $__action, $__param, $__route;

    function __construct()
    {
        global $routes;

        $this->__route = new Route;

        if (isset($routes['default_controller'])) {
            $this->__controller = $routes['default_controller'];
        }

        $this->__action     = 'index';
        $this->__param      = [];

        $this->handlerUrl();
    }

    function getUrl()
    {
        if (isset($_SERVER['PATH_INFO'])) {
            $url = $_SERVER['PATH_INFO'];
        } else $url = '/';

        return $url;
    }

    function handlerUrl()
    {
        $url = $this->getUrl();
        $url = $this->__route->Route_handlerUrl($url);

        $arrayUrl = array_values(array_filter(explode('/', $url)));
        // var_dump(explode('/', $url));

        $arrCheck = '';
        if (isset($arrayUrl)) {
            foreach ($arrayUrl as $key => $value) {
                $arrCheck .= $value . '/';
                $fileCheck = rtrim($arrCheck, '/');
                $fileArr = explode('/', $fileCheck);
                $fileArr[count($fileArr) - 1] = ucfirst($fileArr[count($fileArr) - 1]);
                $fileCheck = implode('/', $fileArr);

                unset($arrayUrl[$key - 1]);
                if (file_exists("app/controllers/" . $fileCheck . ".php")) {
                    $arrayUrl = array_values($arrayUrl);
                    $arrCheck = $fileCheck;
                    break;
                }
            }
        }

        if (isset($arrayUrl[0])) {
            $this->__controller = ucfirst($arrayUrl[0]);
            unset($arrayUrl[0]);
        } else $this->__controller = ucfirst( $this->__controller);
        
        /**
         * TODO: Render Page
         */
        
        // khi $arrCheck rỗng thì gán mặc định là home 
        if(empty($arrCheck)){
            $arrCheck = $this->__controller;
        }

        if (file_exists("app/controllers/" . $arrCheck . ".php")) {
            include_once "controllers/" . $arrCheck . ".php";

            if (class_exists($this->__controller)) {
                $this->__controller = new $this->__controller;
            } else echo "không tìm thấy class của {$this->__controller} này";
        } else $this->loadError();

        //action
        if (isset($arrayUrl[1])) {
            $this->__action = $arrayUrl[1];
            unset($arrayUrl[1]);
        };

        //param
        $this->__param = array_values($arrayUrl);

        if (method_exists($this->__controller, $this->__action)) {
            call_user_func_array([$this->__controller, $this->__action], $this->__param);
            // ! mới chỉ truyền được 1 param 
        }
    }

    public function loadError()
    {
        include_once 'errors/404.php';
    }
}
