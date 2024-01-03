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
            $con = new PDO($dsn,'root','');
        }catch(Exception $exception){
            $mess = $exception->getMessage();
            die($mess);
        }
    




