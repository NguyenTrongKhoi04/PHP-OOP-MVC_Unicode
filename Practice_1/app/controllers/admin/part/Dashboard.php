<?php
class Dashboard extends Controller{
    function index(){
        /**
         * Đây là test, chưa có trang view của dashboard
         */
        $this->data['sub_ContentPage']['dataPage'] = 3;
        $this->info_Render('Dashboard','Dashboard/index');
    }
}