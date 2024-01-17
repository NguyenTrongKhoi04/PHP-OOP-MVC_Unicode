<?php
/**
 * * Load View và Model ở bên MiddleWare nếu cần cùng tới view và Model
 */
class MiddleWare_LoadViewModel{
    static public function model($model){
        if(file_exists(_THU_MUC_GOC.'/app/models/'.$model.'.php')){
            include_once _THU_MUC_GOC.'/app/models/'.$model.".php";
            if(class_exists($model)){
                $object = new $model;
                return $object;
            }
        }
        else return false ;       
    }

    static public function render($view,$data = []){
        extract($data);
        if(file_exists(_THU_MUC_GOC.'/app/views/'.$view.'.php')){
            include_once _THU_MUC_GOC.'/app/views/'.$view.".php"; 
        }
        else return false ; 
    }
}