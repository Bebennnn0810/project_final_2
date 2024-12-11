<?php
include('lecturer_header.php');
?>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f9f9f9;
        background-size: cover;
        margin: 0;
        padding: 0;
    }

    hr {
        border: 1px solid #ddd;
        margin: 20px 0;
    }

    h2 {
        text-align: center;
        color: #333;
    }

    table {
        width: 80%;
        margin: 20px auto;
        /* Center the table */
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

</style>


<title>Lecturer Page</title>
<h2>Assigned Quizzes</h2>

<table>
    <tr>
        <th>Topic</th>
        <th>Subject</th>
        <th>Section</th>
        <th>Teacher Name</th>
        <th>Time</th>
        <th>Date</th>
    </tr>

    <?php
    $instruction = "SELECT * FROM quiz, lecturer, section, subject
    WHERE quiz.LectID=lecturer.LectID AND lecturer.sectionID=section.sectionID AND lecturer.subjectID=subject.subjectID ORDER BY quiz.Date";
    $execute = mysqli_query($conn, $instruction);

    while ($record = mysqli_fetch_array($execute)) {
        echo "
        <tr>
            <td>" . $record['QuizName'] . "</td>
            <td>" . $record['SubjectName'] . "</td>
            <td>" . $record['SectionName'] . "</td>
            <td>" . $record['FirstName'] . "</td>
            <td>" . $record['Time'] . "</td>
            <td>" . $record['Date'] . "</td>
        </tr>";
    }
    ?>
</table>

<?php include('lecturer_footer.php'); ?>
