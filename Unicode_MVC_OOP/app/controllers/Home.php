<?php
    class Home extends Controller{

        public $model_home;

        public function __construct(){
            $this->model_home = $this->model('HomeModel');
            /**
             * lúc này $this->model là 1 biến thành viên của obj cụ thể 
             * Biến này được các method trong class Home sử dụng 
             */
            $this->model_home = new HomeModel();

        }

        public function index(){
            echo "Trang chủ";
        }
public function Hello(){
    echo "khoi";
}
 
    }