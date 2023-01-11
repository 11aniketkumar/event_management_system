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

if(isset($_POST["submit"])){
    $heading = $_POST["heading"];
    $details = $_POST["details"];
    $datetime = $_POST["datetime"];
    $photo = $_FILES["photo"]["name"];
    $event_type = $_POST["event_type"];

    include 'connection.php';

    $target = "Data/".basename($photo);
    move_uploaded_file($_FILES["photo"]["tmp_name"], $target);

    $query = "INSERT INTO events (HEADING, DETAILS, DATE, PHOTO, TYPE, COORDINATOR) VALUES ('$heading', '$details','$datetime', '$photo','$event_type', '$SNO');";
    if(mysqli_query($con, $query)){
        $last_id = mysqli_insert_id($con);
        $new_photo_name = $last_id . ".jpg";
        rename("Data/".$photo, "Data/".$new_photo_name);
        $update_query = "UPDATE events SET PHOTO='$new_photo_name' WHERE SNO='$last_id'";
        mysqli_query($con, $update_query);
        echo "<script>alert('Event added successfully!');</script>";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($con);
    }
    mysqli_close($con);
}
?>

<html>
<head>
    <title>Create</title>
    <link rel = "stylesheet" href="coordinator_design.css">
</head>
<body>
    <div id="container">
        <div id="sidebar">
            <h1>System</h1><br>
            <ul>
                <li><a href="coordinator_portal.php" class="btn">Home</a></li>
                <li><a href="#" class="btn active">New Event</a></li>
                <form method="get">
                <li><input class="btn" type="submit" name="logout" value="Log Out"></li>
                </form>
            </ul>
        </div>
        <div id="page">
            <form method="post" enctype="multipart/form-data">
                <div id="form_design">
                    <div class="column1">
                        <div> <label for="heading">Event Heading:</label></div>
                        <div><label for="event_type">Event Type:</label></div>
                        <div><label for="photo">Upload Photo:</label></div>
                        <div><label for="datetime">Date and Time:</label></div>
                        <div><label for="details">Details:</label></div>
                    </div>
                    <div class = "column2">
                        <div><input type="text" id="heading" name="heading" placeholder="Enter event heading..." required><br></div>
                        <div>
                            <select id="event_type" name="event_type" required>
                                <option value="" disabled selected>Select an event type</option>
                                <option value="Tech Event">Tech Event</option>
                                <option value="Workshop">Workshop</option>
                                <option value="Technical Talks">Technical Talks</option>
                                <option value="Paper Presentation">Paper Presentation</option>
                                <option value="Gaming">Gaming</option>
                                <option value="Other">Other</option>
                            </select><br>
                        </div>
                        <div><input type="file" id="photo" name="photo" accept="image/*" required><br></div>
                        <div><input type="datetime-local" id="datetime" name="datetime" required><br></div>
                        <div><textarea id="details" name="details" rows="5" cols="30" placeholder="Enter event details..." maxlength="500" required></textarea><br></div>
                    </div>
                </div>
                    <input class = "submit_btn" type="submit" value="Submit" name="submit">
            </form>
        </div>
    </div>
</body>
</html>