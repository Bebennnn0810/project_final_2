<?php
include('../connection.php');
include('lecturer_header.php');

if (!empty($_POST)) {
    $SectionID = mysqli_real_escape_string($conn, $_POST['SectionID']);
    $SectionName = mysqli_real_escape_string($conn, $_POST['SectionName']);

    if (empty($SectionID) or empty($SectionName)) {
        die("<script>alert('Please complete the information'); window.history.back();</script>");
    }

    $store = "INSERT INTO section (SectionID, SectionName) VALUES ('$SectionID', '$SectionName')";

    if (mysqli_query($conn, $store)) {
        echo "<script>alert('Registration successful.'); window.location.href='section_list.php';</script>";
    } else {
        echo "<script>alert('Registration failed.'); window.location.href='section_list.php';</script>";
    }
}

if (!empty($_GET)) {
    $SectionID = $_GET['SectionID'];
    $SectionName = $_GET['SectionName'];
    $OriginalSectionID = $_GET['OriginalSectionID'];

    if (empty($SectionID) || empty($SectionName) || empty($OriginalSectionID)) {
        die("<script>alert('Please complete the information.'); window.history.back();</script>");
    }

    $update = "UPDATE section SET SectionID = '$SectionID', SectionName = '$SectionName'
               WHERE SectionID = '$OriginalSectionID'";

    if (mysqli_query($conn, $update)) {
        echo "<script>alert('Update successful.'); window.location.href='section_list.php';</script>";
    } else {
        echo "<script>alert('Update failed.'); window.location.href='section_list.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Section and Lecturer List</title>
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
            /* Darker blue */
        }

        .delete-btn:hover {
            background-color: #cc0000;
            /* Darker red */
        }

        .add-btn:hover {
            background-color: #45a049;
            /* Darker green */
        }

    </style>
</head>

<body>
    <h3>Section List</h3>

    <table width="100%" border="1">
        <tr>
            <th>SectionID</th>
            <th>Section Name</th>
            <th>Functions</th>
        </tr>

        <?php
        $search_section = "SELECT SectionID, SectionName FROM section ORDER BY SectionName ASC";
        $looking_section = mysqli_query($conn, $search_section);

        while ($data = mysqli_fetch_array($looking_section)) {
            $originalSectionID = $data['SectionID'];
            $originalSectionName = $data['SectionName'];

            echo "<tr>
            <form action='' method='GET'>
            <td><input type='text' name='SectionID' value='" . $originalSectionID . "'></td>
            <td><input type='text' name='SectionName' value='" . htmlspecialchars($originalSectionName) . "'></td>
            <td>
                <input type='hidden' name='OriginalSectionID' value='" . $originalSectionID . "'>
                <input type='submit' value='Update Section' class='update-btn'>
                <button onclick=\"location.href='lecturer_delete.php?table=section&column=SectionID&pk=" . $originalSectionID . "'\" type='button' class='delete-btn'>Delete Section</button>
            </td>
            </form>
        </tr>";
        }
        ?>
        <tr>
            <form name="add_section" action="" method="post">
                <td><input type="text" name="SectionID" placeholder='Enter Section ID'></td>
                <td><input type="text" name="SectionName" placeholder='Enter Section Name'></td>
                <td><input type="submit" value="Add New Section" class='add-btn'></td>
            </form>
        </tr>
    </table>
    <footer style="text-align: center; padding: 10px; background-color: #f4f4f4; color: #333;">
        Copyright © SMK JALAN OYA, SIBU 2024-2025. All Rights Reserved.
    </footer>
</body>

</html>
