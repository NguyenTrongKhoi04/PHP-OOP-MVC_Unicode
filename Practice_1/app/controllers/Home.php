<?php 
class Home extends Controller{
    private $model_Home;// obj để làm việc của page này

    function __construct()
    {
        $this->model_Home =  $this->model('HomeModel');// include file model chứa data vào     
    }
    
    // * param 1/2/3

    function index(){
        $this->data['sub_ContentPage']['dataPage'] = $this->model_Home->getHomeModel();
        // TODO: Lấy dự liệu bằng func dựng sẵn =>> $this->data['sub_ContentPage']['dataPage'] = $this->model_Home->get();

        $this->info_Render('Trang Home','home/index','style','script');
    }
    
}