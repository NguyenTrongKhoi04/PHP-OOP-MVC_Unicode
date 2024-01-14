<?php
class Session{

    /**
     * TODO: Tạo set & get Session
     * * Chỉ có $key => get
     * * Có cả $key và $value => set. $value có thể là arr
     * * empty($key & $value) => get all 
     */
    public static function data($key ='',$value=''){
        $sessionKey = self::isInvalid();// Lấy "session_1" để làm [lưu value] trong config Session

        if(!empty($value)){
            if(!empty($key)){
                $_SESSION[$sessionKey][$key] = $value; // set session
                return true;
            }
            return false;
        }else{
            if(empty($key)){
                if(isset($_SESSION[$sessionKey])){
                    return $_SESSION[$sessionKey]; // get all if empty($key)
                }
            }
            if(isset($_SESSION[$sessionKey][$key])){
                return $_SESSION[$sessionKey][$key]; // get session
            }
        }

        return false;
    } 

    /**
     * TODO: Xóa SESSION
     * * $key='' => xóa toàn bộ SESSION[session_1]
     * * nếu !empty($key) => xóa SESSION[session_1][$key]
     */
    public static function delete($key =''){
        $sessionKey = self::isInvalid();

        if(empty($key)){
            if(isset($_SESSION[$sessionKey])){
                unset($_SESSION[$sessionKey]);
                return true;
            }
            return false;
        }else{
            if(isset($_SESSION[$sessionKey][$key])){
                unset($_SESSION[$sessionKey][$key]);
                return true;
            }
        }
    }

    /**
     * ? Flash Data
     * TODO: giống func data() nhưng get xong xóa luôn
     * * !empty($key) => get & delete($key); 
     * * !empty($key & $value) => set 
     * return 
     */
    public static function flash_Data($key ='',$value =''){
        $dataFlash = self::data($key,$value);
        if(empty($value)){
            self::delete($key);
        }
        return $dataFlash;
    }

    /**
     * TODO: Extract $data & Load View error 
     */
    public static function showErrors($message){
        $data = ["message" => $message];
        App::$app->loadError('ErrorSession',$data);
        die;
    }

    /**
     * TODO: Kiểm tra xem có config session hay chưa
     * * config ở đây là => $config['session'] = ["test_session"=>"session_1"]
     * return session_1
     */
    public static function isInvalid(){
        global $config;
        if(!empty($config['session'])){
            $config_Session = $config['session'];
            if(!empty($config_Session['test_session'])){
                $sessionKey = $config_Session['test_session'];
                return $sessionKey;
            }else{
                self::showErrors("kiểm tra lại key=>value trong giá trị cấu hình của [session]");
            }
        }else{
            self::showErrors("Chưa có cấu hình session");
        }
    }
}