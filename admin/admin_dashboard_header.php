<?php
session_start();
// Check if admin is logged in; if not, redirect to the login page.
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Panel</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .sidebar {
      background: #343a40;
      padding: 15px;
      min-height: 100vh;
      color: #fff;
    }
    .sidebar a {
      color: #fff;
      text-decoration: none;
      display: block;
      padding: 8px;
    }
    .sidebar a:hover {
      background: #495057;
    }
    .content {
      padding: 20px;
    }
  </style>
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar Navigation -->
      <nav class="col-md-2 sidebar">
        <h4 class="text-center">Admin Panel</h4>
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="manage_users.php">Manage Users</a>
        <a href="manage_rooms.php">Manage Rooms</a>
        <a href="manage_packages.php">Manage Packages</a>
        <a href="manage_booking.php">Manage Bookings</a>
        <a href="admin_logout.php">Logout</a>
      </nav>
      <!-- Main Content -->
      <main class="col-md-10 content">
