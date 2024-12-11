<?php
include('connection.php');

// If the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $StudentID = $_POST["StudentID"];
    $FirstName = $_POST["FirstName"];
    $LastName = $_POST["LastName"];
    $Email = $_POST["Email"];
    $Password = $_POST["Password"];
    $SectionID = $_POST["SectionID"];

    // Insert data into the database
    $sql = "INSERT INTO Student (StudentID,FirstName, LastName, Email, Password,SectionID) VALUES ('$StudentID','$FirstName','$LastName', '$Email', '$Password','$SectionID')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Registered Successfully');window.location.href='index.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('https://cdn.wallpapersafari.com/68/69/Dj0ObA.jpg');
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;

        }

        h3 {
            text-align: center;
            color: #fff;
        }

        form {
            background-color: #333;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
            width: 20%;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input,
        select {
            width: 80%;
            padding: 10px;
            margin-bottom: 15px;
            border: none;
            border-radius: 5px;
            background-color: #444;
            color: #fff;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

    </style>
</head>

<body>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <h3>SIGN UP</h3>
        <label for="StudentID" style="color: white;">StudentID:</label>
        <input type="text" name="StudentID" required placeholder='AA221133'>
        <br>
        <label for="FirstName" style="color: white;">First Name:</label>
        <input type="text" name="FirstName" required placeholder='First Name'>
        <br>
        <label for="LastName" style="color: white;">LastName:</label>
        <input type="text" name="LastName" required placeholder='Last Name'>
        <br>

        <label for="Email" style="color: white;">Email:</label>
        <input type="email" name="Email" required placeholder='Enter email'>
        <br>

        <label for="Password" style="color: white;">Password:</label>
        <input type="password" name="Password" required placeholder='Enter Password'>
        <br>

        <label for="SectionID">Section:</label>
        <select name='SectionID' style="width:100%">
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
        <br>

        <input type="submit" value="Sign Up"><br>
        Already have an? <a href='index.php'>Sign in</a>
    </form>

</body>

</html>
