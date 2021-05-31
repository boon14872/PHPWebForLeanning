<?php
//post.php
class post
{
    protected $db;
    public function __construct($dbconn)
    {
        $this->db = $dbconn;
    }
    public function upload($uid,$text,$img)
    {
        $sql = "INSERT INTO post(uid,text,img) VALUES(?,?,?)";
        $upload = $this->db->prepare($sql);
        if($upload->execute([$uid,$text,$img]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function update($pid,$text) 
    {
        $sql = "UPDATE post set text = ? where pid = ?";
        $update = $this->db->prepare($sql);
        if($update->execute([$text,$pid]))
        {
            header('location:home.php?pid='.$pid);
        }
        else
        {
            return false;
        }
    }
    public function del($pid)
    {
        $sql = "DELETE from post where pid = ?";
        $del = $this->db->prepare($sql);
        if($del->execute([$pid]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function find_by_pid($pid)
    {
        $sql = "SELECT * from post join user on post.uid = user.uid where pid = ? order by pid DESC";
        $find = $this->db->prepare($sql);
        $find->execute([$pid]);
        return $find->fetchAll(PDO::FETCH_OBJ);
    }
    public function find_by_uid($uid)
    {
        $sql = "SELECT * from post join user on post.uid = user.uid where post.uid = ? order by pid DESC";
        $find = $this->db->prepare($sql);
        $find->execute([$uid]);
        return $find->fetchAll(PDO::FETCH_OBJ);
    }
    public function fetchAll()
    {
        $sql = "SELECT * from post join user on post.uid = user.uid order by pid DESC";
        $find = $this->db->prepare($sql);
        $find->execute();
        return $find->fetchAll(PDO::FETCH_OBJ);
    }
    public function getname($pid)
    {
        $sql = "SELECT * from post join user on post.uid = user.uid where pid = ? order by pid DESC";
        $find = $this->db->prepare($sql);
        $find->execute([$pid]);
        $data = $find->fetch();
        return $data['name'];
    }
}
?>