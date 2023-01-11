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
    <title>df</title>
    <link rel = "stylesheet" href="hod_design.css">
</head>
<body>
    <div id="container">
        <div id="sidebar">
            <h1>System</h1><br>
            <ul>
                <li><a href="#" class="btn">Home</a></li>
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
                        <input type="submit" value="Remove" class = "register_btn" name="remove">
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