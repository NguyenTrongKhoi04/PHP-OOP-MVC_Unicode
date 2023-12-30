<?php 
class Product extends Controller{

    public function index(){
        echo 'Danh sách sản phẩm';
    }

    public function list_product(){
       $product= $this->model('ProductModel');
        $data = $product->getProductList();

        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }
}