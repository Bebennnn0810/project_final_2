<?php
include('../connection.php');
include('lecturer_header.php');

// Handle form submission for updates
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    foreach ($_POST['update'] as $QuestionID => $updateData) {
        // Escape user inputs to prevent SQL injection
        $QuestionID = mysqli_real_escape_string($conn, $QuestionID);
        $QuizID = mysqli_real_escape_string($conn, $updateData['QuizID']);
        $QuestionName = mysqli_real_escape_string($conn, $updateData['QuestionName']);
        $choiceA = mysqli_real_escape_string($conn, $updateData['choiceA']);
        $choiceB = mysqli_real_escape_string($conn, $updateData['choiceB']);
        $choiceC = mysqli_real_escape_string($conn, $updateData['choiceC']);
        $choiceD = mysqli_real_escape_string($conn, $updateData['choiceD']);
        $CorrectAnswer = mysqli_real_escape_string($conn, $updateData['CorrectAnswer']);
        
        // Validate user inputs
        if (empty($QuestionID) || empty($QuizID) || empty($QuestionName) || empty($choiceA) || empty($choiceB) || empty($choiceC) || empty($choiceD) || empty($CorrectAnswer)) {
            echo "<script>alert('Please complete the information'); window.history.back();</script>";
            exit();
        }

        // Update the record
        $updateQuery = "UPDATE question SET
            QuizID = '$QuizID',
            QuestionName = '$QuestionName',
            choiceA = '$choiceA',
            choiceB = '$choiceB',
            choiceC = '$choiceC',
            choiceD = '$choiceD',
            CorrectAnswer = '$CorrectAnswer'
            WHERE QuestionID = '$QuestionID'";

        // Execute the update query
        if (!mysqli_query($conn, $updateQuery)) {
            echo "<script>alert('Update failed for QuestionID $QuestionID.'); window.history.back();</script>";
            exit();
        }
    }

    // If everything is updated successfully, redirect to the questions list
    echo "<script>alert('Update Successful'); window.location.href='questions_list.php';</script>";
    exit();
}

if (!isset($_GET['QuizID'])) {
    echo "<script>alert('No QuizID provided'); window.location.href='quizSet.php';</script>";
    exit();
}

$QuizID1 = mysqli_real_escape_string($conn, $_GET['QuizID']);

// Display the table with editable fields
?>
<!DOCTYPE html>
<html>

<head>
    <title>Senarai Soalan</title>
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

        input[type="text"],
        select {
            width: 100%;
            padding: 6px;
            margin: 4px 0;
            display: inline-block;
            border: 1px solid #1E90FF;
            box-sizing: border-box;
        }

        input[type="submit"] {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            text-align: center;
            background-color: #28a745;
            color: white;
            display: inline-block;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        button.delete {
            padding: 10px 15px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }

        button.delete:hover {
            background-color: #c82333;
        }

        .form-container {
            text-align: center;
            margin-top: 20px;
        }

    </style>
</head>

<body>
    <h3>Senarai Soalan</h3>

    <form action="" method="post">
        <table width='100%' border='1' id='besar'>
            <tr>
                <th>QuestionID</th>
                <th>QuizID</th>
                <th>Question Name</th>
                <th>Choice A</th>
                <th>Choice B</th>
                <th>Choice C</th>
                <th>Choice D</th>
                <th>Correct Answer</th>
                <th>Action</th>
            </tr>
            <?php
            $set_command = "SELECT * FROM question WHERE QuizID = '$QuizID1' ORDER BY QuestionID DESC";
            $execute_set = mysqli_query($conn, $set_command);

            while ($data = mysqli_fetch_array($execute_set)) {
                echo "<tr>
                    <td><input type='text' name='update[" . $data['QuestionID'] . "][QuestionID]' value='" . $data['QuestionID'] . "' readonly></td>
                    <td>
                        <select name='update[" . $data['QuestionID'] . "][QuizID]'>";

                            // Fetch QuizID values from quiz table
                            $quiz_query = "SELECT QuizID FROM quiz";
                            $quiz_result = mysqli_query($conn, $quiz_query);
                            while ($quiz_data = mysqli_fetch_array($quiz_result)) {
                                echo "<option value='" . $quiz_data['QuizID'] . "' " . ($quiz_data['QuizID'] == $data['QuizID'] ? 'selected' : '') . ">" . $quiz_data['QuizID'] . "</option>";
                            }
                        echo "</select>
                    </td>
                    <td><input type='text' name='update[" . $data['QuestionID'] . "][QuestionName]' value='" . $data['QuestionName'] . "'></td>
                    <td><input type='text' name='update[" . $data['QuestionID'] . "][choiceA]' value='" . $data['choiceA'] . "'></td>
                    <td><input type='text' name='update[" . $data['QuestionID'] . "][choiceB]' value='" . $data['choiceB'] . "'></td>
                    <td><input type='text' name='update[" . $data['QuestionID'] . "][choiceC]' value='" . $data['choiceC'] . "'></td>
                    <td><input type='text' name='update[" . $data['QuestionID'] . "][choiceD]' value='" . $data['choiceD'] . "'></td>
                    <td><input type='text' name='update[" . $data['QuestionID'] . "][CorrectAnswer]' value='" . $data['CorrectAnswer'] . "'></td>
                    <td>
                        <button 
                            type='button' 
                            class='delete' 
                            onclick=\"location.href='lecturer_delete.php?table=question&column=QuestionID&pk=" . $data['QuestionID'] . "'\">
                            Delete
                        </button>
                    </td>
                </tr>";
            }
            ?>
        </table>
        <div class="form-container">
            <input type="submit" value="Update All Questions">
        </div>
    </form>

</body>

</html>
