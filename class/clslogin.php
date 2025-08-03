<?php
include("clsdatabase.php");

class login extends connect
{
    public function mylogin($user, $pass)
    {
        $link = $this->connection();

        // Gợi ý: Nếu bạn dùng md5 hash thì mở dòng này ra:
        // $pass = md5($pass);

        $sql = "SELECT iduser, username, password, phanquyen FROM taikhoan 
                WHERE username = '$user' AND password = '$pass' LIMIT 1";

        $ketqua  = mysqli_query($link, $sql);
        if (!$ketqua) {
            die("Lỗi SQL: " . mysqli_error($link));
        }

        $i = mysqli_num_rows($ketqua);
        if ($i == 1) {
            session_start();
            while ($row = mysqli_fetch_array($ketqua)) {
                $_SESSION['iduser'] = $row['iduser'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['password'] = $row['password'];
                $_SESSION['phanquyen'] = $row['phanquyen'];
            }
            header('location:../admin/admin.php');
            exit(); // Quan trọng! Sau header() phải exit()
        } else {
            return 0;
        }
    }

    public function confirmadmin($iduser, $username, $password, $phanquyen)
    {
        $link = $this->connection();
        $sql = "SELECT iduser FROM taikhoan 
                WHERE username = '$username' AND password = '$password' AND phanquyen = '$phanquyen'";
        $ketqua = mysqli_query($link, $sql);
        if (!$ketqua) {
            die("Lỗi SQL: " . mysqli_error($link));
        }

        $i = mysqli_num_rows($ketqua);
        if ($i != 1) {
            header("location:../login/login.php");
            exit();
        }
    }
}
?>
