<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= _WEB_ROOT._CSS_ROOT_CLIENT.$CssPage.'.css' ?>">
    <title><?= $TitlePage?></title>
</head>
<body>
    
    <!-- <h2>Dữ liệu toàn bộ trang</h2>
     <?php 
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    ?> -->
    
    <?php $this->render('blocks/Header'); ?> 
    <?php 
        $sub_ContentPage = $sub_ContentPage ?? [];// ! mặc định dữ liệu = arr rỗng 

        // TODO: view + data được đổ vào trang đó
        if(isset($contentPage)&&isset($sub_ContentPage)){
            $this->render($contentPage,$sub_ContentPage); 
    }
    ?> 
    <?php $this->render('blocks/Footer') ?> 

    <script src="<?= _WEB_ROOT._JS_ROOT_CLIENT.$JsPage.'.js' ?>"></script>
</body>
</html>