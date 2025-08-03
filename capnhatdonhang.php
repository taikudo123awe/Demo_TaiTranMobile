
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
<title>Cập nhật đơn hàng</title>
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
		 	$iddh = $_REQUEST['iddh'];
			//lay du lieu tu bang donhang_chitiet
			$sql = "SELECT idsp, soluong FROM dathang_chitiet WHERE iddh = ".$iddh." LIMIT 1";
			$ctdh = $t->lay1dong($sql);
			$idsp = $ctdh['idsp'];
			$soluong = $ctdh['soluong'];

			
			//Lay thong tin san pham
			$sql1 = "SELECT tensp, gia FROM sanpham WHERE idsp = ".$idsp." LIMIT 1";
			$sp = $t->lay1dong($sql1);
			$tensp = $sp['tensp'];
			$gia = $sp['gia'];

			
			//Lay dia chi khach hang
			$sql2 = "SELECT diachinhanhang FROM khachhang kh JOIN dathang dh ON dh.idkh = kh.idkh WHERE dh.iddh = '$iddh'";
			$khachhang = $t->lay1dong($sql2);
			$diachi = $khachhang['diachinhanhang'];
			
			echo'
			<form id="form1" name="form1" method="post" action="">
			  <table width="778" border="1" align="center">
				<tr>
				  <td colspan="4"><div align="center"><strong>THAY ĐỔI THÔNG TIN ĐƠN HÀNG</strong></div></td>
				</tr>
				<tr>
				  <td width="184">Tên sản phẩm</td>
				  <td width="131">Giá</td>
				  <td width="123">Số lượng</td>
				  <td width="204">Địa chỉ nhận hàng</td>
				</tr>
				<tr>
				  <td>'.$tensp.'</td>
				  <td>'.$gia.'</td>
				  <td><label for="textfield"></label>
				  <input type="text" name="txtsoluong" id="textfield" value = "'.$soluong.'"/></td>
				  <td><label for="textfield2"></label>
				  <input type="text" name="txtdiachi" id="textfield2"  value = "'.$diachi.'"/></td>
				</tr>
				<tr>
				  <td colspan="4"><div align="center">
					<input type="submit" name="nut" id="nut" value="Cập nhật" />
					<input type="submit" name="nut" id="nut2" value="xóa" />
				  </div></td>
				</tr>
			  </table>
			</form>

			
			
			';
           if($_POST['nut'] == "Cập nhật")
		   {
			$soluongmoi = $_REQUEST['txtsoluong'];
			$diachimoi =  $_REQUEST['txtdiachi']; 
			
			$query1 = $t->themxoasua("UPDATE dathang_chitiet SET soluong = '$soluongmoi' WHERE iddh = '$iddh' LIMIT 1");
			$query2 = $t->themxoasua("UPDATE khachhang SET diachinhanhang = '$diachimoi' WHERE idkh = '$idkh' LIMIT 1");
			if ($query1 && $query2) {
            	echo 'Cập nhật thành công';
            } else {
                echo 'Cập nhật không thành công';
                }
		   }
		   if($_POST['nut'] == "xóa")
		   {
			$query1 = $t->themxoasua("DELETE FROM dathang_chitiet WHERE iddh = '$iddh' LIMIT 1");
			$query2 = $t->themxoasua("DELETE FROM dathang WHERE iddh = '$iddh' LIMIT 1");
			if ($query1 && $query2)
			{
             echo 'Xóa đơn hàng thành công';
             } 
			 else 
			 {
               echo 'Xóa đơn hàng không thành công';
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