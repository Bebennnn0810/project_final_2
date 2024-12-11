<?php
include('../connection.php');
include('lecturer_header.php');

if (!empty($_POST)) {
    // Collect form data
    $QuizID = mysqli_real_escape_string($conn, $_POST['QuizID']);
    $LectID = mysqli_real_escape_string($conn, $_POST['LectID']);
    $QuizName = mysqli_real_escape_string($conn, $_POST['QuizName']);
    $Instruction = mysqli_real_escape_string($conn, $_POST['Instruction']);
    $Time = mysqli_real_escape_string($conn, $_POST['Time']);
    $Date = mysqli_real_escape_string($conn, $_POST['Date']);

    // Validate input
    if (empty($QuizID) || empty($LectID) || empty($QuizName) || empty($Instruction) || empty($Time) || empty($Date)) {
        die("<script>alert('Please complete the information.');
            window.location.href='quizSet.php';</script>");
    }

    // Insert data into the database
    $store = "INSERT INTO quiz (QuizID, LectID, QuizName, Instruction, Time, Date) VALUES 
    ('$QuizID', '$LectID', '$QuizName', '$Instruction', '$Time', '$Date')";

    if (mysqli_query($conn, $store)) {
        echo "<script>alert('Registration successful.');
        window.location.href='quizSet.php';</script>";
    } else {
        echo "<script>alert('Registration failed: " . mysqli_error($conn) . "');
        window.location.href='quizSet.php';</script>";
    }
}
if (empty($_SESSION['LectID'])) {
    $lect_check = "SELECT * FROM lecturer WHERE LectID='" . $_SESSION['LectID'] . "' limit 1";
    $exec_lect_check = mysqli_query($conn, $position_check);
    $data = mysqli_fetch_array($exec_lect_check);
    $_SESSION['LectID'] = $data['LectID'];
   }
   if (empty($_SESSION['Position'])) {
    $position_check = "SELECT * FROM lecturer WHERE LectID='" . $_SESSION['LectID'] . "' limit 1";
    $exec_position_check = mysqli_query($conn, $position_check);
    $data = mysqli_fetch_array($exec_position_check);
    $_SESSION['Position'] = $data['Position'];
   }
?>

<!DOCTYPE html>
<html>

<head>
    <title>Quiz List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h3 {
            text-align: center;
            color: #333;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #e0e0e0;
        }

        form {
            margin: 10px;
        }

        input[type="text"],
        input[type="time"],
        input[type="date"],
        select {
            width: 100%;
            padding: 6px;
            margin: 4px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        input[type="submit"],
        button {
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .update-btn {
            background-color: #007BFF;
            /* Blue */
            color: #fff;
        }

        .update-btn:hover {
            background-color: #0056b3;
            /* Darker blue */
        }

        .delete-btn {
            background-color: #FF0000;
            /* Red */
            color: #fff;
        }

        .delete-btn:hover {
            background-color: #cc0000;
            /* Darker red */
        }

        .save-btn {
            background-color: #4CAF50;
            /* Green */
            color: #fff;
        }

        .save-btn:hover {
            background-color: #45a049;
            /* Darker green */
        }

        .questions-btn {
            background-color: #FFD700;
            /* Yellow */
            color: #000;
        }

        .questions-btn:hover {
            background-color: #e5c100;
            /* Darker yellow */
        }

    </style>
</head>

<body>
    <h3>Quiz List</h3>

    <?php include('../connection.php'); ?>

    <table width="100%" border="1">
        <tr>
            <th>QuizID</th>
            <th>TeacherID</th>
            <th>Quiz Name</th>
            <th>Instruction</th>
            <th>Time</th>
            <th>Date</th>
            <th>Functions</th>
        </tr>

        <?php
        // Select data from the Quiz table
        $set_command = "SELECT * FROM quiz WHERE LectID='" . $_SESSION['LectID'] . "' ORDER BY QuizID ASC";
        $execute_set = mysqli_query($conn, $set_command);

        while ($data = mysqli_fetch_array($execute_set)) {
            $data_get = array(
                'QuizID' => $data['QuizID'],
                'LectID' => $data['LectID'],
                'QuizName' => $data['QuizName'],
                'Instruction' => $data['Instruction'],
                'Time' => $data['Time'],
                'Date' => $data['Date']
            );

            echo "<tr>
                <td>" . $data['QuizID'] . "</td>
                <td>" . $data['LectID'] . "</td>
                <td>" . $data['QuizName'] . "</td>
                <td>" . $data['Instruction'] . "</td>
                <td>" . $data['Time'] . "</td>
                <td>" . $data['Date'] . "</td>
                <td>
                    <a href='updateQuiz.php?" . http_build_query($data_get) . "'>
                        <button type='button' class='update-btn'>Update</button>
                    </a>
                    <a href='lecturer_delete.php?table=quiz&column=QuizID&pk=" . $data['QuizID'] . "' onClick=\"return confirm('Are you sure to delete this data?')\">
                        <button type='button' class='delete-btn'>Delete</button>
                    </a>
                    <a href='questions_list.php?QuizID=" . $data['QuizID'] . "'>
                        <button type='button' class='questions-btn'>Questions</button>
                    </a>
                </td>
            </tr>";
        }
        ?>

        <tr>
            <!-- Form for adding a new quiz -->
            <form action="" method="post">
                <td><input type="text" name="QuizID" placeholder='Enter Quiz ID'></td>
                <td>
                    <!-- Dropdown menu for LectID -->
                    <input type="text" name="LectID" value="<?php echo $_SESSION['LectID']; ?>" readonly>
                </td>
                <td><input type="text" name="QuizName" placeholder='Enter Quiz Title'></td>
                <td><input type="text" name="Instruction" placeholder='What is the instruction'></td>
                <td><input type="time" name="Time" placeholder='Enter time'></td>
                <td><input type="date" name="Date" placeholder='Enter date'></td>
                <td><input type="submit" value="Save" class='save-btn'></td>
            </form>
        </tr>
    </table>
    <footer style="text-align: center; padding: 10px; background-color: #f4f4f4; color: #333;">
        Copyright © SMK JALAN OYA, SIBU 2024-2025. All Rights Reserved.
    </footer>
</body>

</html>
