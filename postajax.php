<?php
//postajax.php
require 'include/init.php';
if(isset($_GET['type']))
{
    $type = $_GET['type'];
    $uid = $_SESSION['bweb']['uid'];
    $edit_post = false;
    $edit_comm = false;
    if($type == 'fetchAll')
    {
        $post = $post_obj->fetchAll();
    }
    elseif($type == 'fetchbypid')
    {
        $post = $post_obj->find_by_pid($_GET['pid']);
    }
    elseif($type == 'fetchbyuid')
    {
        $post = $post_obj->find_by_uid($_GET['uid']);
    }
    elseif($type == 'delpost')
    {
       if($post_obj->del($_GET['pid']))
       {
        header('location:home.php');
       }
    }
    elseif($type == 'editpost')
    {
        $edit_post = true;
        $post = $post_obj->find_by_pid($_GET['pid']);
    }
    elseif($type == 'editcomment')
    {
        $edit_comm = true;
        $post = $post_obj->find_by_pid($_GET['pid']);
    }
    elseif($type == 'delcomment')
    {
       if($comm_obj->del($_GET['cid']))
       {
        header('location:home.php?pid='.$_GET['pid']);
       }
    }

    if(!empty($post))
    {
        foreach ($post as $postdata) {
            ?>
            <div class=" row border">
                        <img src="uimg/<?php echo $postdata->profile;?>" width="75px;" height="75px;" class="rounded-circle">
                        <div class="col">
                            <div class="h2"><?php echo $postdata->name;?></div> 
                            <?php echo $postdata->ptime;?>
                            <p class="h3 col">
                                <?php 
                                if($edit_post == true)
                                {
                                    ?>
                                    <form action="" method="POST">
                                    <div class="">
                                        <textarea id="" cols="100" rows="5" name="post_text_edit"><?php echo $postdata->text;?></textarea>
                                        <input type="hidden" name="pid" value="<?php echo $postdata->pid;?>">                       
                                    </div>
                                    <div class="p-2">
                                        <button type="submit" class="btn btn-warning btn-lg btn-blook">บันทึก</button>
                                    </div>
                                    </form>
                                    <?php
                                }
                                else
                                {
                                    echo $postdata->text;
                                }
                                ?></p>
                            
                        <center>
                            <?php
                            if(!empty($postdata->img))
                            {
                                echo '<div class="row"><img src="pimg/'.$postdata->img.'" width="300px;" height="250px;"></div>';
                            }
                            ?>
                            
                    </center>
                </div>
                <div class="text-right ">
                    <?php
                    if($_SESSION['bweb']['uid'] == $postdata->uid || $_SESSION['bweb']['stats'] == 2)
                    {
                        if($edit_post != true )
                        {
                            ?>
                            <a href="postajax.php?type=delpost&pid=<?php echo $postdata->pid;?>" class="btn btn-danger btn-lg btn-blook" onclick="return confirm('คุณต้องการลบโพสนี้หรือไม่')">ลบ</a>
                            <button type="button" class="btn btn-warning btn-lg btn-blook" onclick="editpost(<?php echo $postdata->pid;?>)">แก้ไข</button>
                            <?php
                        }
                    }
                    ?>
                </div>
                    </div>
                     <!-- ส่วนโพส -->
                      <!-- ส่วนคอมเม้น -->
                    <form action="" method="post">
                    <div class="row border-left border-3 border-danger">
                        <div class="col">
                            <div class="form-floating p-2">
                                <label for="form-floating"></label>
                                <input type="text" class="custom-floating col-10" name="comm_text" id="">     
                                <input type="hidden" name="pid" value="<?php echo $postdata->pid;?>">                       
                                    <button type="submit" class="btn btn-warning btn-mx btn-blook">บันทึก</button> 
                            </div>                                                    
                        </div>
                    </div>
                    </form>

                   <?php
                   $commentall = $comm_obj->fetchbypost($postdata->pid);
                   foreach ($commentall as $commdata) {
                       ?>

                        <div class="border-left border-warning border-3 row p-1">                    
                            <img src="uimg/<?php echo $commdata->profile;?>" width="40px;" height="40px;" class="rounded-circle">
                            <div class="col">
                                <div class="h2"><?php echo $commdata->name;?>
                               
                                
                            </div>      
                            </div>
                            <div class="text-right">
                                <?php
                                if($_SESSION['bweb']['uid'] == $commdata->uid || $_SESSION['bweb']['stats'] == 2){
                                    if($edit_comm != true)
                                    {
                                        echo '<a href="postajax.php?type=delcomment&pid='.$commdata->pid.'&cid='.$commdata->cid.'" class="btn btn-danger" onclick="return confirm('."'คุณต้องการลบคอมเม้นนี้หรือไม่'".')">ลบ</a><button type="button" class="btn btn-warning" onclick="editcomm('.$commdata->pid.','.$commdata->cid.')">แก้ไข</button>';
                                    }
                                }
                                ?>
                            </div>
                    </div>
                    <div class="col border-left border-warning border-3 row p-1">
                        <p class="h3 ">
                            <?php 
                            if($edit_comm == true)
                            {
                                ?>
                                <form action="" method="post">
                                <div class="row border-left border-3 border-danger">
                                    <div class="col">
                                        <div class="form-floating p-2">
                                            <label for="form-floating"></label>
                                            <input type="คอมเม้น" class="custom-floating col-10" name="comm_text_edit" id="คอมเม้น" value="<?php echo $commdata->text;?>">     
                                            <input type="hidden" name="pid" value="<?php echo $commdata->pid;?>">   
                                            <input type="hidden" name="cid" value="<?php echo $commdata->cid;?>">                     
                                                <button type="submit" class="btn btn-primary btn-mx btn-blook">คอมเม้น</button> 
                                        </div>                                                    
                                    </div>
                                </div>
                                </form>
                                <?php
                            }
                            else
                            {
                                echo $commdata->text;
                            }
                            
                            ?>
                        </p>
                    </div>
                    
                       <?php
                   }
                   ?>
            <?php
        }
    }
}

?>