<?php
class Route{
    private $__keyRoute = null;

    function Route_handlerUrl($url){
        global $routes;
        unset($routes['default_controller']);
        $url = trim($url,'/');

        $handler_Url = $url;
        if(isset($routes)){
            foreach($routes as $key=>$value){
                if(preg_match('~'.$key.'~is',$url)){
                    $handler_Url = preg_replace('~'.$key.'~is',$value,$url);
                    $this->__keyRoute = $key;
                    /**
                     * @params (điều kiện thay thế, chuỗi thay thế, chuỗi được thay thế)
                     * 
                     * <?php 
                     * $pattern = '/code/';
                     * $replacement = 'https://toidicode.com';
                     * $subject = 'code hoc lap trinh online - code';
                     * echo preg_replace($pattern, $replacement, $subject);
                     * 
                     *  =>> https://toidicode.com hoc lap trinh online - https://toidicode.com
                     * */ 

                }
            }
        }

        // Nếu URL bình thường, ko sử dụng URL ảo của Route thì vẫn sẽ ra được 
        return $handler_Url;
    }

    function getUri(){
        return $this->__keyRoute;
    }

    static function getFullUrl(){
        $uri = App::$app->getUrl();
        return _WEB_ROOT.$uri;
    }
}