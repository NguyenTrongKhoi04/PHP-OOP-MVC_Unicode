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
// ! đường dẫn trên server thường thì không phân biệt hoa thường (1 số vẫn phân biệt)

define('_WEB_ROOT',$web_HTTP_Host.$web_Root);

// TODO: Check arr
function pre($arr){
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
}

include_once 'core/Route.php';
include_once 'configs/Routes.php';
include_once 'app/App.php';
include_once 'core/Controller.php';

// echo $_SERVER['DOCUMENT_ROOT'];
// echo '<br>';
// echo _THU_MUC_GOC;
// echo '<br>';
// echo $_SERVER['HTTP_HOST'];
// echo '<br>';
// echo '<br>';

// $urlArr = [
//     'nguyen',
//     'trong',
//     'khoi',
//     'index'
// ];
// $urlCheck = '';
// foreach ($urlArr as $key => $item) {
//     $urlCheck .= $item . '/';
//     $fileCheck = rtrim($urlCheck, '/');
//     $fileArr = explode('/', $fileCheck);
//     $fileCheck = implode('/', $fileArr);
//     var_dump($fileCheck);
//     echo '<br>';
//     echo $key;
//     echo $urlArr[$key - 1];
//     echo '<br>';
//     unset($urlArr[$key - 1]);
//     echo '<pre>';
//     print_r($urlArr);
//     echo '</pre>';
//     var_dump('/app/' . $fileCheck . '.php');
//     echo '<br>';
//     if (file_exists('app/' . $fileCheck . ".php")) {
//         echo '<pre>';
//         print_r($urlArr);
//         echo '</pre>';
//         break;
//     }
//     echo '<br>';
//     echo '<br>';
// }
// echo '<pre>';
// print_r($urlArr);
// echo '</pre>';

// echo '<br>';
// echo '<br>';
// $face_link = str_replace('/','\\',$_SERVER['DOCUMENT_ROOT']);

// $link = str_replace($face_link,'',_THU_MUC_GOC);
// echo $link;