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

    include 'connection.php';

    $query = "UPDATE `events` SET `REGISTERED` = `REGISTERED` - 1 WHERE `SNO` = $heading; ";
    mysqli_query($con, $query);
    mysqli_close($con);

    echo "<script>alert('You have un-registered successfully!')</script>";
}

if(isset($_GET["submit_rating"])){
    $rating = $_GET['rating'];
    $heading = $_GET['event'];

    include 'connection.php';

    $query = "SELECT * FROM `events` WHERE `SNO` = $heading ";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    $feedback = $row['FEEDBACK'];

    if($feedback == -1){
        $feedback = $rating;
    }else{
        $feedback = ($feedback + $rating)/2;
    }
    $query = "UPDATE `events` SET `feedback` = '$feedback' WHERE `events`.`SNO` = $heading; ";
    mysqli_query($con, $query);
    mysqli_close($con);
}

?>

<html>
<head>
    <title>Registered</title>
    <link rel = "stylesheet" href="design.css">
</head>
<body>
    <div id="container">
        <div id="sidebar">
            <h1>System</h1><br>
            <ul>
                <li><a href="portal.php" class="btn">Home</a></li>
                <li><a href="#" class="btn active">Registered</a></li>
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
                $no_registered = $row['REGISTERED'];
                $event_status = 0;
                $file = "Data/" . $row['SNO'] . ".txt";
                if(file_exists($file)){
                    $handle = fopen($file, "r");
                    while (($line = fgets($handle)) !== false) {
                        $line = trim($line);
                        if($line == $SNO){
        ?>
            <div id="segment">
                <div class="contain2">
                    <div>
                        <h1 class="s_heading"><?php echo $row['HEADING']; ?></h1>
                    </div>
                    <div>
                        <h2>
                            <?php 
                            if($days_remaining < 0) {
                                $event_status = 1;
                                echo "Event completed!";
                            } else {
                                echo "Days Remaining: ".$days_remaining;
                            }
                            ?>
                        </h2>
                        <h2><?php echo "No of Registration: ".$no_registered;?></h2>
                    </div>
                </div>
                <div class="contain">
                    <div class = "s_data">
                        <div>
                            <h3>| TYPE: <?php echo $row['TYPE']; ?> || RATING: <?php echo $row['FEEDBACK']; ?> |</h3><br>
                            <?php echo $row['DETAILS']; ?>
                        </div>
                        <div> 
                            <?php
                            if($event_status == 1){
                                echo '<form method="get">
                                        <input type="hidden" name="event" value="'.$row['SNO'].'">
                                        <label for="rating">Give Rating:</label>
                                        <select name="rating">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                        <input type="submit" class="register_btn" name="submit_rating" value="Submit">
                                    </form>';
                            }else {
                                echo '<form method="get">';
                                echo '<input type="hidden" name="event" value="' . $row['SNO'] . '">';
                                // Other form elements and fields goes here
                                echo '<input type="submit" value="UN-Register" class="register_btn" name="un_register">';
                                echo '</form>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="s_right">
                        <img class="s_photo" src="<?php echo "Data/".$row['PHOTO']; ?>" alt="this is photo">
                    </div> 
                </div>
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

