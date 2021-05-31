<?php
//friend.php
class friend
{
    protected $db;
    public function __construct($dbconn)
    {
        $this->db = $dbconn;
    }
    public function request($send,$receive)
    {
        $sql = "INSERT INTO request(send,receive) values(?,?)";
        $req = $this->db->prepare($sql);
        if($req->execute([$send,$receive]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function make($id1,$id2)
    {
        $sqldel = "DELETE from request where (send = ? and receive = ?) or (receive = ? and send = ?)";
        $del = $this->db->prepare($sqldel);
        if($del->execute([$id1,$id2,$id1,$id2]))
        {
            $sql = "INSERT INTO friend(id1,id2) values(?,?)";
            $req = $this->db->prepare($sql);
            if($req->execute([$id1,$id2]))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        
    }
    public function del($id1,$id2)
    {
        $sql = "DELETE from friend where (id1 = ? and id2 =?) or (id2 = ? and id1 = ?)";
        $del = $this->db->prepare($sql);
        if($del->execute([$id1,$id2,$id1,$id2]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function cancle($id1,$id2)
    {
        $sql = "DELETE from request where( send = ? and receive = ?) or ( receive = ? and send = ?)";
        $cancle = $this->db->prepare($sql);
        if($cancle->execute([$id1,$id2,$id1,$id2]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function isFriend($id1,$id2)
    {
        $sql = "SELECT * from friend where (id1 = ? and id2 =?) or (id2 = ? and id1 = ?)";
        $isf = $this->db->prepare($sql);
        $isf->execute([$id1,$id2,$id1,$id2]);
        if($isf->rowCount() == 1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function sender($send,$receive)
    {
        $sql = "SELECT * from request where send = ? and receive = ?";
        $sendf = $this->db->prepare($sql);
        $sendf->execute([$send,$receive]);
        if($sendf->rowCount() == 1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function receiver($receive,$send)
    {
        $sql = "SELECT * from request where receive = ? and send = ?";
        $rec = $this->db->prepare($sql);
        $rec->execute([$receive,$send]);
        if($rec->rowCount() == 1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
?>