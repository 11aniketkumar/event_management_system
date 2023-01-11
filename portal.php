<?php
session_start();
//checking if session already exists
if($_SESSION['sno']){
    $SNO = $_SESSION['sno'];
} else {
    header("Location: index.php");
}

if (isset($_GET['logout'])){
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}

if(isset($_GET["register"])){
    $heading = $_GET["event"];
    $SNO = $_SESSION['sno'];
    $file = "Data/" . $heading . ".txt";
    $student_exist = false;
    if(file_exists($file)){
        $handle = fopen($file, "r");
        while (($line = fgets($handle)) !== false) {
            $line = trim($line);
            if($line == $SNO){
                $student_exist = true;
                break;
            }
        }
        if(!$student_exist){
            $handle = fopen($file, "a");
            fwrite($handle, $SNO . "\n");
            echo "<script>alert('Registration completed successfully!')</script>";
        } else {
            echo "<script>alert('You already have registered for this event!')</script>";
        }
    } else {
        $handle = fopen($file, "w");
        fwrite($handle, $SNO . "\n");
        echo "<script>alert('Registration completed successfully!')</script>";
    }
    fclose($handle);
}


?>

<html>
<head>
    <title>df</title>
    <link rel = "stylesheet" href="design.css">
</head>
<body>
    <div id="container">
        <div id="sidebar">
            <h1>System</h1><br>
            <ul>
                <li><a href="#" class="btn">Home</a></li>
                <li><a href="registered.php" class="btn">Registered</a></li>
                <li><a href="#" class="btn">Feedback</a></li>
                <form method="get">
                <li><input class="btn" type="submit" name="logout" value="Log Out"></li>
                </form>
            </ul>
        </div>
        <div id="page">
        <?php 
            include 'connection.php';

            $query = "SELECT * FROM events";
            $result = mysqli_query($con, $query);
            while($row = mysqli_fetch_array($result)){
                $event_date = strtotime($row['DATE']);
                $current_date = time();
                $days_remaining = floor(($event_date - $current_date) / 86400);
        ?>
            <div id="segment">
                <h1 class="s_heading"><?php echo $row['HEADING']; ?></h1>
                <div class="contain">
                    <div class = "s_data">
                        <?php echo $row['DETAILS']; ?>
                        <h2> <?php echo $days_remaining." days remaining";?></h2>
                    </div>
                    <div class="s_right">
                        <img class="s_photo" src="<?php echo "Data/".$row['PHOTO']; ?>" alt="this is photo">
                    </div> 
                </div> 
                <form method="get">
                    <input type="hidden" name="event" value="<?php echo $row['SNO']; ?>">
                    <input type="submit" value="Register" class = "register_btn" name="register">
                </form>
            </div>
        <?php
            }
            mysqli_close($con);
        ?>
        </div>
    </div>
</body>
</html>