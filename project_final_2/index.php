<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url(https://i.ytimg.com/vi/W8U2O1bRKHQ/maxresdefault.jpg);
            color: #fff;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        td {
            background-color: #333;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
        }

        h3 {
            text-align: center;
            color: #fff;
        }

        form {
            text-align: center;
        }

        input[type="text"],
        input[type="password"] {
            width: 90%;
            padding: 10px;
            margin-bottom: 15px;
            border: none;
            border-radius: 5px;
            background-color: #444;
            color: #fff;
        }

        input[type="radio"] {
            margin-right: 5px;
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

        a {
            color: #007bff;
        }

    </style>
</head>


<body>

    <table width='450px'>
        <tr>
            <td align='center' width='100%'>
                <h3>LOGIN</h3>
                <form action='signIn.php' method='POST'>
                    ID: <input type='text' name='matricNo' placeholder='AA221123'><br>
                    Password : <input type='password' name='password' placeholder='Enter password'><br>
                    <input type='radio' name='type' value='student' checked> Student
                    <input type='radio' name='type' value='lecturer'> Teacher <br>
                    <input type='submit' value='Login'>
                </form>
                New Student? <a href='signup.php'>Sign up</a>
            </td>
        </tr>
    </table>
</body>

</html>