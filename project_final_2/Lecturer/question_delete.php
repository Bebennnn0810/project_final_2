<?php
session_start();

if (!empty($_GET['table']) && !empty($_GET['column']) && !empty($_GET['pk'])) {
    include('../connection.php');
    
    // Fetch the parameters from the URL
    $table = mysqli_real_escape_string($conn, $_GET['table']);
    $row = mysqli_real_escape_string($conn, $_GET['column']);
    $id = mysqli_real_escape_string($conn, $_GET['pk']);
    
    // Prepare and execute the delete query
    $delete_query = "DELETE FROM $table WHERE $row = '$id'";
    if (mysqli_query($conn, $delete_query)) {
        // Success message and redirection
        echo "<script>alert('Deleted Successfully'); window.history.back();</script>";
    } else {
        // Error handling
        echo "<script>alert('Failed to Delete: " . mysqli_error($conn) . "'); window.history.back();</script>";
    }
} else {
    // Handle unauthorized access or missing parameters
    die("<script>alert('Unauthorized Access or Missing Parameters'); window.history.back();</script>");
}
?>
