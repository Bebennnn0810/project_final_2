<?php
if (empty($_SESSION['FirstName'])) {
    # code...
    die("<script>alert('Unauthorized Access.Please login !');window.location.href='../index.php';</script>");

}
?>