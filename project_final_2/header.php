<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background-image: url('https://wallpaperaccess.com/full/2909133.jpg');
            background-size: cover;
            background-position: left;
            color: #fff;
            text-align: center;
            padding: 50px 0;
        }


        header img {
            width: 1000px;
            /* Increased width for larger display */
            max-width: 100%;
            /* Ensure it fits on smaller screens */
            background-size: cover;
            display: block;
            margin: 0 auto 10px;
        }

        h1 {
            margin: 10px 0;
            font-weight: bold;
            font-size: 2.5em;
            color: #fff;
            /* Gold color for the welcome text */
        }

        nav {
            background-color: #FFD700;
            /* Gold color for the nav background */
            text-align: center;
            padding: 10px 0;
        }

        nav a {
            text-decoration: none;
            margin: 0 10px;
            display: inline-block;
            padding: 10px 20px;
            color: #fff;
            background-color: #333;
            /* Charcoal grey */
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
        }

        nav a:hover {
            background-color: #4CAF50;
            /* Green for hover effect */
            color: #fff;
        }

        nav a[disabled] {
            background-color: #FFD700;
            color: #fff;
            /* Gold */
            cursor: default;
        }

        /* Logout button styling */
        nav a[href='../logout.php'] {
            background-color: #FF6347;
            /* Red for logout button */
            color: #fff;
        }

        nav a[href='../logout.php']:hover {
            background-color: #FF4500;
            /* Darker red on hover */
        }

        hr {
            border: 1px solid #ddd;
            margin: 20px 0;
        }

    </style>
</head>

<body>
    <header>
        <img src="quiz3.png" alt="QuizCrafter Logo">
        <h1><?php echo "Welcome, " . $_SESSION['FirstName']; ?></h1>
    </header>

    <nav>
        <?php if(!empty($_SESSION) && basename($_SERVER['PHP_SELF']) != 'index.php') { ?>
        <a disabled>STUDENT</a>
        <a href='mainStudent.php'>MAIN</a>
        <a href='../logout.php'>LOGOUT</a>
        <?php } ?>
    </nav>
    <hr>
</body>

</html>
