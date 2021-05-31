<?php
//admin.php
require 'include/init.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin</title>
    <link rel="stylesheet" href="bootstrap-4.1.3-dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container-fluid p-3 border bg-info">
        <div class="row">
            <div class="col">
                <div class="text-left">
                    <p class="h1">
                        <?php
                        if(isset($_GET['type']))
                        {
                            $type = $_GET['type'];
                            if($type == 'manager')
                            {
                                echo "จัดการผูใช้งานระบบ";
                            }
                            elseif($type == 'conf')
                            {
                                echo "ยืนยันคำขอใช้งานระบบ";
                            }
                        }
                        ?>
                    </p>
                </div>
                
            </div>
            <div class="text-right mr-3">
                <a href="admin.php?type=conf" class="btn btn-warning btn-mx btn-blook p-2">ยืนยันคำขอ</a>
                <a href="admin.php?type=manager" class="btn btn-success btn-mx btn-blook p-2">จัดการผู้ใช้งาน</a>
                <a href="home.php" class="btn btn-primary btn-mx btn-blook p-2">หน้าหลัก</a>
            </div>
        </div>
        
    </div>
    
    <div class="container table-responsive">
        <table class="table" >
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ชื่อ</th>
                    <th>อีเมล</th>
                    <th>เวลา</th>
                    <th>รูป</th>
                    <th></th>
                </tr>
                <?php
                if(isset($_GET['type']))
                {
                    $type = $_GET['type'];
                    if($type == 'manager')
                    {
                        $userdata = $user_obj->activeuser();
                    }
                    elseif($type == 'conf')
                    {
                        $userdata = $user_obj->waituser();
                    }
                if(!empty($userdata))
                {
                    foreach ($userdata as $key) {
                        ?>
                    <tr>
                        <th><?php echo $key->uid;?></th>
                        <th><?php echo $key->name;?></th>
                        <th><?php echo $key->email;?></th>
                        <th><?php echo $key->registime;?></th>
                        <th><img src="uimg/<?php echo $key->profile;?>" width="40px;" height="40px;" class="rounded-circle"></th>
                        <th>
                            <?php
                            if($type == 'manager')
                            {
                                ?>
                                <a href="adminajax.php?type=del&uid=<?php echo $key->uid;?>" onclick="return confirm('คุณต้องการลบบัญชีของ <?php echo $key->name;?> หรือไม่')" class="btn btn-danger btn-mx btn-blook">ลบบัญชี</a>
                                <a href="home.php?uid=<?php echo $key->uid;?>" class="btn btn-primary btn-mx btn-blook">ดูโพส</a>
                                <?php
                            }
                            elseif($type == 'conf')
                            {
                                ?>
                                <a href="adminajax.php?type=allow&uid=<?php echo $key->uid;?>" class="btn btn-success btn-mx btn-blook">ยืนยัน</a>
                                <a href="adminajax.php?type=del&uid=<?php echo $key->uid;?>" class="btn btn-warning btn-mx btn-blook"  onclick="return confirm('ปฏิเสธการใช้งานของผู้ใช้ <?php echo $key->name;?> หรือไม่')">ยกเลิก</a>
                                <?php
                            }
                            ?>
                        </th>
                        </tr>
                        <?php
                    }
                }
            }
                ?>
            </thead>      
        </table >     
    </div>
</body>
</html>