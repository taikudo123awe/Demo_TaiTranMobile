<?php
	session_start();
include("../class/clslogin.php");
include("../class/clsquantri.php");
$p= new login();
$t= new quantri();

if(isset($_SESSION['iduser'])&& isset($_SESSION['username'])&& isset($_SESSION['password'])&& isset($_SESSION['phanquyen']))
{
	$p->confirmadmin($_SESSION['iduser'],$_SESSION['username'],$_SESSION['password'],$_SESSION['phanquyen']);	
}
else
{
header("location:../login/login.php");	
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin dep zai</title>
</head>

<body>
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
<table width="875" border="1" align="center">
  <tr>
    <td colspan="2"><div align="center"><strong>QUẢN LÝ SẢN PHẨM</strong></div></td>
  </tr>
  <tr>
    <td width="318">Chọn công ty cung cấp</td>
    <td width="700"><?php $t->choncongty("select * from congty order by tencty asc") ?>  <label for="txtid"></label>	
      </td>
      
        
  </tr>
  <tr>
    <td>Nhập tên sản phẩm</td>
    <td><label for="textname"></label>
      <input type="text" name="textname" id="textname" /></td>
  </tr>
  <tr>
    <td>Nhập giá</td>
    <td><label for="txtgia"></label>
      <input type="text" name="txtgia" id="txtgia" /></td>
  </tr>
  <tr>
    <td>Nhập mô tả</td>
    <td><label for="txtmota"></label>
      <textarea name="txtmota" id="txtmota" cols="45" rows="5"></textarea></td>
  </tr>
  <tr>
    <td>Nhập giảm giá</td>
    <td><label for="txtgiamgia"></label>
      <input type="text" name="txtgiamgia" id="txtgiamgia" /></td>
  </tr>
  <tr>
    <td>Chọn hình đại diện</td>
    <td><label for="myfile"></label>
      <input type="file" name="myfile" id="myfile" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="nut" id="nut" value="Thêm sản phẩm" />
      <input type="reset" name="Reset" id="button" value="Reset" />
      <input type="submit" name="nut" id="nut" value="Xóa" />
      <input type="submit" name="nut" id="nut" value="Chỉnh sửa sản phẩm" />
		<button><a href="../index.php">Về trang chủ</a></button>
      </td>
  </tr>
</table>
<?php
	switch($_POST['nut'])
	{
		case "Thêm sản phẩm":
		{	
			$idcty = $_REQUEST['dscongty'];
			$ten = $_REQUEST['textname'];
			$gia = $_REQUEST['txtgia'];
			$txtmota = $_REQUEST['txtmota'];
			$txtgiamgia = $_REQUEST['txtgiamgia'];
			$name = $_FILES['myfile']['name'];
			$name = time()."_".$name;
			$tmp_name = $_FILES['myfile']['tmp_name'];
			if($ten !='' && $gia !='' &&  $idcty != "0")
			{	
				
				$sql = "INSERT INTO sanpham (tensp, gia, mota, hinh, giamgia, idcty)
                        VALUES ('$ten', '$gia', '$txtmota', '$name', '$txtgiamgia', '$idcty')";
				if($t->themxoasua($sql)==1)
				{
					echo 'Thêm sản phẩm thành công';	
				}
				else		
				{	
					echo 'Thêm sản phẩm thất bại';
					echo '<br>';
					echo $idcty;
					echo '<br>';
					echo $ten;
					echo '<br>';
					echo $gia;	
					echo '<br>';
					echo $txtmota;	
					echo '<br>';
					echo $txtgiamgia;
					echo '<br>';
					echo $name;
					echo '<br>';
					echo $tmp_name;
					echo '<br>';
					echo $sql;	
				}
				                  
				
					
	
				$t->uploadfile($name,$tmp_name,"../hinh");	
			}
			else
			{
				echo 'Vui long nhap day du thong tin';	
			
			}
			break;	
		}
		case 'Xóa':
		{
			$idxoa = $_REQUEST['id'];
			if($idxoa > 0)
			{
				if($t->themxoasua("delete from sanpham where idsp ='$idxoa' limit 1")==1)
				{
					echo 'Xoa thanh cong';
                    exit();
				}
				else
				{
					echo 'Xoa that bai';	
				}
			}
			else
			{
				echo 'Vui lòng chọn sản phẩm cần xóa';	
			}	
		}
		case "Chỉnh sửa sản phẩm":
		{
			$idsp = $_REQUEST['id'];
			header('location:chinhsuasanpham.php?id='.$idsp.'');
		}	
		
	}
	
?>
	<?php
		$t->loaddssampham("select * from sanpham order by idsp desc");
	?>
</form>
</body>
</html>