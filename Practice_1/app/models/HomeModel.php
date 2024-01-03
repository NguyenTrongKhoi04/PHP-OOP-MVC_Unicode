<?php
class HomeModel extends Model{

    function __construct()
    {
        parent::__construct();// run __contruct của class cha

    }

    function fieldFill(){
        return ' * ';
    }

    function tableFill(){
        return ' airlines ';
    }

    function primaryKey(){
        return ' id ';
    } 

    
    function getHomeModel(){
        /**
         * TODO: lấy all data của bảng
         * * cách 1: $data = $this->db -> query("SELECT * FROM table")->fetchAll(PDO::FETCH_ASSOC);
         * * cách 2: $data = $this->get();
         *      ! không thể $this->db->get() vì obj 'db' ko có method get()
         */
        $data = $this->db->table('airlines')->whereLike('airline_name','v')->where(' airline_id ',' = ', 1)->get();
        // $data = $this->table('check_test')->get();
        return $data;
    }
}