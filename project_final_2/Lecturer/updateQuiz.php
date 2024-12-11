<?php
include('../connection.php');
include('lecturer_header.php');

// Handle form submission for updates
if (!empty($_POST['update'])) {
    // Loop through each submitted row
    foreach ($_POST['update'] as $updateData) {
        // Escape user inputs to prevent SQL injection
        $QuizID = mysqli_real_escape_string($conn, $updateData['QuizID']);
        $LectID = mysqli_real_escape_string($conn, $updateData['LectID']);
        $QuizName = mysqli_real_escape_string($conn, $updateData['QuizName']);
        $Instruction = mysqli_real_escape_string($conn, $updateData['Instruction']);
        $Time = mysqli_real_escape_string($conn, $updateData['Time']);
        $Date = mysqli_real_escape_string($conn, $updateData['Date']);

        // Validate user inputs
        if (empty($QuizID) || empty($LectID) ||  empty($QuizName) || empty($Instruction)) {
            die("<script>alert('Please provide QuizID and LectID');
            window.history.back();</script>");
        }

        // Build the update query based on provided fields
        $updateQuery = "UPDATE quiz SET";

        // Check and add LectID to the query
        if (!empty($LectID)) {
            $updateQuery .= " LectID = '$LectID',";
        }

        // Check and add QuizName to the query
        if (!empty($QuizName)) {
            $updateQuery .= " QuizName = '$QuizName',";
        }

        // Check and add Instruction to the query
        if (!empty($Instruction)) {
            $updateQuery .= " Instruction = '$Instruction',";
        }

        // Check and add Time to the query
        if (!empty($Time)) {
            $updateQuery .= " Time = '$Time',";
        }

        // Check and add Date to the query
        if (!empty($Date)) {
            $updateQuery .= " Date = '$Date',";
        }

        // Remove the trailing comma
        $updateQuery = rtrim($updateQuery, ',');

        // Complete the update query
        $updateQuery .= " WHERE QuizID = '$QuizID'";

        // Execute the update query
        if (mysqli_query($conn, $updateQuery)) {
            echo "<script>alert('Update successful.');
            window.location.href='updateQuiz.php';</script>";
        } else {
            echo "<script>alert('Update failed.');
            window.location.href='updateQuiz.php';</script>";
        }
    }
}

// Display the table with editable fields
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
            text-align: center;
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

        input[type="submit"] {
            background-color: #007BFF;
            /* Blue color */
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
            /* Darker blue on hover */
        }

        button {
            background-color: #FF0000;
            /* Red color */
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #cc0000;
            /* Darker red on hover */
        }

    </style>
</head>

<body>
    <h3>Quiz List</h3>

    <form action="" method="post">
        <table width='100%' border='1' id='big'>
            <tr>
                <th>QuizID</th>
                <th>LectID</th>
                <th>Quiz Name</th>
                <th>Instruction</th>
                <th>Time</th>
                <th>Date</th>
                <th>Functions</th>
            </tr>
            <?php
            // Select data from the Quiz table
            $set_command = "SELECT * FROM quiz ORDER BY QuizID ASC";
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
                    <td><input type='text' name='update[" . $data['QuizID'] . "][QuizID]' value='" . $data['QuizID'] . "' ></td>
                    <td>
                       
                        <select name='update[" . $data['QuizID'] . "][LectID]'>";
                        $lecturer_query = "SELECT LectID FROM lecturer";
                        $lecturer_result = mysqli_query($conn, $lecturer_query);
                        while ($lecturer_data = mysqli_fetch_array($lecturer_result)) {
                            echo "<option value='" . $lecturer_data['LectID'] . "' " . ($lecturer_data['LectID'] == $data['LectID'] ? 'selected' : '') . ">" . $lecturer_data['LectID'] . "</option>";
                        }
                echo "</select>
                    </td>
                    <td><input type='text' name='update[" . $data['QuizID'] . "][QuizName]' value='" . $data['QuizName'] . "'></td>
                    <td><input type='text' name='update[" . $data['QuizID'] . "][Instruction]' value='" . $data['Instruction'] . "'></td>
                    <td>" . $data['Time'] . "<br><br><input type='time' name='update[" . $data['QuizID'] . "][Time]' value='" . $data['Time'] . "'></td>
                    <td><input type='date' name='update[" . $data['QuizID'] . "][Date]' value='" . $data['Date'] . "'></td>
                    <td>
                        <input type='submit' value='Update'>
                        <button onclick=\"location.href='lecturer_delete.php?table=quiz&column=QuizID&pk=" . $data['QuizID'] . "'\" type='button'>Delete</button>
                    </td>
                </tr>";
            }
            ?>
        </table>
    </form>
</body>

</html>
