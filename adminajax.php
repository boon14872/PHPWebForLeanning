<?php
//adminajax.php
if(isset($_GET['type']))
{
    require 'include/init.php';
    $type = $_GET['type'];
    if($type == 'del')
    {
        if($user_obj->del($_GET['uid']))
        {
            echo "<script>window.history.back()</script>";
        }
        else
        {
            echo "<script>window.history.back()</script>";
        }
    }
    if($type == 'allow')
    {
        if($user_obj->allow($_GET['uid']))
        {
            echo "<script>window.history.back()</script>";
        }
        else
        {
            echo "<script>window.history.back()</script>";
        }
    }
}

?>