<?php
if(isset($_POST['signup'])){
    // Collect post variables
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $c_password = $_POST['c_password'];
    $rank = $_POST['rank'];

    if($password == $c_password){

        $hash = password_hash($password, PASSWORD_DEFAULT);
        
        include 'connection.php';
        
        if($rank=='student'){
            $sql = "INSERT INTO student (NAME, EMAIL, PHONE, PASSWORD) VALUES ('$name', '$email', '$phone', '$hash');";
        } else {
            $pin = $_POST['teacher_check'];
            if($pin == "1234"){
                $sql = "INSERT INTO faculty (NAME, EMAIL, PHONE, PASSWORD, RANK) VALUES ('$name', '$email', '$phone', '$hash', '$rank');";
            } else {
                echo "<script>alert('Invalid Pin entered.');
                window.location.href = 'index.php';</script>";
            }
        }

        // Execute the query
        if (mysqli_query($con, $sql)) {
            echo '<script>alert("Account created successfully. Sign In to continue.");</script>';
        } else {
            echo '<script>alert("Sign Up failed. Please try again.");</script>';
        }
        // Close the database connection
        mysqli_close($con);

    } else {
        echo '<script>alert("Password does not match")</script>';
    }
}


if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $rank = $_POST['rank'];

    include 'connection.php';

    if($rank=='student'){
        $sql = "SELECT * FROM student WHERE EMAIL LIKE '$email';";
    } else {
        $sql = "SELECT * FROM faculty WHERE EMAIL LIKE '$email';";
    }

    //running query
    $result = mysqli_query($con, $sql);

    if(mysqli_num_rows($result)>0){
        $data = mysqli_fetch_assoc($result);
        $pass =$data["PASSWORD"];
        if(password_verify($password, $pass)){
            session_start();
            $_SESSION['sno'] = $data["SNO"];
            $_SESSION['email'] = $email;
            $_SESSION['name'] = $data["NAME"];
            $_SESSION['phone'] = $data["PHONE"];

            //taking user to the respective page according to their roles
            if($rank=='student'){
                header("Location: portal.php");
            } else if($rank=='department'){
                header("Location: hod_portal.php");
            } else {
                header("Location: coordinator_portal.php");
            }
            exit();
        } else {
            echo "<script>alert('Invalid password entered.');</script>";
        }
    } else {
        echo "<script>alert('Email not found in the database');</script>";
    }
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech-GO</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="container">
        <div id="login">
            <h1>LOGIN</h1>
            <form class="form_align" method="post">
                <label class="form_label">Email</label> <input class="input_box" type="text" name="email" id="email" maxlength="50" required>
                <label class="form_label">Password</label> <input class="input_box" type="password" name="password" id="password" required>
                <select class="input_box2" name="rank">
                    <option value="student">Student</option>
                    <option value="coordinator">Coordinator</option>
                    <option value="department">Department</option>
                </select>
                <input class="btn2" type="submit" name="login" value="Log In">
            </form>
        </div>
        <div id="signup">
            <h1>SIGN UP</h1>
            <form class="form_align" method="post">
                <input class="input_box2" type="text" name="name" id="name" maxlength="30" placeholder="Enter your Name" required>
                <input class="input_box2" type="text" name="email" id="email" maxlength="50" placeholder="Enter your Email" required>
                <input class="input_box2" type="number" name="phone" id="phone" placeholder="Enter your Phone Number" required>
                <input class="input_box2" type="password" name="password" id="password" placeholder="Enter Password" required>
                <input class="input_box2" type="password" name="c_password" id="c_password" placeholder="Confirm Password" required>
                <select class="input_box2" name="rank" onchange="student_check(this);">
                    <option value="student">Student</option>
                    <option value="coordinator">Coordinator</option>
                    <option value="department">Department</option>
                </select>
                <input class="input_box2" type="password" name="teacher_check" id="teacher_check"  style="display: none;" placeholder="Please insert university pin">
                <input class="btn2" type="submit" name="signup" value="Sign Up">
            </form>
        </div>
    </div>
    <script>
        function student_check(that){
            if(that.value=="student"){
                document.getElementById('teacher_check').style.display = "none";
            } else {
                document.getElementById('teacher_check').style.display = "block";
            }
        }
    </script>
</body>
</html>
