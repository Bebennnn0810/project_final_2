<?php
session_start();
include('lecturer_guard.php');
include('../connection.php');

if (empty($_SESSION['Position'])) {
    $position_check = "SELECT * FROM lecturer WHERE LectID='" . $_SESSION['LectID'] . "' limit 1";
    $exec_position_check = mysqli_query($conn, $position_check);
    $data = mysqli_fetch_array($exec_position_check);
    $_SESSION['Position'] = $data['Position'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background-image: url('https://wallpaperaccess.com/full/2909133.jpg');
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 20px 0;
        }

        h1 {
            margin: 0;
        }

        nav {
            background-color: #333;
            text-align: center;
            padding: 10px 0;
        }

        nav a {
            text-decoration: none;
            margin: 0 10px;
            display: inline-block;
            padding: 10px 20px;
            color: #000;
            background-color: #FFD700;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
        }

        nav a:hover {
            background-color: #b28900;
            color: #000;
        }

        /* Disable style for position indicator */
        nav a[disabled] {
            background-color: #333;
            color: #FFD700;
            font-weight: bold;
        }

        hr {
            border: 1px solid #ddd;
            margin: 20px 0;
        }

    </style>
</head>

<body>
    <header>
        <h1><img src="quiz3.png" alt="Logo"></h1>
        <h1 style="font-weight: bold;"><?php echo "Welcome " . $_SESSION['FirstName']; ?><br></h1>
    </header>

    <nav>
        <a disabled><?php echo $_SESSION['Position']; ?></a>
        <a href='mainLecturer.php'>Main Menu</a>
        <?php if ($_SESSION['Position'] == 'ADMIN') { ?>
        <a href='lecturer_list.php'>Educator's Info</a>
        <a href='student_list.php'>Student Info</a>
        <a href='section_list.php'>Section</a>
        <a href='subject_list.php'>Subject</a>
        <?php } ?>
        <a href='quizSet.php'>Quiz Management</a>
        <a href='analysis.php'>Analysis</a>
        <a href='../logout.php'>Logout</a>
    </nav>

    <hr>
</body>

</html>
