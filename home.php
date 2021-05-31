<?php
    require 'include/init.php';
    if(!isset($_SESSION['bweb']['uid']))
    {
        header('location:logout.php');
    }
    if($_SESSION['bweb']['stats'] == 0)
    {
        echo "<script>alert('กรุณารอการยืนยันจากแอดมินระบบ');window.location='logout.php';</script>";
    }
    $uid = $_SESSION['bweb']['uid'];
    


    if(isset($_POST['post_text']) || isset($_FILES['post_img']['name']))
    {
        if(!empty($_FILES['post_img']['name']))
        {
            $dir = "/pimg/";
            $file = $_FILES['post_img']['name'];
            $extname = strtolower(pathinfo($file,PATHINFO_EXTENSION));
            $newimg_name = $uid."_".time()."_".rand(10000,99999).".".$extname;
            $newdirimg = $dir.$newimg_name;
            if(move_uploaded_file($_FILES['post_img']['tmp_name'],$newdirimg))
            {
                $post_img = $newimg_name;
            }
            else
            {
                $post_img = null;
            }
        }
        else
        {
            $post_img = "";
        }
        if(empty($_POST['post_text']))
        {
            $ptext = "";
        }
        else
        {
            $ptext = $_POST['post_text'];
        }
        
        if(!empty($ptext) || !empty($post_img))
        {
            $result = $post_obj->upload($uid,$ptext,$post_img);
        }
    }
    if(isset($_POST['comm_text']) && isset($_POST['pid']))
    {
        if(!empty($_POST['comm_text']) && !empty($_POST['pid']))
        {
            $result = $comm_obj->upload($uid,$_POST['pid'],$_POST['comm_text']);
        }
    }
    if(isset($_POST['post_text_edit']) && isset($_POST['pid']))
    {
        if(!empty($_POST['post_text_edit']) && !empty($_POST['pid']))
        {
            $result = $post_obj->update($_POST['pid'],$_POST['post_text_edit']);
        }
    }
    if(isset($_POST['comm_text_edit']) && isset($_POST['pid']) && isset($_POST['cid']))
    {
        if(!empty($_POST['comm_text_edit']) && !empty($_POST['pid']) && !empty($_POST['cid']))
        {
            $result = $comm_obj->update($_POST['cid'],$_POST['comm_text_edit'],$_POST['pid']);
        }
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้าหลัก</title>
    <link rel="stylesheet" href="bootstrap-4.1.3-dist/css/bootstrap.min.css">
    <script src="bootstrap-4.1.3-dist/jquery-3.6.0.min.js"></script>
    <script src="home.js"></script>
    <style>
        .border-3{
            border-width: 3px!important;
        }
    </style>
</head>
<body>
<?php
if($_SESSION['bweb']['stats'] == 2)
{
    ?>
    <div class="container-fluid p-3 border bg-info">
        <div class="row">
            <div class="col">
                <div class="text-left">
                    <p class="h1">
                        ADMIN
                    </p>
                </div>
                
            </div>
            <div class="text-right mr-3">
                <a href="admin.php?type=conf" class="btn btn-warning btn-mx btn-blook p-2">ยืนยันคำขอ</a>
                <a href="admin.php?type=manager" class="btn btn-primary btn-mx btn-blook p-2">จัดการผู้ใช้งาน</a>
            </div>
        </div>
        
    </div>
    <?php
}
?>
    <div class="container-fluid">
        <div class="row">
            <!-- 1 -->
            <div class="col-lg-3 border">
                <div class="row">
                    <div class="col col-12 p-2">
                       <div class="col-12 p-2"> <a href="home.php" class="btn btn-info btn-lg btn-blook col-12 p-2">หน้าหลัก</a></div>
                      <div class=" col-12 p-2">  <button type="button" class="btn btn-success btn-lg btn-blook col-12 p-2" onclick="findmyfriend()">เพื่อน</button></div>
                       <div class="col-12 p-2"> <button type="button" class="btn btn-primary btn-lg btn-blook col-12 p-2" onclick="findbyreceiver()">คำขอเป็นเพื่อน</button></div>
                       <div class=" col-12 p-2"> <button type="button" class="btn btn-dark btn-lg btn-blook col-12 p-2" onclick="findbysender()">เพื่อนที่ยังไม่ได้ตอบรับคำขอ</button></div>
                       <div class=" col-12 p-2 "> <button type="button" class="btn btn-warning btn-lg btn-blook col-12 p-2" onclick="findnotfriend()">เพื่อนที่ยังไม่ได้เพิ่มเพื่อน</button></div>
                            <center>
                                <img src="uimg/<?php echo $_SESSION['bweb']['profile'];?>" width="100px;" height="100px;" class="rounded-circle" >
                                <div class="h1"><?php echo $_SESSION['bweb']['name'];?></div>
                            </center>
                            <center>
                                <div class="p-2">
                                    <a class="btn btn-danger btn-lg btn-blook p-2" href="logout.php" onclick="return confirm('คุณต้องการออกจากระบบใช่หรือไม่')">ออกจากระบบ</a>
                                </div>
                                
                            </center>
                           
                            <center>
                            <a class="btn btn-warning btn-lg btn-blook p-2" href="edit.php">แก้ไขข้อมูลส่วนตัว</a>
                        </center>
                    </div>
                </div>
            </div>
            <!-- 1 -->
            <!-- 2 -->
            <div class="col-lg-6 border">
                <div class="row">
                    <div class="col">
                        <!-- 1.1 -->
                        <p class="h1  row border ">
                            <?php
                            if(isset($_GET['pid']))
                            {
                                echo 'โพสของ : '.$post_obj->getname($_GET['pid']);
                            }
                            elseif(isset($_GET['uid']))
                            {
                                echo 'โพสของ : '.$user_obj->getname($_GET['uid']);
                            }
                            else
                            {
                                echo 'หน้าหลัก';
                            }
                            ?>
                        </p>
                        <!-- 1.1 -->
                        <!-- ส่วนโพส -->
                        <div id="boxheader">

                        <form action="" method="POST" enctype="multipart/form-data">
                        <img src="uimg/<?php echo $_SESSION['bweb']['profile'];?>" width="100px;" height="100px;" class="rounded-circle">
                        <div class="">
                            <textarea class="form-control" id="" cols="100" rows="5" name="post_text"></textarea>
                        </div>
                        <div class="custom-file p-2">
                            <input type="file" class="custom-file-input" id="formfile" lang="es" name="post_img">
                            <label class="custom-file-label" for="formfile">select</label>
                            
                        </div>
                        <button type="submit" class="btn btn-primary btn-md btn-blook">โพส</button>
                        </form>

                        </div>
                        <div id="postdata">

                        </div>
                    
                    <!-- ส่วนคอมเม้น -->
                </div>
            </div>
        </div>
            <!-- 2 -->
            <!-- 3 -->           
            <div class="col-lg-3 border">
                <div class="row">
                    <div class="col">
                        <p class="h1 row border">เพื่อน</p>
                        <div class="form-floating p-2">
                            <label for="form-floating"></label>
                            <input type="ค้นหา" class="custom-floating col-8 " id="sname">                            
                                <button type="button" class="btn btn-primary btn-mx btn-blook" onclick="findbyname()">ค้นหา</button> 
                        </div>  
                        <div id="friendbox">

                        </div>
                                                                                             
                    </div>
                </div>
            </div>
            <!-- 3 -->
        <!-- row -->
        </div>
    </div>
    <script>
        <?php
        if(isset($_GET['uid']))
        {
            echo 'fetchByUID('.$_GET['uid'].')';
        }
        elseif(isset($_GET['pid']))
        {
            echo 'fetchByPID('.$_GET['pid'].')';
        }
        else
        {
            echo 'fetchAllpost()';
        }
        ?>
    </script>
</body>
</html>