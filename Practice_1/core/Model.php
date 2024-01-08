<?php
/**
 * * Base Model
 */
abstract class Model extends Database{
    protected $db;
    
    
    function __construct(){
        // TODO: obj đã kết nối được với db và chứa các mehod query, fetch, fetchAll
        $this->db = new Database();
    }
    
    abstract function tableFill();

    abstract function fieldFill();
    
    abstract function primaryKey(); //TODO: field khi muốn tìm kiếm bằng  WHERE trong sql

    /**
     * * Những func ở đây được gọi trực tiếp ($this->func) ở bên ModelPage 
     * * Những method ko phải ở đây mà ở lớp trait query_builder thì sẽ phải gọi thông qua $this->db
     */
    public function all(){
        $tableFill = $this->tableFill();       
        $fieldFill = $this->fieldFill();   
        if(empty($fieldFill)){
            $fieldFill = ' * ';
        }   
        $sql= "SELECT $fieldFill FROM $tableFill";
        $stmt = $this->db->query($sql);
        if(!empty($stmt)){
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return false;
    }

    public function find($id){
        $tableFill = $this->tableFill();       
        $fieldFill = $this->fieldFill();   
        $primaryKey = $this->primaryKey();
        if(empty($fieldFill)){
            $fieldFill = ' * ';
        }   
        $sql= "SELECT $fieldFill FROM $tableFill WHERE $primaryKey = '$id' ";
        $stmt = $this->db->query($sql);
        if(!empty($stmt)){
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }
}