<?php
 class App{
    private $__controller, $__action, $__params;
    
    function __construct()
    {
        // mặc định giá trị truyền vào 
        $__action = 
        $__params = [];
        $this->handleUrl();
    }

    function getUrl(){
        if(isset($_SERVER['PATH_INFO'])){
            $url = $_SERVER['PATH_INFO'];
        }else $url = '/';

        return $url;
    }

    function handleUrl(){
        $url = $this->getUrl();
        
        // tách link ra mảng 
        $urlArr = array_values(array_filter(explode('/',$url)));

        // lấy controller 
        if(isset($urlArr[0])){
            $this->__controller = ucfirst($urlArr[0]);
        }else {
            // mặc đinh là index
            $this->__controller = ucfirst($this->__controller);
        }

        var_dump($this->__controller);
        if(file_exists('app/controllers/'.$this->__controller.'.php')){
            require_once 'app/controllers/'.$this->__controller.'.php';

            if (class_exists($this->__controller)){
                $this->__controller = new $this->__controller;
                unset($urlArr[0]);
            }else{
                die("không tìm thấy class");
            }
        }else {
            die("Controller not found");
        }

        if(isset($urlArr[1])){
            $this->__action = $urlArr[1];
            unset($urlArr[1]);//xóa để làm trống mảng rồi phục vụ cho params
        }

        $this->__params = array_values($urlArr);
        if(method_exists($this->__controller,$this->__action)){
            call_user_func_array([$this->__controller,$this->__action],$this->__params);
        }else{
            die("Callback thất bại");
        }
    }
 }