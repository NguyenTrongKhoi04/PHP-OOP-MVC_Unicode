<?php
/**
 * * chứa các câu lệnh cơ bản query, fetch, fetchAll
 */
class Database{
    private $__conn;

    function __construct(){
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

        $statement = $this->__conn->prepare($sql);
        $statement->execute();
        return $statement;
    }

    function lastInsertId(){
        return $this->__conn->lastInsertId();
    }
}