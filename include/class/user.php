<?php
//user.php
class user
{
    protected $db;
    public function __construct($dbconn)
    {
        $this->db = $dbconn;
    }
    public function register($email,$pass,$name)
    {
        $t_email = trim($email);
        $t_pass = trim($pass);
        $t_name = trim($name);
        $check_sql = "SELECT uid from user where email = ?";
        $check = $this->db->prepare($check_sql);
        $check->execute([$t_email]);
        if($check->rowCount() == 0)
        {
            $newpass = password_hash($t_pass,PASSWORD_DEFAULT);
            $sql = "INSERT INTO user(email,pass,name) VALUES(?,?,?)";
            $regis = $this->db->prepare($sql);
            if($regis->execute([$t_email,$newpass,$t_name]))
            {
                header('location:logout.php');
            }
            else
            {
                return ['error'=>'สมัครล้มเหลว'];
            }
            
        }
        else
        {
            return ['error'=>'email นี้มีการใช้งานแล้ว'];
        }
    }
    public function login($email,$pass)
    {
        $t_email = trim($email);
        $t_pass = trim($pass);
        $check_sql = "SELECT * from user where email = ?";
        $check = $this->db->prepare($check_sql);
        $check->execute([$t_email]);
        if($check->rowCount() == 1)
        {
            $user = $check->fetch();
            if(password_verify($t_pass,$user['pass']))
            {
                $_SESSION['bweb'] = [
                    'uid' => $user['uid'],
                    'email' =>$user['email'],
                    'name' =>$user['name'],
                    'profile'=>$user['profile'],
                    'stats'=>$user['stats']
                ];
                header('location:home.php');
            }
            else
            {
                return ['error'=>'รหัสผ่านไม่ถูกต้อง'];
            }
        }
        else
        {
            return ['error'=>'ไม่อีเมลนี้ในระบบ'];
        }
    }
    public function find_by_id($uid)
    {
        $sql = "SELECT * from user where uid = ?";
        $find = $this->db->prepare($sql);
        $find->execute([$uid]);
        return $find->fetchAll(PDO::FETCH_OBJ);
    }
    public function fetchAll($uid)
    {
        $sql = "SELECT * from user where uid <> ? and stats <> 0";
        $find = $this->db->prepare($sql);
        $find->execute([$uid]);
        return $find->fetchAll(PDO::FETCH_OBJ);
    }
    public function find_by_name($sname,$uid)
    {
        $sql = "SELECT * from user where name like ? and uid <> ?  and stats <> 0";
        $find = $this->db->prepare($sql);
        $find->execute(['%'.$sname.'%',$uid]);
        return $find->fetchAll(PDO::FETCH_OBJ);
    }
    public function update($uid,$name,$oldpass,$newpass,$img)
    {
        $t_old = trim($oldpass);
        $t_new = trim($newpass);
        $check_sql = "SELECT * from user where uid = ?";
        $check = $this->db->prepare($check_sql);
        $check->execute([$uid]);
        $user = $check->fetch();
        if(password_verify($t_old,$user['pass']))
        {
            $newpass = password_hash($t_new,PASSWORD_DEFAULT);
            if(!empty($name))
            {
                $sql = "UPDATE user set name = ?,pass = ?,profile = ? where uid =?";
                $update = $this->db->prepare($sql);
                if($update->execute([$name,$newpass,$img,$uid]))
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
        }
        else
        {
            return ['error'=>'รหัสผ่านไม่ถูกต้อง'];
        }
    }

    public function allow($uid)
    {
        $sql = "UPDATE user set stats = 1 where uid = ?";
        $allow = $this->db->prepare($sql);
        if($allow->execute([$uid]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function del($uid)
    {
        $sql = "DELETE from user where uid = ?";
        $del = $this->db->prepare($sql);
        if($del->execute([$uid]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function getname($uid)
    {
        $sql = "SELECT name from user where uid = ?";
        $find = $this->db->prepare($sql);
        $find->execute([$uid]);
        $user = $find->fetch();
        return $user['name'];
    }
    public function activeuser()
    {
        $sql = "SELECT * from user where stats = 1";
        $find = $this->db->prepare($sql);
        $find->execute();
        $user = $find->fetchAll(PDO::FETCH_OBJ);
        return $user;
    }
    public function waituser()
    {
        $sql = "SELECT * from user where stats = 0";
        $find = $this->db->prepare($sql);
        $find->execute();
        $user = $find->fetchAll(PDO::FETCH_OBJ);
        return $user;
    }
}



?>