<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Instructions</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        h3 {
            color: #333;
        }

        hr {
            border: 1px solid #ddd;
            margin: 20px 0;
        }

        p {
            margin: 20px;
        }

        a {
            display: inline-block;
            padding: 10px 20px;
            text-decoration: none;
            color: #fff;
            background-color: #4CAF50;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #45a049;
        }

    </style>
</head>

<body>
    <?php
    include('../header.php');
    include('../connection.php');
    
    if (empty($_GET)) {
        die("<script>alert('Unauthorized Access');window.location.href='mainStudent.php';</script>");
    }

    $quiz_id = $_GET['no_set'];
    $student_id = $_SESSION['StudentID'];

    // Fetch quiz details
    $inst_select = "SELECT * FROM quiz WHERE QuizID='$quiz_id' ";
    $exec = mysqli_query($conn, $inst_select);
    $data = mysqli_fetch_array($exec);

    // Clear previous results for the current quiz and student
    $delete_previous_results = "DELETE FROM result WHERE studentID='$student_id' AND quizID='$quiz_id'";
    mysqli_query($conn, $delete_previous_results);
    ?>

    <h3>Instructions</h3>
    <hr>
    <p><?php echo $data['Instruction']; ?></p>

    <!-- Start Quiz Button -->
    <a href='answer_question.php?quizID=<?php echo $quiz_id; ?>&time=<?php echo $data['Time']; ?>'>Start</a>

    <?php include('../footer.php'); ?>
</body>

</html>
