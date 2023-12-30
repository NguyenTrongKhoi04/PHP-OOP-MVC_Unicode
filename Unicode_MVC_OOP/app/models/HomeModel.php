<?php
class HomeModel{

    protected $_table = 'products';

    public function getList(){
        $data = [
            'nguyen',
            'trong',
            'khoi',
        ];
        return $data;
    }

    public function getDetail($id){
        $data = [
            'nguyen',
            'trong',
            'khoi',
        ];
        return $data[$id];
    }
}