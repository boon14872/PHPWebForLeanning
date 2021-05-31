<?php
require 'include/init.php';
if(isset($_POST['email']) && isset($_POST['pass']))
{
    if(!empty($_POST['email']) && !empty($_POST['pass']))
    {
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        $result = $user_obj->login($email,$pass);
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ</title>
    <link rel="stylesheet" href="bootstrap-4.1.3-dist/css/bootstrap.min.css">

</head>
<body>
    <div class="container">
        <center>
        <p class="h1">เข้าสู่ระบบ</p>
        <img src="image/Untitled-1.png" width="202px;" height="167px;" class="counded-circle" >
        <form action="" method="post">
        <div class="form-floating row p-2">
            <label for="E-mail">อีเมล</label>
            <input type="email" class="form-control col-12 p-2" id="E-mail" name="email">
        </div>
        <div class="form-floating row p-2">
            <label for="password">รหัสผ่าน</label>
            <input type="password" class="form-control col-12 p-2" id="password" name="pass">
        </div>
        <?php
            if(isset($result['error']))
            {
                echo '<div class="alert alert-danger">'.$result['error'].'</div>';
            }
        ?>
        <button type="submit" class="btn btn-primary btn-mx btn-blook p-2">เข้าสู่ระบบ</button>
        </form>
        <div class="p-2">
            <a href="regis.php" type="submit" class="btn btn-danger btn-mx btn-blook">สมัครสมาชิก</a>
        </div>
        
    </center>
    </div>
</body>
</html>