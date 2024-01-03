<?php
class Connection{
    // * static = biến tham chiếu, ví dụ lúc đầu bạn gán = 1 rồi sau bạn gán giá trị khác =>> biến được gán static thì sẽ bằng giá trị sau cùng
    private static $instance = null,$conn = null;
                    /**
                     * TODO: $instance là biến dùng để khởi tạo kết nối, check xem đã kết nối chưa
                     *          ! tức là muốn kết nối thì phải gọi nó
                     * TODO: $conn => obj của database
                     */
    
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
            $data['mess'] = $mess;
            App::$app->loadError('Database',$data);
            die;
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