<?php
class HomeModel extends Model{
    private $_table = 'airlines2';
    function __construct()
    {
        parent::__construct();// run __contruct của class cha
    }

    function getHomeModel(){
        $db = new Database();
        return $db -> query("SELECT * FROM $this->_table")->fetchAll(PDO::FETCH_ASSOC);
        
    }
}