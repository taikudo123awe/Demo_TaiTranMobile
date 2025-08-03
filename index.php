
<?php
include("class/clsdatabase.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);
$p = new connect();
$p->connection();

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
		include("class/clsuser.php");   
		$u= new user();
        session_start();
        $idkh = isset($_SESSION['idkh']) ? $_SESSION['idkh'] : null;
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
		    $id = isset($_REQUEST['idsp']) ? $_REQUEST['idsp'] : 0;
		   if($id >0)
		   {
			   $p->xemdsanpham("select * from sanpham where idcty = $id order by gia asc");
		   }
		   else
		   {
			   $p->xemdsanpham("select * from sanpham order by gia asc");
		   
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