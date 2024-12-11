<?php
include('lecturer_header.php');
if (!empty($_POST)) {
    $FirstName=mysqli_real_escape_string($conn,$_POST['New_First']);
    $LastName=mysqli_real_escape_string($conn,$_POST['New_Last']);
    $StudentID=mysqli_real_escape_string($conn,$_POST['New_ID']);
    $email=mysqli_real_escape_string($conn,$_POST['New_Email']);
    $password=mysqli_real_escape_string($conn,$_POST['New_Password']);
    $SectionID=$_POST['SectionID'];

    if (empty($FirstName)||empty($LastName)||empty($StudentID)||empty($email)||empty($password)||empty($SectionID)) {
        die("<script>alert('Please fulfill the details');window.history.back();</script>");
    }
    if (strlen($StudentID)!=8) {
       die("<script>alert('Invalid Student ID !');window.history.back();</script>");
    }
    $arahan_kemaskini = "update Student set
    StudentID='$StudentID',
    FirstName= '$FirstName',
    LastName='$LastName',
    Email='$email',
    Password='$password',
    SectionID = '$SectionID'
    where
    StudentID = '".$_GET['StudentID']."'";
    
    if(mysqli_query($conn,$arahan_kemaskini))
    {
        echo "<script>alert('Updated Successfully.');
        window.location.href = 'student_list.php';</script>";
    }
    else
    {
        echo "<script>alert('Failed to Update.');
        window.location.href = 'student_list.php';</script>";
    
    }
   
}
?> 
<h1>Student's List</h1>
<a href='student_upload.php'>[+] Upload Student's Data</a>
<br>
<table width='100%' border='1'>
    <tr>
        <td>ID</td>
        <td>First Name</td>
        <td>Last Name</td>
        <td>email</td>
        <td>password</td>
        <td>Section</td>
        <td>Action</td>
    </tr>
    <tr>
        <form action='' method="POST">
            <td><input type='text' name='New_ID' value='<?php echo $_GET['StudentID']; ?>'></td>
            <td><input type='text' name='New_First' value='<?php echo $_GET['FirstName']; ?>'></td>
            <td><input type='text' name='New_Last' value='<?php echo $_GET['LastName']; ?>'></td>
            <td><input type='text' name='New_Email' value='<?php echo $_GET['Email']; ?>'></td>
            <td><input type='password' name='New_Password' value='<?php echo $_GET['Password']; ?>'></td>
            <td>
             <select name='SectionID'>
<option value selected disable>Select</option>
<?php
include 'connection.php';
$sql="SELECT*FROM section";


$execute_search=mysqli_query($conn,$sql);


while ($record=mysqli_fetch_assoc($execute_search)) {
   # code...
   echo"<option value=".$record['SectionID'].">".$record['SectionName']."".$record['SectionID']."</option>";
}
?>
</select>
</td>
<td><input type="submit" value="Update"></td>
</form>
    </tr>
    <?php
    $search_stu="SELECT * FROM STUDENT,SECTION WHERE Student.SectionID=Section.SectionID ORDER BY Student.FirstName,Section.SectionID ASC";
    $execute_search=mysqli_query($conn,$search_stu);
    while ($data=mysqli_fetch_assoc($execute_search)) {
        # code...
        $data_stu=array(
            'StudentID' => $data['StudentID'],
            'FirstName' => $data['FirstName'],
            'LastName' => $data['LastName'],
            'Email' => $data['Email'],
            'Password' => $data['Password']
        );
        echo " <tr>
        <td>".$data['StudentID']."</td>
        <td>".$data['FirstName']."</td>
        <td>".$data['LastName']."</td>
        <td>".$data['Email']."</td>
        <td>".$data['Password']."</td>
        <td>".$data['SectionID']."".$data['SectionName']."</td>
        <td>
        | <a href='student_update.php?".http_build_query($data_stu)."'>Update</a>
        | <a href='lecturer_delete.php?table=student&column=StudentID&pk=".$data['StudentID']."'onClick=\"return confirm ('Are you sure ?')\">Delete</a>|
        </td>
        </tr>";
    }

    ?>
    </table>