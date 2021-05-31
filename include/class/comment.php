<?php
//comment.php
class comment
{
    protected $db;
    public function __construct($dbconn)
    {
        $this->db = $dbconn;
    }
    public function upload($uid,$pid,$text)
    {
        $sql = "INSERT INTO comment(uid,text,pid) VALUES(?,?,?)";
        $upload = $this->db->prepare($sql);
        if($upload->execute([$uid,$text,$pid]))
        {
            header('location:home.php?pid='.$pid);
        }
        else
        {
            return false;
        }
    }
    public function update($cid,$text,$pid) 
    {
        $sql = "UPDATE comment set text = ? where cid = ?";
        $update = $this->db->prepare($sql);
        if($update->execute([$text,$cid]))
        {
            header('location:home.php?pid='.$pid);
        }
        else
        {
            return false;
        }
    }
    public function del($cid)
    {
        $sql = "DELETE from comment where cid = ?";
        $del = $this->db->prepare($sql);
        if($del->execute([$cid]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function find_by_cid($pid)
    {
        $sql = "SELECT * from comment join user on comment.uid = user.uid where cid = ? order by cid DESC";
        $find = $this->db->prepare($sql);
        $find->execute([$pid]);
        return $find->fetchAll(PDO::FETCH_OBJ);
    }
    public function find_by_uid($uid)
    {
        $sql = "SELECT * from comment join user on comment.uid = user.uid where uid = ? order by cid DESC";
        $find = $this->db->prepare($sql);
        $find->execute([$uid]);
        return $find->fetchAll(PDO::FETCH_OBJ);
    }
    public function fetchbypost($pid)
    {
        $sql = "SELECT * from comment join user on comment.uid = user.uid where pid = ? order by pid DESC";
        $find = $this->db->prepare($sql);
        $find->execute([$pid]);
        return $find->fetchAll(PDO::FETCH_OBJ);
    }
}
?>