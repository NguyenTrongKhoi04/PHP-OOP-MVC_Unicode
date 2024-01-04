<?php

/**
 * *====================== DOCUMENT ========================
 *  SQL: SELECT field1, field2 FROM table_exam WHERE field LIKE '%keyword%';
 *  Query: $this->db->table('table_exam')->where('field1','=','Unicode')->where('id','>',3);
 *  SQl Result: SELECT * FROM table_exam Where field1 = 'Unnicode' AND id>3
 * 
 *  TODO: (WHERE) $this->db -> where(field,compre,value)
 *  TODO: (OrWhere) $this->db -> orwhere(field,compare,value)
 *  TODO: (get) $this->db -> get()
 *  TODO: (first) $this->db -> first()
 *  TODO: (table) $this->db -> table(name)
 *  TODO: (join) $this->db -> join(tableName,condition)
 *  TODO: (limit) $this->db -> limit(offset, number)
 *  TODO: (insert) $this->db -> table(name) -> insert($data)
 *  TODO: (update) $this->db -> table(name) -> where(field,compare,value) -> update($data)
 *  TODO: (delete) $this->db -> table(name) -> where(field,compare,value) -> delete()
 *  TODO: (whereLike) $this->db -> whereLike($field, $value)
 *  TODO: (select) $this->db ->select($field)
 *  TODO: (order by) $this->db->table()->orderby()
 *  TODO: (lastId) $this->db-lastId()
 */

trait QueryBuilder{
    /**
     * ? muốn lấy data => phải vào trong ModelPage (HomeModel, ProductModel,...) 
     *      ! tức là vẫn phải vào trong ModelPage sửa thì mới lấu được data như ý (WHERE, LiKE,...)
     * TODO: class QueryBuilder giúp bạn lấy dữ liệu trực tiếp khi đứng ở controller luôn
     * * Hiểu đơn giản thì class QueryBuilder là phân mở rộng của abstract Model
     * * Bạn có thể gọi các method trong trait này khi ở Model và Controller
     */

    public $tableName = '';
    public $where = '';
    public $operator = '';
    public $selectField = ' * ';
    public $limit = '';
    public $orderBy = '';
    public $innerJoin = '';

    public function table($table){
        $this->tableName = $table;
        return $this;
    }

    public function limit($number,$offset=0){
        $this->limit .= "LIMIT $offset, $number";
        return $this;
    }

    /**
     *  * ví dụ join 3 bảng với nhau khi có sẵn 1 bảng : join()->join()
     *  TODO: table('product as p')->join('u','p.cart = u.cart') -> join('bill as b','b.id_user = u.id_user')
     * */
    public function join($tableName,$relationship){
        $this->innerJoin .= "INNER JOIN $tableName ON $relationship ";
        return $this;
    }

    public function select($field =' * '){
        $this->selectField = $field;        
        return $this;
    }

    public function orderBy($field,$type = 'ASC'){
        // ! xử lý trường hợp orderBy('id ASC, name DESC")
        $arrField = array_filter(explode(",",$field));
        if(!empty($arrField) && count($arrField)>=2){
            $this->orderBy .= "ORDER BY ". implode(',',$arrField);
        }else{
            $this->orderBy .= "ORDER BY $field $type" ;
        }
        return $this;
    }

    public function insert($data){
        $tableName = $this->tableName;
        $insertStatus = $this->insert_InClassDatabase($tableName,$data);
        return $insertStatus;
    }

    public function update($data){
        $tableName = $this->tableName;
        $whereUpdate = str_replace('WHERE','',$this->where); // ? vì trong hàm update_InClassDatabase có WHERE nên cần bỏ WHERE ở đây đi
        $whereUpdate = trim($whereUpdate);
        $updateStatus = $this->update_InClassDatabase($tableName,$data,$whereUpdate);
        return $updateStatus;
    }
    
    public function delete(){
        $tableName = $this->tableName;
        $whereUpdate = str_replace('WHERE','',$this->where); // ? vì trong hàm update_InClassDatabase có WHERE nên cần bỏ WHERE ở đây đi
        $whereUpdate = trim($whereUpdate);
        $deleteStatus = $this->delete_InClassDatabase($tableName,$whereUpdate);
        return $deleteStatus;
    }

    public function lastId(){
        return $this->lastInsertId();
    }

    public function where($field, $compare, $value){
        if(empty($this->where)){
            $this->operator = ' WHERE ' ;
        }else{
            $this->operator = ' AND ';
        }
        $this->where .= "$this->operator $field $compare '$value' ";
        return $this;
    }

    public function orWhere($field, $compare, $value){
        if(empty($this->where)){
            $this->operator = ' WHERE ' ;
        }else{
            $this->operator = ' OR ';
        }
        $this->where .= " $this->operator $field $compare '$value' ";
        return $this;
    }

    public function whereLike($field, $value){
        if(empty($this->where)){
            $this->operator = ' WHERE ' ;
        }else{
            $this->operator = ' AND ';
        }
        $this->where .= " $this->operator $field LIKE '%$value%' ";
        return $this;
    }

    public function get(){
        $sqlQuery = " SELECT $this->selectField FROM $this->tableName $this->innerJoin $this->where $this->orderBy $this->limit  ";
        $sqlQuery = trim($sqlQuery);
        
        $query = $this->query($sqlQuery); // Thực hiện truy vấn
            // cách 2: viết obj db ở đây =>> $this->db->query($sqlQuery)

        // ? để các câu lệnh truy vấn ko bị đè lên nhau =>> sau khi truy vấn xong sẽ reset lại các thuộc tính (where,tableName,operator,selectField)
        $this->reset();

        if(!empty($query)){
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return false;
    }

    public function first(){
        $sqlQuery = " SELECT $this->selectField FROM $this->tableName $this->where $this->orderBy $this->limit ";
        // echo $sqlQuery; // Kiểm tra nếu gặp bug SQL
        $query = $this->query($sqlQuery); // Thực hiện truy vấn
            // cách 2: viết obj db ở đây =>> $this->db->query($sqlQuery)

        // ? để các câu lệnh truy vấn ko bị đè lên nhau =>> sau khi truy vấn xong sẽ reset lại các thuộc tính (where,tableName,operator,selectField)
        $this->reset();

        if(!empty($query)){
            return $query->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    public function reset(){
         $tableName = '';
         $where = '';
         $operator = '';
         $selectField = ' * ';
         $limit = '';
         $orderBy = '';
         $innerJoin = '';
    }
}
