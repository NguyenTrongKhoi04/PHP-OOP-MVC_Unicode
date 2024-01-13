<?php 
// pre($dataPage);// all errors,msg,old_data_field in all field
// pre($dataPage['errors_Home']);// all errors tương ứng với từng fields
if(!empty($dataPage)){
    extract($dataPage);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h2 style="color: red;"><?= $msg_errors ?? '' ?> </h2>
    <form action="<?= _WEB_ROOT ?>/home/postUser" method="POST">

            <input type="text" name="fullname" placeholder="Họ tên" value="<?= $old_Data_Home['fullname'] ?? ''?>">
                <label style="color: red;" for=""><?= $errors_Home['fullname'] ?? '' ?></label>
            <br>
            <input type="text" name="age" placeholder="Tuổi" value="<?= $old_Data_Home['age'] ?? ''?>">
                <label style="color: red;" for=""><?= $errors_Home['age'] ?? '' ?></label>
            <br>
            <input type="text" name="email" placeholder="Email" value="<?= $old_Data_Home['email'] ?? '' ?>">
                <label style="color: red;" for=""><?= $errors_Home['email'] ?? '' ?></label>
            <br>
            <input type="text" name="password" placeholder="Mật khẩu" value="<?= $old_Data_Home['password'] ?? '' ?>">
                <label style="color: red;" for=""><?= $errors_Home['password'] ?? '' ?></label>
            <br>
            <input type="text" name="confirm_password" placeholder="Nhập lại mật khẩu" value="<?= $old_Data_Home['confirm_password'] ?? '' ?>">
                <label style="color: red;" for=""><?= $errors_Home['confirm_password'] ?? '' ?></label>
            <br>

        <button type="submit">Xác Nhận</button>
    </form>
</body>

</html>