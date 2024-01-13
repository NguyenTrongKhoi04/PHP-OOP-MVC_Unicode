<?php
class Session{

    public static function showErrors($message){
        $data = ["message" => $message];
        App::$app->loadError('ErrorSession',$data);
        die;
    }

    /**
     * TODO: Kiểm tra xem có config session hay chưa
     * * config ở đây là => $config['session'] = ["test_session"=>"session_1"]
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