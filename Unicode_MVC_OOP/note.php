<?php

// in mảng
echo '<pre>';
print_r($arr);
echo '</pre>';

//luồng chương trình
    // index.php Tổng -> bootstrap.php -> app/App.php (phân phối controller) -> controllers/....
    //  app/App.php:  __construct() -> getUrl()-(Phân tích URL) + handleUrl()-(Require controller tương ứng với URL) + loadError()-(Load lỗi)