<?php
session_start();
if(!empty($_GET))
{
    include('../connection.php');
    
    $table = $_GET['table'];
    $row = $_GET['column'];
    $id = $_GET['pk'];
    
    $arahan_padam = "delete from $table where $row ='$id'";
    if(mysqli_query($conn,$arahan_padam))
    {
        echo "<script>alert('Deleted Successfully');
        window.history.back();</script>";
    }
    else{
        echo "<script>slert('Failed to Delete');
            window.history.back();</script>";
    }
}
else{
    die("<script>alert('Unauthorized Access');
    window.history.back();</script>");
}
?>