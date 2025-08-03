
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
<title>Giỏ hàng</title>
<link rel="stylesheet" href="css/style.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
		 	$giohang = $t->giohang($idkh);
		 	if (!empty($giohang)) {
			echo "<ul>";
			$tongTien = 0;
			echo "<h2>Danh sách sản phẩm trong giỏ hàng:</h2>";
			echo '<table width="1188" height="101" border="1">
				  <tr>
					<td colspan="9"><div align="center">GIỎ HÀNG CỦA BẠN</div></td>
				  </tr>
				  <tr>
					<td width="63"><div align="center"><strong>STT</strong></div></td>
					<td width="115"><div align="center"><strong>MÃ ĐƠN</strong></div></td>
					<td width="120"><div align="center"><strong>Ngày đặt</strong></div></td>
					<td width="256"><div align="center"><strong>Sản phẩm</strong></div></td>
					<td width="95"><div align="center"><strong>Số lượng</strong></div></td>
					<td width="123"><div align="center"><strong>Đơn giá</strong></div></td>
					<td width="141"><div align="center"><strong>Giảm giá</strong></div></td>
					<td width="125"><div align="center"><strong>Trạng thái</strong></div></td>
					<td width="92"><div align="center"><strong>Thay đổi</strong></div></td>
				  </tr>';
				  $dem =0;
				foreach ($giohang as $sp) {
				$soluong = $sp['soluong'];
				$iddh = $sp['iddh'];
				$dongia = $sp['dongia'];
				$giamgia = $sp['giamgia'];
				$ngaydat = $sp['ngaydathang'];
				$tensp = $sp['tensp'];
				$trangthai = $sp['trangthai'];
				$thanhtien = $soluong * ($dongia - $giamgia);
				$tongTien += $thanhtien;
				$dem++;
				$trangthaiText = '';
				if ($trangthai == 0) {
					$trangthaiText = 'Chờ duyệt';
				} elseif ($trangthai == 1) {
					$trangthaiText = 'Đã duyệt';
				}
				echo "<tr>
						<td>".$dem."</td>
						<td>".$iddh."</td>
						<td>".$ngaydat."</td>
						<td>".$tensp."</td>
						<td>".$soluong."</td>
						<td>".$dongia."</td>
						<td>".$giamgia."</td>
						<td>".$trangthaiText."</td>

						<td> <a href='capnhatdonhang.php?iddh=".$iddh."'>Thay đổi</a>  </td>
					  </tr>";
				
				
				
			}
			echo "</table>";
			
			echo "<h3 style='color:red;'>Tổng tiền phải trả: " . number_format($tongTien) . " VNĐ</h3>
				  <input type='submit' name='nut' id='nut' value='Xác nhận đơn hàng' />
			
			";
			echo "</ul>";
		} else {
			echo "Giỏ hàng rỗng hoặc chưa đặt hàng.";
		}
		 ?>  
          <?php
            $sqlthongke = "SELECT dh.ngaydathang AS ngaydat, SUM(ct.soluong) AS tongsoluong
             FROM dathang_chitiet ct JOIN dathang dh ON dh.iddh = ct.iddh
             WHERE idkh = $idkh 
             GROUP BY dh.ngaydathang";
			 $thongkemuahang = $t->laydanhsach($sqlthongke);
			 $labels = array();
			 $data = array();
			 foreach ($thongkemuahang as $row) {
                  $labels[] = $row['ngaydat'];
              $data[]   = (int) $row['tongsoluong'];
                  }
			
		  ?>
          <h1 align="center">THỐNG KÊ MUA HÀNG</h1>
          <canvas id="canvas" height="10px" width="10px"></canvas>
          <script>
                    const labels = <?php echo json_encode($labels); ?>;
                    const data = {
                        labels: labels,
                        datasets: [{
                            label: 'Tổng số lượng',
                            data: <?php echo json_encode($data); ?>,
                            borderColor: 'rgb(25, 107, 107)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            tension: 0.4,
                            fill: true
                        }]
                    };

                    const config = {
                        type: 'line',
                        data: data,
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: true,
                                    labels: {
                                        color: 'black',
                                        font: {
                                            size: 15
                                        }
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    ticks: {
                                        color: 'black',
                                        font: {
                                            size: 15
                                        }
                                    }
                                },
                                y: {
                                    ticks: {
                                        color: 'black',
                                        font: {
                                            size: 15
                                        }
                                    },
                                    beginAtZero: true
                                }
                            }
                        }
                    };

                    const ctx = document.getElementById('canvas').getContext('2d');
                    new Chart(ctx, config);
                </script>
        </div>
    </div>
    <div id ="footer">
           <h1 style = 'color: white; aglin'>Trần Tấn Tài - 22727771</h1>
        
    </div>
    
</div>
<body>
</body>
</html>