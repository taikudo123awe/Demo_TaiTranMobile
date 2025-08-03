<?php
class connect
{
    private $host = "localhost";
    private $user = "admin";
    private $pass = "1";
    private $db = "tmdt_db";

    public function connection()
    {
        $con = mysqli_connect($this->host, $this->user, $this->pass, $this->db);
        if (!$con) {
            die("Lỗi kết nối: " . mysqli_connect_error());
        }
        // Đảm bảo charset tiếng Việt không lỗi
        mysqli_set_charset($con, "utf8");
        return $con;
    }

    public function xemdscongty($sql)
    {
        $link = $this->connection();
        $ketqua = mysqli_query($link, $sql);
        if (!$ketqua) {
            die("Lỗi SQL: " . mysqli_error($link));
        }

        if (mysqli_num_rows($ketqua) > 0) {
            while ($row = mysqli_fetch_array($ketqua)) {
                $id = $row['idcty'];
                $tencty = $row['tencty'];

                echo '<a href="index.php?idsp=' . $id . '">' . $tencty . '</a><br>';
            }
        } else {
            echo 'Không có dữ liệu';
        }
    }

    public function xemdsanpham($sql)
    {
        $link = $this->connection();
        $ketqua = mysqli_query($link, $sql);
        if (!$ketqua) {
            die("Lỗi SQL: " . mysqli_error($link));
        }

        if (mysqli_num_rows($ketqua) > 0) {
            while ($row = mysqli_fetch_array($ketqua)) {
                $idsp = $row['idsp'];
                $tensp = $row['tensp'];
                $gia = $row['gia'];
                $hinh = $row['hinh'];

                echo "
                    <a href='chitietsanpham.php?idsp=" . $idsp . "'>
                        <div id='sanpham'>
                            <div id='ten'>" . $tensp . "</div>
                            <div id='hinh'><img src='hinh/" . $hinh . "' style='width: 200px; height: 200px;'></div>
                            <div id='gia'>" . $gia . "</div>
                        </div>
                    </a>
                ";
            }
        } else {
            echo 'Không có dữ liệu';
        }
    }
}
?>
