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
        $data = $this->db
                ->table('airlines')
                ->join('user','product.cart = user.cart') 
                -> join('bill','bill.id_user = user.id_user')
                ->limit(4,0)
                ->orderBy('airline_name ASC , airline_id ASC')
                ->get();
        // $data = $this->table('check_test')->get();
        return $data;
    }

    function insertUser($data){
        return $this->db->table('airlines')->insert($data);
    }

    function updateUser($id,$data){
        // * nếu muốn thay đổi điều kiện, bạn gọi trực tiếp ở Controller của Home
        return $this->db->table('airlines')->where('airline_id','=',$id)->update($data);
    }

    function deleteUser($id){
        return $this->db->table('airlines')->where('airline_id','=',$id)->delete();
    }

    function lastInsertIdUser($data){
        $this->db->table('airlines')->insert($data);
        return $this->db->lastId();
    }
}