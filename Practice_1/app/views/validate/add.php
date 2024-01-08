<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="<?= _WEB_ROOT ?>/home/postUser" method="POST">

            <input type="text" name="fullname" placeholder="Họ tên" id="">
            <br>
            <input type="text" name="email" placeholder="Email" id="">
            <br>
            <input type="text" name="password" placeholder="Mật khẩu" id="">
            <br>
            <input type="text" name="confirm_password" placeholder="Nhập lại mật khẩu" id="">
            <br>

        <button type="submit">Xác Nhận</button>
    </form>
</body>

</html>