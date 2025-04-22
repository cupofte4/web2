<?php 
    session_start();
    // xoa session
    // - unset : chi xoa 1 session
    // - session_destroy: xoa all session
    session_unset();

    // hearder('Location: index.php'); // bam dang xuat xong se link toi trang index.php
    header('Location: ../index.php');
?>