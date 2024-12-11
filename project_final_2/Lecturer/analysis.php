<?php 
include('lecturer_header.php');
include('../connection.php');
?>

<html>

<head>
    <title>Student Performance Analysis</title>

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
            width: 50%;
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

        select,
        input[type="submit"],
        button {
            width: 50%;
            padding: 10px;
            margin: 5px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        select {
            width: 50%;
        }

        input[type="submit"],
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover,
        button:hover {
            background-color: #45a049;
        }

        .print-button {
            display: block;
            margin: 20px auto;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .print-button:hover {
            background-color: #45a049;
        }

    </style>
</head>

<body>
    <form action="" method="post">
        Section
        <select name='SectionID'>
            <option value selected disabled>Choose</option>
            <?php
            if ($_SESSION['Position'] == 'ADMIN') {
                $sql = "SELECT * FROM section";
            } else {
                $sql = "SELECT * FROM Section WHERE SectionID IN (SELECT SectionID FROM lecturer WHERE LectID = '".$_SESSION['LectID']."')";
            }
           
            $section_result = mysqli_query($conn, $sql);
            echo "<div style='text-align:center;'>";
            while ($record = mysqli_fetch_array($section_result)) {
                echo "<option value='" . $record['SectionID'] . "'>" . $record['SectionName'] . "</option>";
            }
            echo "</div>";
            ?>
        </select>
        <br>
        Topic
        <select name='QuizID'>
            <option value selected disabled>Choose</option>
            <?php
            if ($_SESSION['Position'] == 'ADMIN') {
                $sql2 = "SELECT * FROM quiz, lecturer WHERE lecturer.LectID = quiz.LectID";
            } else {
                $sql2 = "SELECT * FROM quiz, lecturer WHERE quiz.LectID = lecturer.LectID AND quiz.LectID = '".$_SESSION['LectID']."'";
            }
           
            $topic_result = mysqli_query($conn, $sql2);
            echo "<div style='text-align:center;'>";
            while ($record2 = mysqli_fetch_array($topic_result)) {
                echo "<option value='" . $record2['QuizID'] . "'>" . $record2['QuizName'] . "</option>";
            }
            echo "</div>";
            ?>
        </select>
        <br>
        <input type="submit" value="View Results">
    </form>

    <?php
    if (!empty($_POST)) {
        $sectionID = $_POST['SectionID'];
        $quizID = $_POST['QuizID'];
        
        // Fetch section and topic names
        $section_query = "SELECT * FROM SECTION WHERE SectionID='$sectionID'";
        $section_result = mysqli_query($conn, $section_query);
        $section_data = mysqli_fetch_array($section_result);
        $section_name = $section_data['SectionID'] . " " . $section_data['SectionName'];
        
        $topic_query = "SELECT * FROM quiz WHERE QuizID='$quizID'";
        $topic_result = mysqli_query($conn, $topic_query);
        $topic_data = mysqli_fetch_array($topic_result);
        $topic_name = $topic_data['QuizName'];
        
        // Query to fetch student details in the selected section
        $student_query = "SELECT * FROM student WHERE SectionID='$sectionID'";
        $student_result = mysqli_query($conn, $student_query);

        if (mysqli_num_rows($student_result) >= 1) {
            echo "<h3>Section: $section_name</h3>";
            echo "<h3>Topic: $topic_name</h3>";
            echo "<button class='print-button' onClick='window.print()'>Print</button>";
            echo "<table width='100%' border='1'>
                  <tr>
                      <th>Student ID</th>
                      <th>Student Name</th>
                      <th>Score</th>
                      <th>Marks</th>
                      <th>Progress</th>
                  </tr>";

            while ($student = mysqli_fetch_array($student_result)) {
                echo "<tr>
                      <td>".$student['StudentID']."</td>
                      <td>".$student['FirstName']." ".$student['LastName']."</td>";
                score($quizID, $student['StudentID']);
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No Data Found!</p>";
        }
    }

    // Function to calculate and display score, marks, and progress
    function score($quizID, $StudentID) {
        include('../connection.php');
        $score_query = "SELECT * FROM result, question, quiz
                        WHERE quiz.QuizID = question.QuizID
                        AND result.QuestionID = question.QuestionID
                        AND result.StudentID = '$StudentID'
                        AND quiz.QuizID = '$quizID'";
        $score_result = mysqli_query($conn, $score_query);
        $total_questions = mysqli_num_rows($score_result);
        $correct_answers = 0;

        if ($total_questions > 0) {
            while ($record = mysqli_fetch_array($score_result)) {
                if ($record['Remarks'] === 'CORRECT') {
                    $correct_answers++;
                }
            }
            
            // Calculate score and percentage
            $marks = "$correct_answers/$total_questions";
            $percentage = number_format(($correct_answers / $total_questions) * 100, 0) . "%";
            $progress = "Done";
            
            echo "<td>$marks</td><td>$percentage</td><td>$progress</td>";
        } else {
            // Placeholder for students who haven't answered
            echo "<td>0</td><td>0%</td><td>Not Answered</td>";
        }
    }
    ?>

    <?php include('lecturer_footer.php'); ?>
</body>

</html>
