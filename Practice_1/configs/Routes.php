<?php
/**
 * TODO: INFO Cấu hình Route
 * ! Vẫn chưa giải quyết được khi nhập $value của routes thì vẫn chạy được 
 */
$routes['default_controller'] = 'home';

/**
 * hoạt động theo nguyên tắc: $key => $value
 * link Ảo => link thật
 */
$routes['trang-chu'] = 'home';

/**
 * ? Giải thích Regex 
 * * "+" -> ví dụ: a+ (a,aa,aaa,...., ít nhất 1 ký tự a)
 * * "-" là phạm vi [A-Z],[0-9]
 *      ! "\-" có nghĩa dấu - 
 * * "\d" bất kỳ số nào (nguyên dương)
 * TODO: Ví dụ: sanpham-id-20.html
 * 
 * *$1 là nhóm con thứ nhất 
 *      =>> ví dụ: 01-23-333 
 *          +> $1 là nhóm con thứ 1 và có giá trị "01"  
 *          +> $2 là nhóm con thứ 2 và có giá trị "23"  
 *          +> $3 là nhóm con thứ 3 và có giá trị "333"  
 */
$routes['san-pham/.+\-(\d+).html'] = 'product/getOneSanPham/$1';//ví dụ: san-pham/chi-tiet-1.html
$routes['test-dashboard'] = 'dashboard';

// csllback 
// home/index/param

// class home controller
// method index($arr[]){
        
// }
