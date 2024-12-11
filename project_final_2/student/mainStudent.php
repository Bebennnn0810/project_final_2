<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            background-size: cover;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        hr {
            border: 1px solid #ddd;
            margin: 20px 0;
        }

        h2 {
            text-align: center;
            color: #FFD700;
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
            background-color: #FFD700;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #e0e0e0;
        }

        .select-btn {
            padding: 10px 15px;
            background-color: #FFD700;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
            transition: background-color 0.3s ease;
        }

        .select-btn:hover {
            background-color: #45a049;
        }

    </style>
</head>

<body>
    <?php
    include('../header.php');
    include('studentGuard.php');
    include('../connection.php');

    function score($no_set, $no_quest)
    {
        global $conn;
        $score_inst = "SELECT * FROM quiz, question, result 
            WHERE quiz.quizID=question.quizID 
            AND question.questionID=result.questionID 
            AND quiz.quizID=? 
            AND result.studentID=?";
        
        $stmt = $conn->prepare($score_inst);
        $stmt->bind_param("ss", $no_set, $_SESSION['StudentID']);
        $stmt->execute();
        $execute_score = $stmt->get_result();

        $no_ans = mysqli_num_rows($execute_score);
        $correct = 0;

        while ($record = mysqli_fetch_array($execute_score)) {
            switch ($record['Remarks']) {
                case 'CORRECT':
                    $correct++;
                    break;
                default:
                    break;
            }
        }

        $percentage = $correct / $no_quest * 100;
        echo "<td align='right'>$correct/$no_quest</td>
             <td align='right'>" . number_format($percentage, 0) . "%</td>";
        $collect = $correct . "|" . $no_quest . "|" . $percentage . "|" . $no_ans;
        return $collect;
    }
    ?>
    <table>
        <tr>
            <th>No</th>
            <th>Topic</th>
            <th>No Question</th>
            <th>Score</th>
            <th>Percentage</th>
            <th>Re-Do</th>
            <th>Action</th>
        </tr>
        <?php
        $search_inst = "SELECT * FROM student WHERE StudentID=?";
        $stmt_search = $conn->prepare($search_inst);
        $stmt_search->bind_param("s", $_SESSION['StudentID']);
        $stmt_search->execute();
        $search_execute = $stmt_search->get_result();
        $student_data = mysqli_fetch_array($search_execute);

        $select_work_inst = "SELECT quiz.quizID, COUNT(DISTINCT question.questionID) AS no_question, QuizName 
                        FROM quiz
                        JOIN question ON quiz.QuizID = question.QuizID
                        JOIN lecturer ON quiz.LectID = lecturer.LectID ";

        if (isset($student_data['sectionID'])) {
            $select_work_inst .= "JOIN section ON section.sectionID = '".$student_data['sectionID']."' ";
        }

        $select_work_inst .= "GROUP BY quiz.quizID, QuizName";

        $stmt_work = $conn->prepare($select_work_inst);

        if (isset($student_data['sectionID'])) {
            $stmt_work->bind_param("s", $student_data['sectionID']);
        }

        $stmt_work->execute();
        $exec = $stmt_work->get_result();
        
        $i = 0;
        $res_array =[]; 
        while ($data = mysqli_fetch_array($exec)) {
        $res_array[] = $data;
        echo "<tr>
            <td>" . ++$i . "</td>
            <td>" . (isset($data['QuizName']) ? $data['QuizName'] : 'N/A') . "</td>
            <td align='center'>" . $data['no_question'] . "</td>";

            $collect = score($data['quizID'], $data['no_question']);
            $explode = explode("|", $collect);
            list($correct, $no_quest, $percentage, $no_ans) = $explode;
            
            // Logic for Retake button if quiz was previously attempted
            if ($no_ans > 0) {
                // Show "Retake" option for attempted quizzes
                echo "<td><a class='select-btn' href='exercise_instruction.php?no_set=" . $data['quizID'] . "'>Retake</a></td>";
            } else { 
                // Show "Select" option for unattempted quizzes
                echo "<td><a class='select-btn' href='exercise_instruction.php?no_set=" . $data['quizID'] . "'>Select</a></td>";
            }
            
            // Always show "Revision" option
            echo "<td><a class='select-btn' href='revision.php?no_set=" . $data['quizID'] . "&topic=" . $data['QuizName'] . "&collect=" . $collect . "'>Revision</a></td>";

            echo "</tr>";
        }
        ?>
    </table>
    <?php include('../footer.php'); ?>
</body>

</html>
