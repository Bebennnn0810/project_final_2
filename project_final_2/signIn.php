<?php
session_start();

if (empty($_POST['matricNo']) or empty($_POST['password']) or empty($_POST['type'])) {
    die("<script>alert('Please enter username and password!');window.location.href='index.php';</script>");
}

if ($_POST['type'] == 'student') {
    $table = "student";
    $row1 = "StudentID";
    $row2 = "FirstName";
    $row3 = "LastName";
    $row4 = "Email";
    $row5 = "Password";
    $row6 = "SectionID";
    $location = "student/mainStudent.php";
} else if ($_POST['type'] == 'lecturer') {
    $table = "lecturer";
    $row1 = "LectID";
    $row2 = "FirstName";
    $row3 = "LastName";
    $row4 = "Email";
    $row5 = "Password";
    $row6 = "SectionID";
    $row7 = "Position";
    $row8 = "SubjectID";
    $location = "Lecturer/mainLecturer.php";
}

include('connection.php');
$matricno = mysqli_real_escape_string($conn, $_POST['matricNo']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

// SQL STATEMENT
$login_instruction = "SELECT * FROM $table 
WHERE
$row1='$matricno' AND $row5='$password'
LIMIT 1";

$login_execute = mysqli_query($conn, $login_instruction);

if (mysqli_num_rows($login_execute) == 1) {
    $data = mysqli_fetch_array($login_execute);
    $_SESSION[$row2] = $data[$row2];
    $_SESSION[$row1] = $data[$row1];
    echo "<script>window.location.href='$location';</script>";
} else {
    echo "<script>alert('Login Failed');window.history.back();</script>";
}

mysqli_close($conn);
?>
