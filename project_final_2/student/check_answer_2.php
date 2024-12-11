<?php
// Include your database connection file
include('../header.php');
include('../connection.php');

// Check for unauthorized access
if (empty($_POST) and empty($_GET)) {
    die("<script>alert('Unauthorized Access !');window.location.href='mainStudent.php';</script>");
}

// Get the quizID from the URL
if (isset($_GET['quizID'])) {

    $quizID = $_GET['quizID'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Start HTML output
        echo "<html><head><style>";
        echo "body { font-family: Arial, sans-serif; background-color: #f9f9f9; margin: 0; padding: 0; text-align: center; }";
        echo "table { border-collapse: collapse; width: 50%; margin: 20px auto; }";
        echo "th, td { border: 1px solid black; padding: 10px; text-align: left; }";
        echo "th { background-color: #f2f2f2; }";
        echo ".correct { background-color: lightblue; font-weight: bold; }";
        echo ".incorrect { background-color: lightcoral; font-weight: bold; }";
        echo "</style></head><body>";

        $select_inst = "SELECT * FROM question WHERE QuizID= '$quizID'";
        $execute = mysqli_query($conn, $select_inst);

        $i = 0;

        while ($data = mysqli_fetch_array($execute)) {

            $studentAnswers = $_POST[$data['QuestionID']];

            $select_inst1 = "SELECT * FROM question WHERE QuestionID= '" . $data['QuestionID'] . "' ";
            $execute1 = mysqli_query($conn, $select_inst1);

            while ($data1 = mysqli_fetch_array($execute1)) {

                ++$i;

                // Display question details
                echo "<table>";
                echo "<tr><th colspan='2'>Question {$i}: {$data1['QuestionName']}</th></tr>";
                echo "<tr><td>Correct Answer</td><td>Student's Answer</td></tr>";

                // Fetch the correct answer dynamically
                $correctAnswer = $data1['CorrectAnswer'];  // Assuming CorrectAnswer stores the correct option (choiceA, choiceB, etc.)
                
                // Display the correct answer
                echo "<tr><td>{$data1[$correctAnswer]}</td><td>";

                // Check if the student's answer is correct
                if ($studentAnswers == $data1[$correctAnswer]) {
                    echo "<span class='correct'>$studentAnswers</span>";
                    $remarks = 'CORRECT';
                } else {
                    echo "<span class='incorrect'>$studentAnswers</span>";
                    $remarks = 'WRONG';
                }

                echo "</td></tr></table>";

                // Insert the result into the result table
                $select_inst2 = "INSERT INTO result (QuizID, QuestionID, Choice, Remarks, StudentID) VALUES (?, ?, ?, ?, ?)";
                $execute2 = mysqli_prepare($conn, $select_inst2);
                mysqli_stmt_bind_param($execute2, "sssss", $quizID, $data['QuestionID'], $studentAnswers, $remarks, $_SESSION['StudentID']);
                mysqli_stmt_execute($execute2);

                // Check for errors in the execution
                if (mysqli_stmt_error($execute2)) {
                    echo "Error: " . mysqli_stmt_error($execute2);
                }

            }

        }

    } else {
        // Redirect to the quiz page if the form is not submitted
        header('Location: answer_question.php');
        exit();
    }

} else {
    // Redirect or handle the case where quizID is not provided
    header('Location: answer_question.php');
    exit();
}

// End HTML output
echo "</body></html>";

// Close database connection
$conn = null;
?>
