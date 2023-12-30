<?php
class App
{
    private $__controller, $__action, $__params;
    
    function __construct()
    {
        global $routes;// khai báo mảng để dùng đc 

        // Mặc định trỏ vào $routes['default_controller']
        if(!empty($routes['default_controller'])){
            $this->__controller = $routes['default_controller'];
        }
        $this->__action = 'index';
        $this->__params = [];

        $this->handleUrl();
    }

    function getUrl()
    {
        if (isset($_SERVER['PATH_INFO'])) {
            $url = $_SERVER['PATH_INFO'];
        } else $url = '/';

        return $url;
    }

    // hàm xử URL, Require ra Controllers tương ứng
    public function handleUrl()
    {
        // URL từ hàm getURL
        $url = $this->getUrl();
        // xplode =>> tách chuỗi thành mảng
        // "Home/index/a/b/c/" sẽ bị thừa khoảng trắng ở vị trí cuối & đầu =>> array_filter
        $urlArr = array_filter(explode('/', $url));
        // thứ tự theo đúng STT quy định ở mảng (Start = 0)           
        $urlArr = array_values($urlArr);

        // xử lý Controller
        if (!empty($urlArr[0])) {
            $this->__controller = ucfirst($urlArr[0]);
            // ucfirst =>> viết hoa chữ cái đầu 
        }else{
            $this->__controller= ucfirst($this->__controller);
        }

         //Nếu tồn tại thì vào file đó 
         if (file_exists('app/controllers/' . ($this->__controller) . '.php')) {
            require_once 'controllers/' . ($this->__controller) . '.php';

            // Kiểm tra class $this->__controller tồn tại
            if(class_exists($this->__controller)){
                $this->__controller = new $this->__controller;
                unset($urlArr[0]);//xóa đối tượng trong mảng
            }else $this->loadError();

        } else {
            $this->loadError();
        }

        // xử lý action
        if(!empty($urlArr[1])){
            $this->__action = $urlArr[1];  
            unset($urlArr[1]);
                // nếu không tồn tại thì sẽ mặc định gọi action = index() 
        } 
        
        // Xử lý params
        $this->__params = array_values($urlArr);

        // TODO: truyền tham số param vào trong action 
        if(method_exists($this->__controller,$this->__action)){
            call_user_func_array([$this->__controller,$this->__action],[$this->__params]);
                                                    // ! phải là mẩng thì mới lấy đủ data để truyền sang bên kia
                                                    // ! chưa xử lý triệt để được 
        }else{
            $this->loadError();
        }

            // callback bất kỳ 1 hàm nào =>> 2 tham số ('vị trí hàm ddc callback','mảng')
                    // nếu là hàm đc callbakc k có tham số =>> mảng = []
            // TODO: =>> tức là callback lại hàm đó với những tham số m truyển vào
    }   

    public function loadError($name = '404')
    {
        require_once 'errors/' . $name . '.php';
    }
}
