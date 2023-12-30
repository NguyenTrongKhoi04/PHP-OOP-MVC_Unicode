<?php 
class Home extends Controller{
    private $model_Home;// obj để làm việc của page này

    function __construct()
    {
        $this->model_Home =  $this->model('HomeModel');     
    }
    
    function index(){
        $this->data['sub_ContentPage']['dataPage'] = $this->model_Home->getHomeModel();
        $this->info_Render('Trang Home','home/index','style','script');
    }
    
}