<?php
require 'include/init.php';
if(isset($_POST['email']) && isset($_POST['pass']) && isset($_POST['fname']) && isset($_POST['lname']))
{
    $name = $_POST['fname']." ".$_POST['lname'];
    if(!empty($_POST['email']) && !empty($_POST['pass']) && !empty($name))
    {
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        $result = $user_obj->register($email,$pass,$name);
        if(empty($result['error']))
        {
            header('location:login.php');
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สมัครสมาชิก</title>
    <link rel="stylesheet" href="bootstrap-4.1.3-dist/css/bootstrap.min.css">
    <script src="bootstrap-4.1.3-dist/jquery-3.6.0.min.js"></script>

</head>
<body>
    <div class="container">
        <center>
        <img src="image/12.png" width="100px;" height="100px;" class="rounded-circle">
    </center>
    <form action="" method="post" id="formregis">
    <div class="form-floating row  p-2 ">
        <div class="col-6">
            <label for="firstname">ชื่อ</label>
            <input type="firstname" class="form-control col-12 p-2" id="firstname" name="fname">
        </div>
        <div class="col-6 ">
            <label for="lastname">สกุล</label>
            <input type="lastname" class="form-control col-12 p-2 " id="lastname" name="lname">
        </div>
    </div>
        <div class="form-floating p-2">
            <label for="E-mail">อีเมล</label>
            <input type="email" class="form-control col-12 p-2" id="E-mail" name="email">
        </div>
        <div class="form-floating  p-2">
            <label for="password">รหัสผ่าน</label>
            <input type="password" class="form-control col-12 p-2" id="password" name="pass">
            <label for="repassword" class="text-danger h5" id="alerttext"></label>
        </div>
        <div class="form-floating  p-2">
            <label for="repassword">ยืนยันรหัสผ่าน</label>
            <input type="password" class="form-control col-12 p-2" id="repassword" name="repass">
            <label for="repassword" class="text-danger h5" id="alerttext"></label>
        </div>
        <center>
        <?php
            if(isset($result['error']))
            {
                echo '<div class="alert alert-danger">'.$result['error'].'</div>';
            }
        ?>
        <button type="submit" class="btn btn-info btn-mx btn-blook p-2" id="regisub">สมัครสมาชิก</button>
        <div class="p-2">
        <a href="login.php" class="btn btn-success btn-mx btn-blook p-2">เข้าสู่ระบบ</a>
        </div>
        
    </center>
    </form>
    </div>
</body>
</html>