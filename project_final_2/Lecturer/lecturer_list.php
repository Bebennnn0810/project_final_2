<?php
// Include the database connection and header
include('../connection.php');
include('lecturer_header.php');

// Check if the form is submitted for adding a new lecturer
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['OriginalLectID'])) {
    // Collect form data for adding new lecturer
    $LectID = mysqli_real_escape_string($conn, $_POST['LectID']);
    $FirstName = mysqli_real_escape_string($conn, $_POST['FirstName']);
    $LastName = mysqli_real_escape_string($conn, $_POST['LastName']);
    $Email = mysqli_real_escape_string($conn, $_POST['Email']);
    $Password = mysqli_real_escape_string($conn, $_POST['Password']);
    $Position = mysqli_real_escape_string($conn, $_POST['Position']);
    $SectionID = mysqli_real_escape_string($conn, $_POST['SectionID']);
    $SubjectID = mysqli_real_escape_string($conn, $_POST['SubjectID']);

    // Validate input
    if (empty($LectID) || empty($FirstName) || empty($LastName) || empty($Email) || empty($Password) || empty($Position) || empty($SectionID) || empty($SubjectID)) {
        echo "<script>alert('Please complete all the information.'); window.history.back();</script>";
        exit();
    }

    // Insert the new lecturer into the database
    $insert = "INSERT INTO lecturer (LectID, FirstName, LastName, Email, Password, Position, SectionID, SubjectID)
                VALUES ('$LectID', '$FirstName', '$LastName', '$Email', '$Password', '$Position', '$SectionID', '$SubjectID')";

    if (mysqli_query($conn, $insert)) {
        echo "<script>alert('New Lecturer added successfully.'); window.location.href='lecturer_list.php';</script>";
        exit();
    } else {
        $error = mysqli_error($conn);
        echo "<script>alert('Insert failed: $error'); window.history.back();</script>";
        exit();
    }
}

// Check if the form is submitted for updating an existing lecturer
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['OriginalLectID'])) {
    // Collect form data for update
    $LectID = mysqli_real_escape_string($conn, $_POST['LectID']);
    $FirstName = mysqli_real_escape_string($conn, $_POST['FirstName']);
    $LastName = mysqli_real_escape_string($conn, $_POST['LastName']);
    $Email = mysqli_real_escape_string($conn, $_POST['Email']);
    $Password = mysqli_real_escape_string($conn, $_POST['Password']);
    $Position = mysqli_real_escape_string($conn, $_POST['Position']);
    $SectionID = mysqli_real_escape_string($conn, $_POST['SectionID']);
    $SubjectID = mysqli_real_escape_string($conn, $_POST['SubjectID']);
    $OriginalLectID = mysqli_real_escape_string($conn, $_POST['OriginalLectID']);

    // Validate input
    if (empty($LectID) || empty($FirstName) || empty($LastName) || empty($Email) || empty($Password) || empty($Position) || empty($SectionID) || empty($SubjectID)) {
        echo "<script>alert('Please complete all the information.'); window.history.back();</script>";
        exit();
    }

    // Update data in the database
    $update = "UPDATE lecturer SET 
                LectID = '$LectID', 
                FirstName = '$FirstName', 
                LastName = '$LastName', 
                Email = '$Email', 
                Password = '$Password', 
                Position = '$Position', 
                SectionID = '$SectionID', 
                SubjectID = '$SubjectID' 
                WHERE LectID = '$OriginalLectID'";

    if (mysqli_query($conn, $update)) {
        echo "<script>alert('Lecturer updated successfully.'); window.location.href='lecturer_list.php';</script>";
        exit();
    } else {
        $error = mysqli_error($conn);
        echo "<script>alert('Update failed: $error'); window.history.back();</script>";
        exit();
    }
}

// Get existing lecturers for display
$lecturers_query = "SELECT * FROM lecturer ORDER BY LastName ASC";
$lecturers_result = mysqli_query($conn, $lecturers_query);

if (!$lecturers_result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Lecturer List</title>
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
            width: 95%;
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
        select {
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
    <h3>Educator List</h3>

    <table width="100%" border="1">
        <tr>
            <th>TeacherID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Password</th>
            <th>Position</th>
            <th>SectionID</th>
            <th>SubjectID</th>
            <th>Functions</th>
        </tr>

        <?php
        while ($data = mysqli_fetch_array($lecturers_result)) {
            echo "<tr>
                <form action='' method='POST'>
                    <td><input type='text' name='LectID' value='" . htmlspecialchars($data['LectID']) . "' readonly></td>
                    <td><input type='text' name='FirstName' value='" . htmlspecialchars($data['FirstName']) . "'></td>
                    <td><input type='text' name='LastName' value='" . htmlspecialchars($data['LastName']) . "'></td>
                    <td><input type='text' name='Email' value='" . htmlspecialchars($data['Email']) . "'></td>
                    <td><input type='text' name='Password' value='" . htmlspecialchars($data['Password']) . "'></td>
                    <td><input type='text' name='Position' value='" . htmlspecialchars($data['Position']) . "'></td>
                    <td><input type='text' name='SectionID' value='" . htmlspecialchars($data['SectionID']) . "'></td>
                    <td><input type='text' name='SubjectID' value='" . htmlspecialchars($data['SubjectID']) . "'></td>
                    <td>
                        <input type='hidden' name='OriginalLectID' value='" . htmlspecialchars($data['LectID']) . "'>
                        <input type='submit' value='Update' class='update-btn'>
                        <button onclick=\"location.href='lecturer_delete.php?table=lecturer&column=LectID&pk=" . htmlspecialchars($data['LectID']) . "'\" type='button' class='delete-btn'>Delete</button>
                    </td>
                </form>
            </tr>";
        }
        ?>

        <tr>
            <form name="add_lecturer" action="" method="post">
                <td><input type="text" name="LectID" placeholder='Enter Teacher ID'></td>
                <td><input type="text" name="FirstName" placeholder='Enter first name'></td>
                <td><input type="text" name="LastName" placeholder='Enter last name'></td>
                <td><input type="text" name="Email" placeholder='Enter email'></td>
                <td><input type="text" name="Password" placeholder='Enter password'></td>
                <td><input type="text" name="Position" placeholder='Enter position'></td>
                <td>
                    <select name='SectionID'>
                        <option>Select</option>
                        <?php
                        // Fetch SectionID options from the section table for the new record form
                        $section_query = "SELECT SectionID, SectionName FROM section ORDER BY SectionName ASC";
                        $section_result = mysqli_query($conn, $section_query);

                        while ($section_data = mysqli_fetch_assoc($section_result)) {
                            echo "<option value='" . $section_data['SectionID'] . "'>" . $section_data['SectionID'] . "</option>";
                        }
                        ?>
                    </select>
                </td>
                <td><input type="text" name="SubjectID" placeholder='Enter subject'></td>
                <td><input type="submit" value="Add New Teacher" class='add-btn'></td>
            </form>
        </tr>
    </table>
    <footer style="text-align: center; padding: 10px; background-color: #f4f4f4; color: #333;">
        Copyright © SMK JALAN OYA, SIBU 2024-2025. All Rights Reserved.
    </footer>
</body>

</html>
