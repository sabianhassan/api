<?php
include 'Database.php';

$id = $_POST['id'];
$room_name = $_POST['room_name'];
$room_type = $_POST['room_type'];
$capacity = $_POST['capacity'];
$status = $_POST['status'];

$sql = "UPDATE rooms SET room_name='$room_name', room_type='$room_type', capacity='$capacity', status='$status' WHERE id='$id'";
if ($conn->query($sql) === TRUE) {
    header("Location: index.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>