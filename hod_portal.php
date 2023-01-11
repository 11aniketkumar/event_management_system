<?php
session_start();

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

if(isset($_GET['remove'])) {
    include 'connection.php';
    $sno = $_GET['event'];
    $query = "DELETE FROM events WHERE SNO='$sno'";
    $result = mysqli_query($con, $query);

    if ($result) {
        echo "<script>alert('Event removed successfully!')</script>";
    } else {
        echo "<script>alert('Error removing event!')</script>";
    }
    mysqli_close($con);
}

?>

<html>
<head>
    <title>Home</title>
    <link rel = "stylesheet" href="hod_design.css">
</head>
<body>
    <div id="container">
        <div id="sidebar">
            <h1>System</h1><br>
            <ul>
                <li><a href="#" class="btn">Home</a></li>
                <li><a href="new_event.php" class="btn">New Event</a></li>
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
                $no_registered = $row['REGISTERED'];
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
                            <h3>EVENT TYPE: <?php echo $row['TYPE']; ?></h3><br>
                            <?php echo $row['DETAILS']; ?>
                        </div>
                        <div>
                            <form method="get">
                                <input type="hidden" name="event" value="<?php echo $row['SNO']; ?>">
                                <input type="submit" value="Remove" class = "register_btn" name="remove">
                            </form>
                        </div>
                    </div>
                    <div class="s_right">
                        <img class="s_photo" src="<?php echo "Data/".$row['PHOTO']; ?>" alt="this is photo">
                    </div> 
                </div>
            </div>
        <?php
            }
            mysqli_close($con);
        ?>
        </div>
    </div>
</body>
</html>