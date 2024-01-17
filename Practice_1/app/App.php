<?php
class App
{
    private $__controller, $__action, $__param, $__route;
    private $__db; // tạo ra instance của Global query builder

    public static $app;// * Là obj App để gọi được hàm loadError ở class khác
    
    function __construct()
    {
        global $routes;

        self::$app = $this;

        $this->__route = new Route;

        if (isset($routes['default_controller'])) {
            $this->__controller = $routes['default_controller'];
        }

        $this->__action     = 'index';
        $this->__param      = [];

        if(class_exists('DB')){
            $db_Flag = new DB;
            $this->__db = $db_Flag->db; // ? 'db' là thuộc tính của class DB
        }

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
        
        // TODO: xử lý $keyRouter với MiddleWare
        $this->globalHandleMiddleWare();
        $this->handleMiddleWare($this->__route->getUri());

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
                
                if(!empty($this->__db)){
                    $this->__controller->db = $this->__db;// TODO: Khời tạo Global Query trong Base Controller  
                }

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
            // ! mới chỉ truyền được 1 param ,cần xử lý truyền được mảng 
        }
    }

    // ? Lây controller hiện tại
    public function getController(){
        return $this->__controller;
    }

    public function loadError($file='404',$data =[])
    {
        extract($data);
        include_once 'errors/'.$file.'.php';
    }

    public function handleMiddleWare($keyRoute){
        global $config;
        $keyRoute = trim($keyRoute);

        // pre($config['MiddleWare']['routeMiddleWare']);
        if(!empty($config['MiddleWare']['routeMiddleWare'])){
            $routeMiddleWareArr = $config['MiddleWare']['routeMiddleWare'];
            foreach($routeMiddleWareArr as $itemMiddleWare => $valueMiddleWare){
                if($keyRoute == trim($itemMiddleWare) &&file_exists("app/middleware/".$valueMiddleWare.".php")){
                    include_once "app/middleware/".$valueMiddleWare.".php";
                    if(class_exists($valueMiddleWare)){
                        $middleWareObj = new $valueMiddleWare();
                        $middleWareObj->db = $this->__db; //TODO: kết nối MiddleWare với DB
                        $middleWareObj -> handle();
                    }
                }
            }
        }
    }

    public function globalHandleMiddleWare(){
        global $config;

        if(!empty($config['MiddleWare']['globalMiddleWare'])){
            $global_RouteMiddleWareArr = $config['MiddleWare']['globalMiddleWare'];
            foreach($global_RouteMiddleWareArr as $itemMiddleWare => $valueMiddleWare){
                if(file_exists("app/middleware/".$valueMiddleWare.".php")){
                    include_once "app/middleware/".$valueMiddleWare.".php";
                    if(class_exists($valueMiddleWare)){
                        $middleWareObj = new $valueMiddleWare();
                        $middleWareObj->db = $this->__db; //TODO: kết nối MiddleWare với DB
                        $middleWareObj -> handle();
                    }
                }
            }
        }
    }
}

