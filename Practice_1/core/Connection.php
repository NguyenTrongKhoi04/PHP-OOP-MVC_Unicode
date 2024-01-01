<?php
class Connection{
    private static $instance = null,$conn = null;
    
    private function __construct($config){
        try{
            // Cấu hình dsn
            $dsn = 'mysql:dbname='.$config['dbname'].';host='.$config['localhost']; 
            
            // Cấu Hình $options
            /**
             * - Cấu hình utf8
             * - Cấu hình ngoại lệ khi truy vấn bị lỗi
             */
            $options = [
                PDO::MYSQL_ATTR_INIT_COMMAND =>'SET NAME utf8',
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ];

            // Câu lệnh kết nối
            $con_db = new PDO($dsn,'root','');
            
            self::$conn= $con_db;
        }catch(Exception $exception){
            $mess = $exception->getMessage();
            die($mess);
        }
    }

    public static function getInstance($config){
        if(self::$instance == null){
              new Connection($config);
            self::$instance = self::$conn;
        }
        return self::$instance;
    }
}