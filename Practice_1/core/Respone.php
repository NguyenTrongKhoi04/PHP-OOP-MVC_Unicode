<?php
class Respone{
    function redirect($uri = ''){
        // * tìm kiếm chuỗi "http" hoặc "https" trong văn bản, không phân biệt chữ hoa chữ thường và bao gồm cả dòng mới.
        if(preg_match('~http|https~is',$uri)){
            $url = $uri;
        }else{
            $url = _WEB_ROOT.'/'.$uri;
        }
        header('Location: ' . $url);
        exit;
    } 
}