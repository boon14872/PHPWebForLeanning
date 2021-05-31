<?php
//init.php
    require 'class/dbconnect.php';
    require 'class/user.php';
    require 'class/post.php';
    require 'class/comment.php';
    require 'class/friend.php';

    session_start();
    $db_obj = new dbconnect();
    $dbconn = $db_obj->connect();
    $user_obj = new user($dbconn);
    $post_obj = new post($dbconn);
    $comm_obj = new comment($dbconn);
    $friend_obj = new friend($dbconn);

    //print_r($user_obj);
?>