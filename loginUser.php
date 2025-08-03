<?php
include("class/clsuser.php");
$t = new user();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Trang đăng nhập</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <table width="600" border="1" align="center">
    <tr>
      <td colspan="2"><div align="center"><strong>ĐĂNG NHẬP ĐI NÍ</strong></div></td>
    </tr>
    <tr>
      <td width="184">TÀI KHOẢN</td>
      <td width="400"><label for="txttaikhoan"></label>
        <div align="left">
          <input name="txttaikhoan" type="text" id="txttaikhoan" size="35" />
      </div></td>
    </tr>
    <tr>
      <td>MẬT KHẨU</td>
      <td>
        <label for="txtmatkhau"></label>
        <div align="left">
          <input name="txtmatkhau" type="password" id="txtmatkhau" size="35" />
      </div></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">
        <input type="submit" name="nut" id="nut" value="Đăng nhập" />
      </div></td>
    </tr>
  </table>
  <?php
  	switch($_POST['nut'])
	{
		case 'Đăng nhập':
		{
			$user = $_REQUEST['txttaikhoan'];
			$pass = $_REQUEST['txtmatkhau'];
			if($user != '' && $pass !='')
			{
				if($t->dangnhap($user, $pass) == 0)
				{
					echo 'Đăng nhập không thành công';
						
				}	
			}
			else
			{
				echo 'Vui lòng nhập đầy đủ thông tin';	
			}
			
			
			break;	
		}	
		
	}
		
  ?>
  
</form>
</body>
</html>