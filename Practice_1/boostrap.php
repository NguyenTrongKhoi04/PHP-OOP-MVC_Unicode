<?php
define('_THU_MUC_GOC', __DIR__);//C:\xampp\htdocs\PHP_2_OOP\Demo_PHP_OOP_Unicode\Practice_1

/**
 * ==================================================
 *                      USER
 * ==================================================
 */
define('_CSS_ROOT_CLIENT','/publics/assets/client/css/');
define('_JS_ROOT_CLIENT','/publics/assets/client/js/');


/**
 *  TODO: xử lý link css, js ở master layout
 */
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ){
    $web_HTTP_Host = 'https://'.$_SERVER['HTTP_HOST'];
}else $web_HTTP_Host = 'http://'.$_SERVER['HTTP_HOST'];
$web_Root_Directory_search = str_replace('\\','/',_THU_MUC_GOC);
$web_Root = str_replace(strtolower($_SERVER['DOCUMENT_ROOT']),'',strtolower($web_Root_Directory_search));
// ! đường dẫn trên server thường thì không phân biệt hoa thường (1 số ít server vẫn phân biệt)

define('_WEB_ROOT',$web_HTTP_Host.$web_Root);

// TODO: Check arr
function pre($arr){
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
}


/**
 * TODO: include tất cả các file trong folder configs
 * * xử lý những phần thừa trong mảng khi use scandir
 */
$arr_directory = scandir('configs');
    foreach($arr_directory as $item){
        if($item != '..' && $item != '.' && file_exists('configs/'.$item)){
            include_once 'configs/'.$item ;   
        }
    }

/**
 * TODO: Kiểm tra và inclune file Core/Connection.php 
 */
if(isset($config['database'])){
    $db_config = array_filter($config['database']);

    if(!empty($db_config)){
        include_once 'core/Connection.php'; // file chứa thông tin về db 
        include_once 'core/Database.php'; // file để khởi tạo kết nối với Class Connection
    }
}
include_once 'core/Model.php';
include_once 'core/Route.php';
include_once 'app/App.php';
include_once 'core/Controller.php';

// pre(get_included_files());

// echo $_SERVER['DOCUMENT_ROOT'];
// echo '<br>';
// echo _THU_MUC_GOC;
// echo '<br>';
// echo $_SERVER['HTTP_HOST'];
// echo '<br>';
// echo '<br>';

