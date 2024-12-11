<?php
include('../connection.php');
include('lecturer_header.php');

if (!empty($_POST)) {
    $StudentID = mysqli_real_escape_string($conn, $_POST['StudentID']);
    $FirstName = mysqli_real_escape_string($conn, $_POST['FirstName']);
    $LastName = mysqli_real_escape_string($conn, $_POST['LastName']);
    $email = mysqli_real_escape_string($conn, $_POST['Email']);
    $password = mysqli_real_escape_string($conn, $_POST['Password']);
    $SectionID = $_POST['SectionID'];

    // Validate all fields
    if (empty($StudentID) || empty($FirstName) || empty($LastName) || empty($email) || empty($password) || empty($SectionID)) {
        error_log("Form data missing: StudentID: $StudentID, FirstName: $FirstName, LastName: $LastName, Email: $email, SectionID: $SectionID");
        die("<script>alert('Please complete the information'); window.history.back();</script>");
    }

    // Check if a valid SectionID was selected
    if ($SectionID == 'Select') {
        die("<script>alert('Please select a valid section'); window.history.back();</script>");
    }

    // Check if the email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("<script>alert('Invalid email format'); window.history.back();</script>");
    }

    // Check if the StudentID already exists
    $check_existing = "SELECT StudentID FROM student WHERE StudentID = '$StudentID'";
    $existing_result = mysqli_query($conn, $check_existing);
    if (mysqli_num_rows($existing_result) > 0) {
        die("<script>alert('Student ID already exists.'); window.history.back();</script>");
    }

    // Insert the new student
    $store = "INSERT INTO student (StudentID, FirstName, LastName, Email, Password, SectionID) 
              VALUES ('$StudentID', '$FirstName', '$LastName', '$email', '$password', '$SectionID')";

    if (mysqli_query($conn, $store)) {
        echo "<script>alert('Registration successful.'); window.location.href='student_list.php';</script>";
    } else {
        error_log("MySQL Error: " . mysqli_error($conn));
        echo "<script>alert('Registration failed due to a database error.'); window.history.back();</script>";
    }
}

if (!empty($_GET)) {
    $StudentID = $_GET['StudentID'];
    $FirstName = $_GET['FirstName'];
    $LastName = $_GET['LastName'];
    $email = $_GET['Email'];
    $password = $_GET['Password'];
    $SectionID = $_GET['SectionID'];
    $OriginalStudentID = $_GET['OriginalStudentID'];

    // Validate all fields
    if (empty($StudentID) || empty($FirstName) || empty($LastName) || empty($email) || empty($password) || empty($SectionID) || empty($OriginalStudentID)) {
        error_log("Update form data missing: StudentID: $StudentID, FirstName: $FirstName, LastName: $LastName, Email: $email, SectionID: $SectionID");
        die("<script>alert('Please complete the information.'); window.history.back();</script>");
    }

    // Update student information
    $update = "UPDATE student SET StudentID = '$StudentID', FirstName = '$FirstName', LastName = '$LastName', 
               Email = '$email', Password = '$password', SectionID = '$SectionID'
               WHERE StudentID = '$OriginalStudentID'";

    if (mysqli_query($conn, $update)) {
        echo "<script>alert('Update successful.'); window.location.href='student_list.php';</script>";
    } else {
        error_log("MySQL Error: " . mysqli_error($conn));
        echo "<script>alert('Update failed due to a database error.'); window.history.back();</script>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Student List</title>
    <style>
        /* CSS styles */
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
            width: 90%;
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
    <h3>Student List</h3>

    <table width="100%" border="1">
        <tr>
            <th>StudentID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Password</th>
            <th>SectionID</th>
            <th>Functions</th>
        </tr>

        <?php
        $search_student = "SELECT StudentID, FirstName, LastName, Email, Password, SectionID FROM student ORDER BY LastName ASC";
        $looking_student = mysqli_query($conn, $search_student);

        while ($data = mysqli_fetch_array($looking_student)) {
            $originalStudentID = $data['StudentID'];
            $originalFirstName = $data['FirstName'];
            $originalLastName = $data['LastName'];
            $originalEmail = $data['Email'];
            $originalPassword = $data['Password'];
            $originalSectionID = $data['SectionID'];

            echo "<tr>
            <form action='' method='GET'>
            <td><input type='text' name='StudentID' value='" . $originalStudentID . "'></td>
            <td><input type='text' name='FirstName' value='" . htmlspecialchars($originalFirstName) . "'></td>
            <td><input type='text' name='LastName' value='" . htmlspecialchars($originalLastName) . "'></td>
            <td><input type='text' name='Email' value='" . $originalEmail . "'></td>
            <td><input type='text' name='Password' value='" . $originalPassword . "'></td>
            <td>
                <select name='SectionID'>";

            // Fetch SectionID options from the section table
            $section_query = "SELECT SectionID, SectionName FROM section ORDER BY SectionName ASC";
            $section_result = mysqli_query($conn, $section_query);

            while ($section_data = mysqli_fetch_assoc($section_result)) {
                echo "<option value='" . $section_data['SectionID'] . "' " . ($originalSectionID == $section_data['SectionID'] ? 'selected' : '') . ">" . $section_data['SectionID'] . "</option>";
            }

            echo "</select>
            </td>
            <td>
                <input type='hidden' name='OriginalStudentID' value='" . $originalStudentID . "'>
                <input type='submit' value='Update Student' class='update-btn'>
                <button onclick=\"location.href='lecturer_delete.php?table=student&column=StudentID&pk=" . $originalStudentID . "'\" type='button' class='delete-btn'>Delete Student</button>
            </td>
            </form>
        </tr>";
        }
        ?>

        <tr>
            <form name='add_student' action='' method='post'>
                <td><input type='text' name='StudentID' placeholder='Enter Student ID'></td>
                <td><input type='text' name='FirstName' placeholder='Enter First Name'></td>
                <td><input type='text' name='LastName' placeholder='Enter Last Name'></td>
                <td><input type='text' name='Email' placeholder='Enter Email'></td>
                <td><input type='text' name='Password' placeholder='Enter Password'></td>
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
                <td><input type='submit' value='Add New Student' class='add-btn'></td>
            </form>
        </tr>
    </table>
    <footer style="text-align: center; padding: 10px; background-color: #f4f4f4; color: #333;">
        Copyright © SMK JALAN OYA, SIBU 2024-2025. All Rights Reserved.
    </footer>
</body>

</html>
