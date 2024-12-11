<?php
// Include the database connection and header
include('../connection.php');
include('lecturer_header.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $QuestionID = mysqli_real_escape_string($conn, $_POST['QuestionID']);
    $QuizID = mysqli_real_escape_string($conn, $_POST['QuizID']);
    $QuestionName = mysqli_real_escape_string($conn, $_POST['QuestionName']);
    $choiceA = mysqli_real_escape_string($conn, $_POST['choiceA']);
    $choiceB = mysqli_real_escape_string($conn, $_POST['choiceB']);
    $choiceC = mysqli_real_escape_string($conn, $_POST['choiceC']);
    $choiceD = mysqli_real_escape_string($conn, $_POST['choiceD']);
    $CorrectAnswer = mysqli_real_escape_string($conn, $_POST['CorrectAnswer']);

    // Validate input
    if (empty($QuizID) || empty($QuestionName) || empty($choiceA) || empty($choiceB) || empty($choiceC) || empty($choiceD) || empty($CorrectAnswer)) {
        echo "<script>alert('Please complete all the information.'); window.location.href='questions_list.php';</script>";
        exit();
    }

    // Insert data into the database
    $store = "INSERT INTO question (QuizID, QuestionName, choiceA, choiceB, choiceC, choiceD, CorrectAnswer) 
              VALUES ('$QuizID', '$QuestionName', '$choiceA', '$choiceB', '$choiceC', '$choiceD', '$CorrectAnswer')";

    if (mysqli_query($conn, $store)) {
        header('Location: questions_list.php?QuizID=' . $QuizID); // Redirect after successful insert
        exit();
    } else {
        echo "<script>alert('Registration failed: " . mysqli_error($conn) . "'); window.location.href='questions_list.php';</script>";
        exit();
    }
}

// Get QuizID from the URL
if (!isset($_GET['QuizID'])) {
    echo "<script>alert('No QuizID provided.'); window.location.href='quizSet.php';</script>";
    exit();
}

$QuizID1 = mysqli_real_escape_string($conn, $_GET['QuizID']);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Question List</title>
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
            width: 95%;
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
            text-align: center;
        }

        input[type="text"],
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

        /* Save button styles */
        input[type="submit"] {
            background-color: #2ecc71;
            color: white;
        }

        input[type="submit"]:hover {
            background-color: #27ae60;
        }

        /* Update button styles */
        button.update-btn {
            background-color: #28a745;
            color: white;
        }

        button.update-btn:hover {
            background-color: #218838;
        }

    </style>
</head>

<body>
    <h3>Question List</h3>

    <table width="100%" border="1" id="big">
        <tr>
            <th>QuizID</th>
            <th>Question Name</th>
            <th>Choice A</th>
            <th>Choice B</th>
            <th>Choice C</th>
            <th>Choice D</th>
            <th>Correct Answer</th>
            <th>Actions</th>
        </tr>

        <?php
        $set_command = "SELECT * FROM question WHERE QuizID = '$QuizID1' ORDER BY QuestionID DESC";
        $execute_set = mysqli_query($conn, $set_command);

        while ($data = mysqli_fetch_array($execute_set)) {
            echo "<tr>
                <td>" . htmlspecialchars($data['QuizID']) . "</td>
                <td>" . htmlspecialchars($data['QuestionName']) . "</td>
                <td>" . htmlspecialchars($data['choiceA']) . "</td>
                <td>" . htmlspecialchars($data['choiceB']) . "</td>
                <td>" . htmlspecialchars($data['choiceC']) . "</td>
                <td>" . htmlspecialchars($data['choiceD']) . "</td>
                <td>" . htmlspecialchars($data['CorrectAnswer']) . "</td>
                <td>
                    <a href='updateQuestion.php?QuizID=" . htmlspecialchars($data['QuizID']) . "'>
                        <button class='update-btn'>Update</button>
                    </a>
                </td>
            </tr>";
        }
        ?>
        <tr>
            <form action="" method="post">
                <td>
                    <!-- Hidden input for QuestionID -->
                    <input type="hidden" name="QuestionID" value="">
                    <!-- Input for QuizID, pre-filled with the current QuizID -->
                    <input type="text" name="QuizID" value="<?php echo $QuizID1; ?>" readonly>
                </td>
                <td><input type="text" name="QuestionName" placeholder='Enter the question'></td>
                <td><input type="text" name="choiceA" placeholder='Enter choice A'></td>
                <td><input type="text" name="choiceB" placeholder='Enter choice B'></td>
                <td><input type="text" name="choiceC" placeholder='Enter choice C'></td>
                <td><input type="text" name="choiceD" placeholder='Enter choice D'></td>
                <td>
                    <select name="CorrectAnswer">
                        <option value="">Select</option>
                        <option value="choiceA">choiceA</option>
                        <option value="choiceB">choiceB</option>
                        <option value="choiceC">choiceC</option>
                        <option value="choiceD">choiceD</option>
                    </select>
                </td>
                <td><input type="submit" value="Save"></td>
            </form>
        </tr>

    </table>
</body>

</html>
