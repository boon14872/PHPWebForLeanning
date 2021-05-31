<?php
//dbconnect.php
    class dbconnect
    {
        public function connect()
        {
            $state = "mysql:host=localhost;dbname=maehongsondb;charset=UTF8;";
            $db = new PDO($state,'root','');
            $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            return $db;
        }
    }
?>