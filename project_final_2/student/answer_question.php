<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Questions</title>
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

        form {
            margin: 20px;
        }

        table {
            border-collapse: collapse;
            width: 50%;
            margin: 20px auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table,
        td {
            border: 1px solid #ddd;
        }

        td {
            padding: 12px;
            text-align: left;
        }

        label {
            margin-right: 10px;
        }

        input[type="radio"] {
            margin-right: 5px;
        }

        button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

    </style>
</head>

<body>
    <?php
    include('../header.php');
    include('../connection.php');
    if (empty($_GET)) {
        die ("<script>alert('Unauthorized Access');window.location.href='mainStudent.php';</script>");
    }
    ?>
    <h3>Questions</h3>
    <hr>
    <form name='quiz_quest' action='check_answer_2.php?quizID=<?php echo $_GET['quizID']; ?>' method='POST' onsubmit="return validateForm();">
        <table border='1' width='50%'>
            <tr>
                <td>No</td>
                <td>Question</td>
            </tr>
            <?php
            $select_inst = "SELECT * FROM question WHERE QuizID='" . $_GET['quizID'] . "'ORDER BY rand()";
            $execute = mysqli_query($conn, $select_inst);
            $i = 0;
            while ($data = mysqli_fetch_array($execute)) {
                echo "<tr>
                    <td>" . ++$i . "</td>
                    <td>";
                $a = array("choiceA", "choiceB", "choiceC", "choiceD");
                shuffle($a);
                $xans = 'Didnt Answered';

                echo $question = str_replace("'", " ", $data['QuestionName']);
                echo "<br>

                    <input type='radio' name=" . $data['QuestionID'] . " value='" . $data[$a[0]] . "'><label>" . $data[$a[0]] . "</label><br>
                    <input type='radio' name=" . $data['QuestionID'] . " value='" . $data[$a[1]] . "'><label>" . $data[$a[1]] . "</label><br>
                    <input type='radio' name=" . $data['QuestionID'] . " value='" . $data[$a[2]] . "'><label>" . $data[$a[2]] . "</label><br>
                    <input type='radio' name=" . $data['QuestionID'] . " value='" . $data[$a[3]] . "'><label>" . $data[$a[3]] . "</label><br>

                    <br>";
                echo "</td>
                    </tr>";
                echo "<input type='hidden' name='unanswered' value='Didnt answered|didnt answered'>";
            }
            ?>
        </table>

        <button type="submit">Submit</button>

    </form>
    <?php include('../footer.php'); ?>

    <script>
        function validateForm() {
            // Check if any radio button is checked for each question
            <?php
            $questionIDs = array();
            $select_inst = "SELECT QuestionID FROM question WHERE QuizID='" . $_GET['quizID'] . "'ORDER BY rand()";
            $execute = mysqli_query($conn, $select_inst);
            while ($data = mysqli_fetch_array($execute)) {
                $questionIDs[] = $data['QuestionID'];
            }
            ?>

            var questions = <?php echo json_encode($questionIDs); ?>;
            for (var i = 0; i < questions.length; i++) {
                var radios = document.querySelectorAll('input[name="' + questions[i] + '"]:checked');
                if (radios.length === 0) {
                    alert("Please complete the exercise!");
                    return false; // Prevent form submission
                }
            }
            return true; // Allow form submission
        }
    </script>
</body>

</html>
