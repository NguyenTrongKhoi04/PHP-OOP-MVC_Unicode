<?php
// ! Thiếu extend
class ProductModel {

    function getOneProduct($id){
        $a = [
            'Sản phẩm 1',
            'Sản phẩm 2',
            'Sản phẩm 3',
            'Sản phẩm 4'
        ];
        return $a[$id];
    }
}