<?php
//friendajax.php
require 'include/init.php';
if(isset($_GET['type']))
{
    $type = $_GET['type'];
    $uid = $_SESSION['bweb']['uid'];
    if($type == 'addfriend')
    {
        $friend_obj->request($_GET['send'],$_GET['receive']);
    }
    elseif($type == 'make')
    {
        $friend_obj->make($_GET['id1'],$_GET['id2']);
    }
    elseif($type == 'cancle')
    {
        $friend_obj->cancle($_GET['id1'],$_GET['id2']);
    }
    elseif($type == 'del')
    {
        $friend_obj->del($_GET['id1'],$_GET['id2']);
    }
    elseif($type == 'find' && isset($_GET['findtype']))
    {
        $findtype = $_GET['findtype'];
        if($findtype == 'sname')
        {
            $sname = $_GET['sname'];
            $find_user = $user_obj->find_by_name($sname,$uid);
            foreach ($find_user as $fdata) {
                ?>
                        <div class="row col border">
                            <img src="uimg/<?php echo $fdata->profile;?>" width="60px;" height="60px;" class="rounded-circle">
                            <div class="col">
                                <p class="h4"><?php echo $fdata->name;?></p>
                                <div class="text-right ">
                                    <?php
                                    if($friend_obj->isFriend($uid,$fdata->uid))
                                    {
                                        echo '<button type="button" class="btn btn-primary btn btn-blook" onclick="return confirm('."'คุณต้องการยกเลิกเป็นเพื่อกับ ".$fdata->name."หรือไม่'".') && delf('.$uid.','.$fdata->uid.')">เลิกเป็นเพื่อน</button>
                                        <a href="home.php?uid='.$fdata->uid.'" class="btn btn-primary btn btn-blook">ดูโพส</a>';
                                    }
                                    elseif($friend_obj->sender($uid,$fdata->uid))
                                    {
                                        echo '<button type="button" class="btn btn-primary btn btn-blook" onClick="canclef('.$uid.','.$fdata->uid.')">ยกเลิกคำขอ</button>
                                        <a href="home.php?uid='.$fdata->uid.'" class="btn btn-primary btn btn-blook">ดูโพส</a>';
                                    }
                                    elseif($friend_obj->receiver($uid,$fdata->uid))
                                    {
                                        echo '<button type="button" class="btn btn-primary btn btn-blook" onclick="makef('.$uid.','.$fdata->uid.')">ยืนยัน</button>
                                        <button type="button" class="btn btn-primary btn btn-blook"  onClick="canclef('.$uid.','.$fdata->uid.')">ยกเลิก</button>';
                                    }
                                    else
                                    {
                                        echo '<button type="button" class="btn btn-primary btn btn-blook" onclick="request('.$uid.','.$fdata->uid.')">ส่งคำขอ</button>
                                        <a href="home.php?uid='.$fdata->uid.'" class="btn btn-primary btn btn-blook">ดูโพส</a>';
                                    }
                                    ?>
                                </div>
                            </div>
                             
                        </div> 
                <?php
            }
        }

        if($findtype == 'sender')
        {
            $find_user = $user_obj->fetchAll($uid);
            foreach ($find_user as $fdata) {
                if($friend_obj->sender($uid,$fdata->uid))
                {
                    ?>
                        <div class="row col border">
                            <img src="uimg/<?php echo $fdata->profile;?>" width="60px;" height="60px;" class="rounded-circle">
                            <div class="col">
                                <p class="h4"><?php echo $fdata->name;?></p>
                                <div class="text-right ">
                                    <?php
                                        if($friend_obj->sender($uid,$fdata->uid))
                                    {
                                        echo '<button type="button" class="btn btn-primary btn btn-blook" onClick="canclef('.$uid.','.$fdata->uid.')">ยกเลิกคำขอ</button>
                                        <a href="home.php?uid='.$fdata->uid.'" class="btn btn-primary btn btn-blook">ดูโพส</a>';
                                    }
                                    ?>
                                </div>
                            </div>
                             
                        </div> 
                <?php
                }
            }
        }
        if($findtype == 'receive')
        {
            $find_user = $user_obj->fetchAll($uid);
            foreach ($find_user as $fdata) {
                if($friend_obj->receiver($uid,$fdata->uid))
                {
                    ?>
                        <div class="row col border">
                            <img src="uimg/<?php echo $fdata->profile;?>" width="60px;" height="60px;" class="rounded-circle">
                            <div class="col">
                                <p class="h4"><?php echo $fdata->name;?></p>
                                <div class="text-right ">
                                    <?php
                                    if($friend_obj->receiver($uid,$fdata->uid))
                                    {
                                        echo '<button type="button" class="btn btn-primary btn btn-blook" onclick="makef('.$uid.','.$fdata->uid.')">ยืนยัน</button>
                                        <button type="button" class="btn btn-primary btn btn-blook"  onClick="canclef('.$uid.','.$fdata->uid.')">ยกเลิก</button>';
                                    }

                                    ?>
                                </div>
                            </div>
                             
                        </div> 
                <?php
                }
            }
        }
        if($findtype == 'myfriend')
        {
            $find_user = $user_obj->fetchAll($uid);
            foreach ($find_user as $fdata) {
                if($friend_obj->isFriend($uid,$fdata->uid))
                {
                    ?>
                        <div class="row col border">
                            <img src="uimg/<?php echo $fdata->profile;?>" width="60px;" height="60px;" class="rounded-circle">
                            <div class="col">
                                <p class="h4"><?php echo $fdata->name;?></p>
                                <div class="text-right ">
                                    <?php
                                    if($friend_obj->isFriend($uid,$fdata->uid))
                                    {
                                        echo '<button type="button" class="btn btn-primary btn btn-blook" onclick="return confirm('."'คุณต้องการยกเลิกเป็นเพื่อกับ ".$fdata->name."หรือไม่'".') &&delf('.$uid.','.$fdata->uid.')">เลิกเป็นเพื่อน</button>
                                        <a href="home.php?uid='.$fdata->uid.'" class="btn btn-primary btn btn-blook">ดูโพส</a>';
                                    }
                                    ?>
                                </div>
                            </div>
                             
                        </div> 
                <?php
                }
            }
        }

        if($findtype == 'notfriend')
        {
            $find_user = $user_obj->fetchAll($uid);
            foreach ($find_user as $fdata) {
                if(!$friend_obj->sender($uid,$fdata->uid) && !$friend_obj->isFriend($uid,$fdata->uid) && !$friend_obj->receiver($uid,$fdata->uid))
                {
                    ?>
                        <div class="row col border">
                            <img src="uimg/<?php echo $fdata->profile;?>" width="60px;" height="60px;" class="rounded-circle">
                            <div class="col">
                                <p class="h4"><?php echo $fdata->name;?></p>
                                <div class="text-right ">
                                    <?php
                                        echo '<button type="button" class="btn btn-primary btn btn-blook" onclick="request('.$uid.','.$fdata->uid.')">ส่งคำขอ</button>
                                        <a href="home.php?uid='.$fdata->uid.'" class="btn btn-primary btn btn-blook">ดูโพส</a>';

                                    ?>
                                </div>
                            </div>
                             
                        </div> 
                <?php
                }
            }
        }
        
    }
}


?>
