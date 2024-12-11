<?php
include ('connection.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST'&& isset($_POST['num_questions'])) {
    // Retrieve form data
    echo '<form action="lecturer_quiz.php" method="post">';
    $num_questions = $_POST['num_questions'];
        for ($i = 1; $i <= $_POST['num_questions']; $i++) {
        echo '<label for="question'.$i.'">Question '.$i.':</label>';
        echo '<input type="text" name="question'.$i.'" required>';
        echo '<br>';

        echo '<label for="optionA'.$i.'">Option A:</label>';
        echo '<input type="text" name="optionA'.$i.'" required>';
        echo '<br>';

        echo '<label for="optionB'.$i.'">Option B:</label>';
        echo '<input type="text" name="optionB'.$i.'" required>';
        echo '<br>';

        echo '<label for="optionC'.$i.'">Option C:</label>';
        echo '<input type="text" name="optionC'.$i.'" required>';
        echo '<br>';

        echo '<label for="correct_option'.$i.'">Correct Option (A-D):</label>';
        echo '<input type="text" name="correct_option'.$i.'" pattern="[A-D]" required>';
        echo '<br>';
    }
    echo '<input type="submit" value="Create Quiz">';
    echo '</form>';
}
?>
