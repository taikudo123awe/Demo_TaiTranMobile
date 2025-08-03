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
<title>Admin Chinh sửa sản phẩm</title>
</head>

<body>
	<h1 align="center">Chào admin! mời chỉnh sửa thông tin sản phẩm</h1>
	<?php
		$idsp = $_REQUEST['id'];
		$sql = "SELECT tensp, gia, mota, giamgia, hinh, idcty FROM sanpham WHERE idsp = '$idsp' LIMIT 1";
		$sp = $t->lay1dong($sql);
		$ten = $sp['tensp'];
        $gia = $sp['gia'];
        $mota = $sp['mota'];
        $giamgia = $sp['giamgia'];
		$hinh = $sp['hinh'];
        $idcty = $sp['idcty'];
		
		echo '<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
                    <table width="1100" border="2" align="center">
                        <tr>
                            <th colspan="2" align="center" bgcolor="#CCCCCC" valign="middle">QUẢN LÝ SẢN PHẨM</th>
                        </tr>
                        <tr>
                            <td width="190">Công ty cung cấp</td>
                            <td width="492">
                                <select name="select" id="select">
                                    <option value="0">--Chọn công ty--</option>
                                    <option value="1" '.($idcty == 1 ? "selected" : "").'>Apple</option>
                                    <option value="2" '.($idcty == 2 ? "selected" : "").'>SamSung</option>
                                    <option value="3" '.($idcty == 3 ? "selected" : "").'>Xiaomi</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Nhập tên sản phẩm</td>
                            <td><input type="text" name="tensanpham" value="'.$ten.'"></td>
                        </tr>
                        <tr>
                            <td>Nhập giá</td>
                            <td><input type="text" name="giasanpham" value="'.$gia.'"></td>
                        </tr>
                        <tr>
                            <td>Giảm giá</td>
                            <td><input type="text" name="giamgia" value="'.$giamgia.'"></td>
                        </tr>
						 <tr>
                            <td>Hình</td>
                            <td><img src="../hinh/'.$hinh.'" style ="width: 200px; height: 200px;">
								<label for="myfile"></label>
      							<input type="file" name="myfile" id="myfile" />
							</td>
                        </tr>
                        <tr>
                            <td>Mô tả</td>
                            <td><textarea name="motasanpham" cols="30" rows="3">'.htmlspecialchars($mota).'</textarea></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>
                                <input type="submit" name="nut" value="Cập nhật">
                                <input type="submit" name="nut" value="Xóa sản phẩm">
                            </td>
                        </tr>
                    </table>
                </form>';
				
		if($_POST['nut'] == "Cập nhật")
		{ //Tao bien hung gia trih cap nhat moi vo
			$ten = $_POST['tensanpham'];
            $gia = $_POST['giasanpham'];
            $giamgia = $_POST['giamgia'];
            $mota = $_POST['motasanpham'];
            $congty = $_POST['select'];
			$name = $_FILES['myfile']['name'];
			$name = time()."_".$name;
			$tmp_name = $_FILES['myfile']['tmp_name'];
			$sqlcapnhat = "UPDATE sanpham
                            SET tensp = '$ten', gia = '$gia', giamgia = '$giamgia', mota = '$mota', idcty = '$congty', hinh = '$name'
                            WHERE idsp = '$idsp' LIMIT 1";
			$t->uploadfile($name,$tmp_name,"../hinh");
			if($t->themxoasua($sqlcapnhat)==1)
			{
				echo 'sửa sản phẩm thành công';	
			}
			else
			{
				echo 'sửa sản phẩm thất bại';		
			}	
		}
	?>
</body>
</html>