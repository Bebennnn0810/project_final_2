<?php
include('lecturer_header.php');
if (!empty($_POST)) {
    $FirstName=mysqli_real_escape_string($conn,$_POST['New_First']);
    $LastName=mysqli_real_escape_string($conn,$_POST['New_Last']);
    $LecturerID=mysqli_real_escape_string($conn,$_POST['New_ID']);
    $email=mysqli_real_escape_string($conn,$_POST['New_Email']);
    $password=mysqli_real_escape_string($conn,$_POST['New_Password']);
    $Position=$_POST['Position'];
    $SectionID=$_POST['SectionID'];
    $SubjectID=$_POST['SubjectID'];

    if (empty($FirstName)||empty($LastName)||empty($LecturerID)||empty($email)||empty($password)||empty($Position)||empty($SectionID)||empty($SubjectID)) {
        die("<script>alert('Please fulfill the details');window.history.back();</script>");
    }
    if (strlen($LecturerID)!=8) {
       die("<script>alert('Invalid Lecturer ID !');window.history.back();</script>");
    }
    
    $arahan_kemaskini = "update lecturer set
    LectID='$LecturerID',
    FirstName= '$FirstName',
    LastName='$LastName',
    Email='$email',
    Password='$password',
    Position = '$Position',
    SectionID = '$SectionID',
    SubjectID = '$SubjectID'
    where
    LectID = '".$_GET['LectID']."'";
    
    if(mysqli_query($conn,$arahan_kemaskini))
    {
        echo "<script>alert('Updated Successfully.');
        window.location.href = 'lecturer_list.php';</script>";
    }
    else
    {
        echo "<script>alert('Failed to Update.');
        window.location.href = 'lecturer_list.php';</script>";
    
    }
}
?>
<h1>Lecturer's List</h1>
<table width='100%' border='1'>
    <tr>
        <td>ID</td>
        <td>First Name</td>
        <td>Last Name</td>
        <td>email</td>
        <td>password</td>
        <td>Position</td>
        <td>Section</td>
        <td>Subject</td>
        <td>Action</td>
    </tr>
    <tr>
        <form action='' method="POST">
            <td><input type='text' name='New_ID' value='<?php echo $_GET['LectID'];  ?>'></td>
            <td><input type='text' name='New_First' value='<?php echo $_GET['FirstName'];  ?>'></td>
            <td><input type='text' name='New_Last' value='<?php echo $_GET['LastName'];  ?>'></td>
            <td><input type='text' name='New_Email' value='<?php echo $_GET['Email'];  ?>'></td>
            <td><input type='password' name='New_Password' value='<?php echo $_GET['Password'];  ?>'></td>
            <td>
                <select name='Position'>
                    <option value selected disabled>Select</option>
                    <option value='ADMIN'>ADMIN</option>
                </select>
            </td>
            <td>
                <select name='SectionID'>
                    <option value selected disable>Select</option>
                    <?php
include 'connection.php';
$sql="SELECT*FROM section";


$execute_search=mysqli_query($conn,$sql);


while ($record=mysqli_fetch_assoc($execute_search)) {
   # code...
   echo"<option value=".$record['SectionID'].">".$record['SectionID']."</option>";
}
?>
                </select>
            </td>
            <td>
                <select name='SubjectID'>
                    <option value selected disable>Select</option>
                    <?php
include 'connection.php';
$sql="SELECT*FROM Subject";


$execute_search=mysqli_query($conn,$sql);


while ($record=mysqli_fetch_array($execute_search)) {
   # code...
   echo"<option value=".$record['SubjectID'].">".$record['subjectName']."".$record['SubjectID']."</option>";
}
?>
                </select>
            </td>
            <td><input type="submit" value="Update"></td>
        </form>
    </tr>
    <?php
    $search_lect="SELECT * FROM LECTURER ORDER BY Position ASC";
    $execute_search=mysqli_query($conn,$search_lect);
    while ($data=mysqli_fetch_assoc($execute_search)) {
        # code...
        $data_lect=array(
            'LectID' => $data['LectID'],
            'FirstName' => $data['FirstName'],
            'LastName' => $data['LastName'],
            'Email' => $data['Email'],
            'Password' => $data['Password']
        );
        echo " <tr>
        <td>".$data['LectID']."</td>
        <td>".$data['FirstName']."</td>
        <td>".$data['LastName']."</td>
        <td>".$data['Email']."</td>
        <td>".$data['Password']."</td>
        <td>".$data['Position']."</td>
        <td>".$data['SectionID']."</td>
        <td>".$data['SubjectID']."</td>
        <td>
        | <a href='lecturer_update.php?".http_build_query($data_lect)."'>Update</a>
        | <a href='delete.php?table=lecturer&column=LectID&pk=".$data['LectID']."'>Delete</a>|
        </td>
        </tr>";
    }

    ?>
</table>

<?php include('lecturer_footer.php'); ?>
