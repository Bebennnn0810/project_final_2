<?php
if (empty($_SESSION['FirstName'])) {
    die("<script>alert('Unauthorized Access!Please Login');window.location.href='../index.php';</script>");
}
?>