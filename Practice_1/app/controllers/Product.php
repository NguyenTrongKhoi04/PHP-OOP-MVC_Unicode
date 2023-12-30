<?php
class Product extends Controller{
    private $id;
    private $product_Model;

    function __construct()
    {
        $this->product_Model = $this->model('ProductModel');
   
    }

    function getOneSanPham($data=0){
        /**
         * ! chưa xử lý được trường hợp $data=[] là 0 =>> đặt param ở bên App.php khi call lả biến
         * chưa khắc phục để extract data, tạm dùng index của data để sử dụng 
         */
        $this->data['sub_ContentPage']['sanPhamDauTien'] = $this->product_Model->getOneProduct($data);
        $this->info_Render('Trang Product','product/listsanpham','style','script');
    }
}