<?php
include_once("clsdatabase.php");

class quantri extends connect
{
    public function themxoasua($sql)
    {
        $link = $this->connection();
        if (mysqli_query($link, $sql)) {
            return 1;
        } else {
            echo "Lỗi SQL: " . mysqli_error($link);
            return 0;
        }
    }

    public function uploadfile($name, $tmp_name, $folder)
    {
        $path = $folder . "/" . $name;
        if ($name != '') {
            if (move_uploaded_file($tmp_name, $path)) {
                return 1;
            } else {
                return 0;
            }
        } else {
            return -1;
        }
    }

    public function choncongty($sql)
    {
        $link = $this->connection();
        $ketqua = mysqli_query($link, $sql);
        if (!$ketqua) {
            echo "Lỗi SQL: " . mysqli_error($link);
            return;
        }

        $i = mysqli_num_rows($ketqua);
        if ($i > 0) {
            echo '<label for="dscongty"></label>
                <select name="dscongty" size="1" id="dscongty">
                <option value="0">Mời chọn công ty</option>';

            while ($row = mysqli_fetch_array($ketqua)) {
                $id = $row['idcty'];
                $tencty = $row['tencty'];
                echo '<option value="' . $id . '">' . $tencty . '</option>';
            }
            echo '</select>';
        } else {
            echo 'Không có dữ liệu';
        }
    }

    public function loaddssampham($sql)
    {
        $link = $this->connection();
        $ketqua = mysqli_query($link, $sql);
        if (!$ketqua) {
            echo "Lỗi SQL: " . mysqli_error($link);
            return;
        }

        $i = mysqli_num_rows($ketqua);
        if ($i > 0) {
            echo '<table width="978" height="105" border="1" align="center">
                    <tr>
                        <td width="71"><strong>STT</strong></td>
                        <td width="281"><strong>Tên sản phẩm</strong></td>
                        <td width="345"><strong>Mô Tả</strong></td>
                        <td width="132"><strong>Giá</strong></td>
                        <td width="115"><strong>Giảm giá</strong></td>
                        <td width="115"><strong>Thao tác</strong></td>
                    </tr>';
            $dem = 1;
            while ($row = mysqli_fetch_array($ketqua)) {
                $id = $row['idsp'];
                $tensp = $row['tensp'];
                $mota = $row['mota'];
                $gia = $row['gia'];
                $giamgia = $row['giamgia'];
                echo '<tr>
                        <td>' . $dem . '</td>
                        <td>' . $tensp . '</td>
                        <td>' . $mota . '</td>
                        <td>' . $gia . '</td>
                        <td>' . $giamgia . '</td>
                        <td><a href="admin.php?id=' . $id . '">Chọn sản phẩm</a></td>
                    </tr>';
                $dem++;
            }
            echo '</table>';
        } else {
            echo 'Không có dữ liệu';
        }
    }

    public function chitietsanpham($idsp)
    {
        $sql = "SELECT idsp, tensp, gia, mota, hinh, giamgia, tencty 
                FROM sanpham 
                JOIN congty ON congty.idcty = sanpham.idcty 
                WHERE idsp = " . intval($idsp);

        $link = $this->connection();
        $ketqua = mysqli_query($link, $sql);
        if (!$ketqua) {
            echo "Lỗi SQL: " . mysqli_error($link);
            return;
        }

        $i = mysqli_num_rows($ketqua);
        if ($i > 0) {
            echo '
            <form id="form1" name="form1" method="post" action="">
              <table width="548" border="0" align="center">
                <tr>
                  <td colspan="2"><div align="center"><strong>CHI TIẾT SẢN PHẨM</strong></div></td>
                </tr>';

            while ($row = mysqli_fetch_array($ketqua)) {
                $id = $row['idsp'];
                $tensp = $row['tensp'];
                $mota = $row['mota'];
                $hinh = $row['hinh'];
                $gia = $row['gia'];
                $giamgia = $row['giamgia'];
                $congty = $row['tencty'];
                echo '
                    <tr>
                      <td width="142" rowspan="7"><img src="hinh/' . $hinh . '" style ="width: 300px; height: 300px;"></td>
                      <td width="168">Tên sản phẩm: ' . $tensp . '</td>
                    </tr>
                    <tr>
                      <td>Công Ty: ' . $congty . '</td>
                    </tr>
                    <tr>
                      <td>Mô tả: ' . $mota . '</td>
                    </tr>
                    <tr>
                      <td>Giá: ' . $gia . '</td>
                    </tr>
                    <tr>
                      <td>Số Lượng <input type="number" name="soluong" id="soluong" /></td>
                    </tr>
                    <tr>
                      <td><div align="center">
                        <input type="submit" name="nut" id="nut" value="Đặt hàng" />
                      </div></td>
                    </tr>
                    <tr>
                      <td><a href="index.php">Quay lại danh sách</a></td>
                    </tr>';
            }

            echo '</table></form>';
        } else {
            echo 'Không có dữ liệu';
        }
    }

    public function lay1dong($sql)
    {
        $link = $this->connection();
        $ketqua = mysqli_query($link, $sql);
        if ($ketqua && mysqli_num_rows($ketqua) > 0) {
            $row = mysqli_fetch_array($ketqua);
            return $row;
        } else {
            echo "Lỗi SQL hoặc không có dữ liệu: " . mysqli_error($link);
            return false;
        }
    }

    public function laydanhsach($sql)
    {
        $link = $this->connection();
        $ketqua = mysqli_query($link, $sql);

        if ($ketqua && mysqli_num_rows($ketqua) > 0) {
            $data = array();
            while ($row = mysqli_fetch_array($ketqua)) {
                $data[] = $row;
            }
            return $data;
        } else {
            echo "Lỗi SQL hoặc không có dữ liệu: " . mysqli_error($link);
            return false;
        }
    }

    public function giohang($idkh)
    {
        if ($idkh != '') {
            $sql = "SELECT dh.iddh, dh.idkh, dh.ngaydathang, dh.trangthai, 
                        ct.idsp, ct.soluong, ct.dongia, ct.giamgia,
                        sp.tensp
                    FROM dathang dh 
                    JOIN dathang_chitiet ct ON ct.iddh = dh.iddh
                    JOIN sanpham sp ON sp.idsp = ct.idsp
                    WHERE dh.idkh = '$idkh'";

            $link = $this->connection();
            $ketqua = mysqli_query($link, $sql);

            if ($ketqua && mysqli_num_rows($ketqua) > 0) {
                $result = array();
                while ($row = mysqli_fetch_array($ketqua)) {
                    $result[] = $row;
                }
                return $result;
            } else {
                return array();
            }
        } else {
            echo 'Đăng nhập mới dùng được giỏ hàng';
            return array();
        }
    }
}
?>
