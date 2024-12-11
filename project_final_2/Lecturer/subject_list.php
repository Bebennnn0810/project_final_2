<?php
include('../connection.php');
include('lecturer_header.php');

if (!empty($_POST)) {
    $SubjectID = mysqli_real_escape_string($conn, $_POST['SubjectID']);
    $SubjectName = mysqli_real_escape_string($conn, $_POST['SubjectName']);

    if (empty($SubjectID) || empty($SubjectName)) {
        die("<script>alert('Please complete the information'); window.history.back();</script>");
    }

    $store = "INSERT INTO subject (SubjectID, SubjectName) VALUES ('$SubjectID', '$SubjectName')";

    if (mysqli_query($conn, $store)) {
        echo "<script>alert('Registration successful.'); window.location.href='subject_list.php';</script>";
    } else {
        echo "<script>alert('Registration failed.'); window.location.href='subject_list.php';</script>";
    }
}

if (!empty($_GET)) {
    $SubjectID = $_GET['SubjectID'];
    $SubjectName = $_GET['SubjectName'];
    $OriginalSubjectID = $_GET['OriginalSubjectID'];

    if (empty($SubjectID) || empty($SubjectName) || empty($OriginalSubjectID)) {
        die("<script>alert('Please complete the information.'); window.history.back();</script>");
    }

    $update = "UPDATE subject SET SubjectID = '$SubjectID', SubjectName = '$SubjectName'
               WHERE SubjectID = '$OriginalSubjectID'";

    if (mysqli_query($conn, $update)) {
        echo "<script>alert('Update successful.'); window.location.href='subject_list.php';</script>";
    } else {
        echo "<script>alert('Update failed.'); window.location.href='subject_list.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Subject List</title>
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
        }

        input[type="text"] {
            width: 100%;
            padding: 6px;
            margin: 4px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        input[type="submit"],
        button {
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .update-btn,
        .delete-btn {
            color: #fff;
        }

        .update-btn {
            background-color: #007BFF;
        }

        .delete-btn {
            background-color: #FF0000;
        }

        .add-btn {
            background-color: #4CAF50;
            color: #fff;
        }

        .update-btn:hover {
            background-color: #0056b3;
        }

        .delete-btn:hover {
            background-color: #cc0000;
        }

        .add-btn:hover {
            background-color: #45a049;
        }

    </style>
</head>

<body>
    <h3>Subject List</h3>

    <table width="100%" border="1">
        <tr>
            <th>SubjectID</th>
            <th>Subject Name</th>
            <th>Functions</th>
        </tr>

        <?php
        $search_subject = "SELECT SubjectID, SubjectName FROM subject ORDER BY SubjectName ASC";
        $looking_subject = mysqli_query($conn, $search_subject);

        while ($data = mysqli_fetch_array($looking_subject)) {
            $originalSubjectID = $data['SubjectID'];
            $originalSubjectName = $data['SubjectName'];

            echo "<tr>
            <form action='' method='GET'>
            <td><input type='text' name='SubjectID' value='" . $originalSubjectID . "'></td>
            <td><input type='text' name='SubjectName' value='" . htmlspecialchars($originalSubjectName) . "'></td>
            <td>
                <input type='hidden' name='OriginalSubjectID' value='" . $originalSubjectID . "'>
                <input type='submit' value='Update Subject' class='update-btn'>
                <button onclick=\"location.href='lecturer_delete.php?table=subject&column=SubjectID&pk=" . $originalSubjectID . "'\" type='button' class='delete-btn'>Delete Subject</button>
            </td>
            </form>
        </tr>";
        }
        ?>
        <tr>
            <form name="add_subject" action="" method="post">
                <td><input type="text" name="SubjectID" placeholder='Enter Subject ID'></td>
                <td><input type="text" name="SubjectName" placeholder='Enter Subject Name'></td>
                <td><input type="submit" value="Add New Subject" class='add-btn'></td>
            </form>
        </tr>
    </table>

    <footer style="text-align: center; padding: 10px; background-color: #f4f4f4; color: #333;">
        Copyright © SMK JALAN OYA, SIBU 2024-2025. All Rights Reserved.
    </footer>
</body>

</html>
