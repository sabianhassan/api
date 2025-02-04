<?php
include 'Database.php';

$room_name = $_POST['room_name'];
$room_type = $_POST['room_type'];
$capacity = $_POST['capacity'];
$status = $_POST['status'];

$sql = "INSERT INTO rooms (room_name, room_type, capacity, status) VALUES ('$room_name', '$room_type', '$capacity', '$status')";
if ($conn->query($sql) === TRUE) {
    header("Location: index.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>