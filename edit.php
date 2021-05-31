<?php
require 'include/init.php';
$uid = $_SESSION['bweb']['uid'];
if(isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['pass_old']) && isset($_POST['pass_new']))
{
    if(!empty($_FILES['edit_img']['name']))
    {
        $dir = 'uimg/';
        $extfilename = strtolower(pathinfo($_FILES['edit_img']['name'],PATHINFO_EXTENSION));
        $newname_img = $uid."_".time()."_".rand(10000,99999).".".$extfilename;
        if(move_uploaded_file($_FILES['edit_img']['tmp_name'],$dir.$newname_img))
        {
            $update_img = $newname_img;
        }
        else
        {
            $update_img = null;
        }
    }
    else
    {
        $update_img = $_SESSION['bweb']['profile'];
    }
    $newname = $_POST['fname']." ".$_POST['lname'];
    $result = $user_obj->update($uid,$newname,$_POST['pass_old'],$_POST['pass_new'],$update_img);
    if($result)
    {
        $user_obj->login($_SESSION['bweb']['email'],$_POST['pass_new']);
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูลส่วนตัว</title>
    <link rel="stylesheet" href="bootstrap-4.1.3-dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <center>
            <p class="h1">แก้ไขข้อมูลส่วนตัว</p>
    </center>
       <form action="" method="post" enctype="multipart/form-data">
       <div class="form-floating row  p-2 ">
            <div class="col-6">
                <label for="firstname">ชื่อ</label>
                <input type="firstname" class="custom-floating col-12 p-2" id="firstname" name="fname" required>
            </div>
            <div class="col-6 form-custom">
                <label for="lastname">สกุล</label>
                <input type="lastname" class="custom-floating col-12 p-2 " id="lastname" name="lname" required>
            </div>
        </div>
            <div class="form-floating p-2">
                <label for="password old">รหัสผ่านเก่า</label>
                <input type="password" class="custom-floating col-12 p-2" id="password" name="pass_old" required>
            </div>
            <div class="form-floating  p-2">
                <label for="password new">รหัสผ่านใหม่</label>
                <input type="password" class="custom-floating col-12 p-2" id="password" name="pass_new" required>
            </div>
            <center>
                <img src="uimg/<?php echo $_SESSION['bweb']['profile'];?>" width="100px;" height="100px;" class="rounded-circle">
                <div class="form-file p-2">
                    <input type="file" class="custom-floating" id="form-filelang" lang="es" name="edit_img">
                    <label for="file"></label>
                </div>
                <?php
                    if(isset($result['error']))
                    {
                        echo '<div class="alert alert-danger">'.$result['error'].'</div>';
                    }
                ?>
            <button type="submit" class="btn btn-primary btn-lg btn-blook">บันทึก</button>
            <div class="p-2">
            <a href="home.php" class="btn btn-danger btn-lg btn-blook">ยกเลิก</a>
        </div>
       </form>
        </center>
    </div>
</body>
</html>