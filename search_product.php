<?php
public function search($name)
{
    $link = $this->conn();
    $sql = "select * from sanpham where tensp = '$name' order by gia asc";
    $ketqua = mysqli_query($link,$sql)
    $i = mysqli_num_rows($ketqua)
    if($i>0)
    {
        while($row = mysqli_fetch_array($ketqua))
        {

            echo 'Danh sach san pham theo ten';
        }
    }
    else
    {
        echo "Khong tim thay san pham";
        
    }

}

?>