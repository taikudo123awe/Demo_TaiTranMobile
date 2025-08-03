<?php
include_once("clsdatabase.php");
class user extends connect
{
	public function dangnhap($email, $pass)
{
    $link = $this->connection();

    $stmt = mysqli_prepare($link, "SELECT idkh, email, password FROM khachhang WHERE email = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $idkh, $email_db, $password_db);

    if (mysqli_stmt_fetch($stmt)) {
        if ($pass === $password_db) { // Hoặc password_verify($pass, $password_db) nếu dùng hash
            session_start();
            $_SESSION['idkh'] = $idkh;
            $_SESSION['email'] = $email_db;
            header('Location: index.php');
            exit();
        } else {
            return 0; // Sai mật khẩu
        }
    } else {
        return 0; // Không tồn tại email
    }
    mysqli_stmt_close($stmt);
}
	
	
	 public function dieukhiennut ($idkh)
        {
            if(!empty($idkh))
            {
                echo'
                    <a id="dangxuat" name="dangxuat" href="dangxuat.php">Đăng xuất</a>
                    <a id="giohang" name="giohang" href="giohang.php">Xem giỏ hàng</a>
                ';
            }
            else
            {
                echo'
                    <a id="dangky" name="dangky" href="dangky.php">Đăng ký</a>
                    <a id="dangnhap" name="dangnhap" href="loginUser.php">Đăng nhập Thành viên</a>
                ';
            }
        }

		function themxoasua($sql) 
        {
            $link = $this->connection(); // Giả sử trả về mysqli connection
            $ketqua = mysqli_query($link, $sql);
            if ($ketqua) {
                return 1;
            } else {
                echo "Lỗi: " . mysqli_error($link);
                return 0;
            }
        }
		
	
}

?>