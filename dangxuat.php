<?php
    session_start(); // Bắt đầu session

    // Xoá toàn bộ session
    session_unset();     // Xoá các biến trong session
    session_destroy();   // Huỷ toàn bộ session
    
    // Chuyển hướng về trang đăng nhập hoặc trang chủ
    header("Location: index.php");
    exit();
?>