<?php
include("class/clsdatabase.php");
$p = new connect();
$p->connection();
include("class/clsquantri.php");
$t = new quantri();


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tài Trần Mobile</title>
<link rel="stylesheet" href="css/style.css">
</head>
<div id = "container">
    <div id = "banner"> <h1>Tài Trần Mobile</h1>
    <div id = "menu">
     <?php
		include_once("class/clsuser.php");
		$u= new user();
		session_start();
		$idkh = $_SESSION['idkh'];
		$u->dieukhiennut($idkh);
	?>
    
    <a href="index.php">Trang chủ</a>
    </div>
    
</div>
    <div id = "main">
        <div id ="left">
        <?php
        $p->xemdscongty("select * from congty");
        ?>
        </div>
        <div id ="right">
        <?php
        $idsp = $_REQUEST['idsp'];
		$t->chitietsanpham($idsp);
		if($_POST['nut'] == "Đặt hàng")
		{
			session_start();
			$idsp = $_GET['idsp'];
			$soluong = $_POST['soluong'];
            $ngaydathang = date('Y-m-d H:i:s');
			if(!isset($_SESSION['idkh']))
            {
              echo'Vui lòng đăng nhập trước khi đặt hàng';
            }
			else
			{
				$sql = "INSERT INTO dathang (idkh, ngaydathang, trangthai) VALUES ('$idkh', '$ngaydathang', '0' )";
                                                        
				if($t->themxoasua($sql) == 1)
				{   $sql1 = "SELECT iddh FROM dathang WHERE idkh = '$idkh' ORDER BY iddh DESC LIMIT 1";
					$row = $t->lay1dong($sql1);	
					$iddh = $row['iddh'];
					
					$sql2 = "SELECT gia FROM sanpham WHERE idsp = '$idsp' LIMIT 1";
					$rowgia = $t->lay1dong($sql2);	
					$gia = $rowgia['gia'];
					
					$sql3 = "INSERT INTO dathang_chitiet (iddh, idsp, soluong, dongia, giamgia) VALUES ('$iddh', '$idsp', '$soluong', '$gia', '0')";
					if($t->themxoasua($sql3)==1)
					{
						echo'Đặt hàng thành công';	
					}
					else
					{
						echo'Lỗi chi tiết đơn hàng';	
					}					
				}
				else
				{
					echo'Lỗi đặt hàng';	
				}	
			}            
		}
		
        ?>
              
        </div>
    </div>
    <div id ="footer">
           <h1 style = 'color: white; aglin'>Trần Tấn Tài - 22727771</h1>
        
    </div>
    
</div>
<body>
</body>
</html>