<?php
/**
 * * tạo đối tượng để kết nối với db
 * * chứa các câu lệnh cơ bản query, fetch, fetchAll
 */
class Database{
    public $__conn;

    use QueryBuilder;// sử dụng những truy vấn phức tạp được dựng sẵn 

    function __construct(){
        // TODO: khời tạo đối tượng connect để truy vấn với db
        global $db_config;
        $this->__conn = Connection::getInstance($db_config);    
    }

    function insert($table,$data){
        if(!empty($data)){
            $fieldStr = '';
            $valueStr = '';
            foreach($data as $key=>$value){
                $fieldStr .=$key.',';
                $valueStr .="'".$value."'";
            }

            $fieldStr = rtrim($fieldStr, ',');
            $valueStr = rtrim($valueStr, ',');

            $sql = "INSERT INTO $table($fieldStr) VALUES ($fieldStr)";

            $status = $this->query($sql);
            if($status){
                return true;
            }
        }
        return false;
    }

    function update($table,$data,$condition = ''){
        if(!empty($data)){
            $updateStr = '';
            foreach($data as $key=>$value){
                $updateStr.="$key.='$value',";
            }

            $updateStr = rtrim($updateStr,',');

            if(!empty($condition)){
                $sql = "UPDATE $table SET $updateStr WHERE $condition";
            }else{
                $sql = "UPDATE $table SET $updateStr";
            }

            $status = $this->query($sql) ;

            if($status){
                return true;
            }
        }

        return false;
    }

    function delete($table,$condition = ''){
        if(!empty($condition)){
            $sql = 'DELETE FROM '.$table.' WHERE ' .$condition;
        }else{
            $sql = 'DELETE FROM '.$table;
        }

        $status = $this->query($sql);

        if($status){
            return true;
        }

        return false;
    }

    function query($sql){
        try{    
            if(empty($this->__conn)){
                die('chưa tạo được đối tượng kết nối với db');
            }
            $statement = $this->__conn->prepare($sql);
            $statement->execute();
            return $statement;
        }catch(Exception $exception){
            $mess = $exception->getMessage();
            $data['mess'] = $mess;
            $data['sql'] = $sql;
            App::$app->loadError('Query',$data);
            die;
        }
    }

    function lastInsertId(){
        return $this->__conn->lastInsertId();
    }
}