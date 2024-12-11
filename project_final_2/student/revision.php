<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revision Page</title>
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

        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 8px;
        }

        .question {
            margin-bottom: 20px;
        }

        img {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 5px;
        }

        .answer-status {
            font-weight: bold;
        }

    </style>
</head>

<body>
    <?php
    include('../header.php');
    include('../connection.php');
    if (empty($_GET) OR empty($_SESSION['FirstName'])) {
        die("<script>alert('Unauthorized Access !');window.location.href='mainStudent.php';</script>");
    }
    $explode = explode("|", $_GET['collect']);
    list($no_correct, $no_quest, $percentage, $no_ans) = $explode;
    $search_inst = "SELECT * FROM question,quiz,result,student WHERE 
               quiz.quizID=question.quizID
               AND question.QuestionID=result.QuestionID
               AND student.StudentID=result.StudentID
               AND student.StudentID='" . $_SESSION['StudentID'] . "'
               AND question.QuizID='" . $_GET['no_set'] . "'
               ";
    $inst_select = "SELECT * FROM quiz WHERE QuizID='" . $_GET['no_set'] . "' ";
    $exec = mysqli_query($conn, $inst_select);
    $data = mysqli_fetch_array($exec);
    $search_inst = mysqli_query($conn, $search_inst);
    echo "<div class='container'>
            <h3>Revision</h3>
            <p>Topic: " . $data['QuizName'] . "</p>
            <p>Score: " . $no_correct . "/" . $no_quest . "</p>
            <p>Percentage: " . $percentage . "</p>
            <hr>";
    $no = 0;
    while ($record = mysqli_fetch_array($search_inst)) {
        if ($record['Choice'] != "No Answered") {
            $ans_val = $record['Choice'];
        } else {
            $ans_val = "No Answered";
        }
        echo "<div class='question'>
                <p>Question No: " . ++$no . "</p>
                <p>" . $record['QuestionName'] . "</p>";
        // Display image if it exists
        if (!empty($record['Picture']) && file_exists($record['Picture'])) {
            echo "<img src='" . $record['Picture'] . "' alt='Image'><br>";
        }
        echo "<ul>
                <li>" . $record['choiceA'] . "</li>
                <li>" . $record['choiceB'] . "</li>
                <li>" . $record['choiceC'] . "</li>
                <li>" . $record['choiceD'] . "</li>
            </ul>
            <p>Actual Answer: " . $record['choiceA'] . "</p>
            <p>Your Answer: " . $ans_val . "</p>
            <p class='answer-status'>Status: " . $record['Remarks'] . "</p>
            <hr>
            </div>";
    }
    echo "</div>";
    mysqli_close($conn);
    ?>
    <?php include('../footer.php'); ?>
</body>

</html>
