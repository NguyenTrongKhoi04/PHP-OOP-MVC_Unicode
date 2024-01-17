<?php
/**
 * * Cấu hình MiddleWare cho từng Routes và MiddleWare global-tất cả Request đều chạy qua
 * TODO: Sau khi nhận được Request & $keyRoute thì ở đây sẽ điều hướng làm gì sau khi biết $keyRoute
 * ! Vẫn chưa giải quyết được khi nhập $value của routes thì vẫn chạy được 
 */
$config['MiddleWare'] = [
    'routeMiddleWare' => [
        'trang-chu' => AuthorMiddleWare::class,
        'san-pham/.+\-(\d+).html' => 'product/getOneSanPham/$1',
        // 'san-pham/.+\-(\d+).html' => AuthorMiddleWare::class, // TODO: xử lý sẽ tùy ý coder sau khi biết $keyRoute
    ],
    
    'globalMiddleWare' => [
        ParamMiddleWare::class
    ]
];