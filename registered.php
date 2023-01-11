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

if(isset($_GET["un_register"])){
    $heading = $_GET["event"];
    $SNO = $_SESSION['sno'];
    $file = "Data/" . $heading . ".txt";
    $temp_file = "Data/temp.txt";

    $handle = fopen($file, "r");
    $temp_handle = fopen($temp_file, "w");
    while (($line = fgets($handle)) !== false) {
        $line = trim($line);
        if($line != $SNO){
            fwrite($temp_handle, $line . "\n");
        }
    }
    fclose($handle);
    fclose($temp_handle);
    unlink($file);
    rename($temp_file, $file);
    echo "<script>alert('You have un-registered successfully!')</script>";
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
                <li><a href="portal.php" class="btn">Home</a></li>
                <li><a href="#" class="btn">Registered</a></li>
                <li><a href="#" class="btn">Feedback</a></li>
                <form method="get">
                <li><input class="btn" type="submit" name="logout" value="Log Out"></li>
                </form>
            </ul>
        </div>
        <div id="page">
        <?php 
            include 'connection.php';
            $SNO = $_SESSION['sno']; //get the student sno from session

            $query = "SELECT * FROM events";
            $result = mysqli_query($con, $query);
            while($row = mysqli_fetch_array($result)){
                $event_date = strtotime($row['DATE']);
                $current_date = time();
                $days_remaining = floor(($event_date - $current_date) / 86400);
                $file = "Data/" . $row['SNO'] . ".txt";
                if(file_exists($file)){
                    $handle = fopen($file, "r");
                    while (($line = fgets($handle)) !== false) {
                        $line = trim($line);
                        if($line == $SNO){
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
                    <input type="submit" value="UN-Register" class = "register_btn" name="un_register">
                </form>
            </div>
        <?php
                        }
                    }
                }
            }
            mysqli_close($con);
        ?>
        </div>
    </div>
</body>
</html>