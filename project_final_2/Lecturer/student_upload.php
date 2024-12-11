<?php
include ('lecturer_header.php');
?>

<h2>Import Student Data</h2>

<form action="" method="post" action="student_upload.php" enctype="multipart/form-data">
    Fail CSV: <br>
    <input type="file" name="file" required />
    <button type="submit" name="btn-upload">Upload</button>
</form>

<table width="40%">
    <tr>
        <td>For importing student data, Make sure you are using the correct template. Download <a href="studentData.CSV">HERE</a></td>
    </tr>
</table>

<?php
include('../connection.php');

if(isset($_POST['btn-upload'])) {
    $temptFile = $_FILES['file']['tmp_name'];
    $fileName = $_FILES['file']['name'];
    $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

    if ($_FILES['file']['size'] > 0 && strcasecmp($fileType, "csv") === 0) {
        $fileUpload = fopen($temptFile, "r");
        $counter = 1;
        $success = 0;
        $totalData = 0;

        while (($data = fgetcsv($fileUpload, 10000, ",")) !== false) {
            $StudentID = mysqli_real_escape_string($conn, $data[0]);
            $FirstName = mysqli_real_escape_string($conn, $data[1]);
            $LastName = mysqli_real_escape_string($conn, $data[2]);
            $Email = mysqli_real_escape_string($conn, $data[3]);
            $Password = mysqli_real_escape_string($conn, $data[4]);
            $SectionID = mysqli_real_escape_string($conn, $data[5]);

            if ($counter > 1) {
                $store = "INSERT INTO student (StudentID, FirstName, LastName, Email, Password, SectionID)
                VALUES ('$StudentID', '$FirstName', '$LastName', '$Email', '$Password', '$SectionID')";

                if (mysqli_query($conn, $store)) {
                    $success++;
                }
            }
            $totalData++;
            $counter++;    
        }
        fclose($fileUpload);
    } else {
        echo "<script>alert('Only CSV format files are allowed');</script>";
    }

    if ($success > 0) {
        echo "<script>alert('Data file import complete. $success data saved successfully');
        window.location.href = 'student_list.php';</script>";
    } else {
        echo "<script>alert('Data file import failed. $success data saved successfully');
        window.location.href = 'student_upload.php';</script>";
    }
} else {
   
}

?>
