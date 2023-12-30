<?php
class Controller{

    protected $data=[];

    function model($model){
        if(file_exists(_THU_MUC_GOC.'/app/models/'.$model.'.php')){
            include_once _THU_MUC_GOC.'/app/models/'.$model.".php";
            if(class_exists($model)){
                $object = new $model;
                return $object;
            }
        }
        else return false ;       
    }

    /**
     * TODO: View + data
     */
    function render($view,$data = []){
        extract($data);
        
        if(file_exists(_THU_MUC_GOC.'/app/views/'.$view.'.php')){
            include_once _THU_MUC_GOC.'/app/views/'.$view.".php"; 
        }
        else return false ; 
    }

    /**
     * TODO: thông số của render
     */
    function info_Render($TitlePage,$contentPage,$css_Page='',$js_Page=''){
        // mới chỉ xử lý css cho 1 style, ch xử lý cho 2 style
        $this->data['CssPage'] = $css_Page;
        $this->data['JsPage'] = $js_Page;
        $this->data['TitlePage'] = $TitlePage;
        $this->data['contentPage'] = $contentPage;
        $this->render('layouts/Client_Layout',$this->data);
    }
}