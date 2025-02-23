<?php
session_start();
require '../classes/Database.php';

$pdo = connectDatabase(); // Connect to DB

// Get total bookings
$stmt = $pdo->query("SELECT COUNT(*) AS total FROM bookings");
$totalBookings = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

// Get total users
$stmt = $pdo->query("SELECT COUNT(*) AS total FROM users");
$totalUsers = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

/*
 | Most Popular Room Type (join on rooms)
 | Since bookings doesn't have room_type, join with rooms.
*/
$stmt = $pdo->query("
    SELECT r.room_type, COUNT(*) AS total
    FROM bookings b
    JOIN rooms r ON b.room_id = r.room_id
    GROUP BY r.room_type
    ORDER BY total DESC
    LIMIT 1
");
$popularRoom = $stmt->fetch(PDO::FETCH_ASSOC);
$popularRoomType = $popularRoom ? $popularRoom['room_type'] : 'No Data';

/*
 | Most Booked Package 
*/
$stmt = $pdo->query("
    SELECT package, COUNT(*) AS total
    FROM bookings
    GROUP BY package
    ORDER BY total DESC
    LIMIT 1
");
$popularPackage = $stmt->fetch(PDO::FETCH_ASSOC);
$popularPackageType = $popularPackage ? $popularPackage['package'] : 'No Data';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Analytics Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  
  <!-- jsPDF + html2canvas for PDF export -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
  
  <!-- SheetJS for Excel export -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

  <!-- Optional: Your custom CSS file -->
  <link rel="stylesheet" href="../assets/style.css">
  
  <style>
    /* Basic styling for stat boxes */
    .stats {
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
      margin-bottom: 20px;
    }
    .stat-box {
      background: #f1f1f1;
      padding: 15px;
      border-radius: 5px;
      min-width: 200px;
      text-align: center;
      font-weight: bold;
    }
    /* Chart containers */
    .chart-container {
      width: 800px; 
      height: 400px; 
      margin: 0 auto 40px auto; 
      position: relative;
    }
    button {
      margin-right: 10px;
      margin-bottom: 10px;
    }
    /* Back to Dashboard button styling */
    .back-dashboard {
      display: block;
      width: 200px;
      margin: 20px auto;
      text-align: center;
      padding: 10px;
      background-color: #343a40;
      color: #fff;
      text-decoration: none;
      border-radius: 5px;
    }
  </style>
</head>
<body>

  <h2>Analytics Dashboard</h2>

  <!-- Back to Dashboard Button -->
  <a href="admin_dashboard.php" class="back-dashboard">← Back to Dashboard</a>

  <div class="stats">
    <div class="stat-box">Total Bookings: <strong><?= $totalBookings ?></strong></div>
    <div class="stat-box">Total Users: <strong><?= $totalUsers ?></strong></div>
    <div class="stat-box">Most Popular Room: <strong><?= $popularRoomType ?></strong></div>
    <div class="stat-box">Most Booked Package: <strong><?= $popularPackageType ?></strong></div>
  </div>

  <!-- Export Buttons -->
  <button id="exportPdf">Export to PDF</button>
  <button id="exportExcel">Export to Excel</button>

  <!-- Bar Chart: Daily Bookings -->
  <div class="chart-container">
    <canvas id="dailyBookingsChart"></canvas>
  </div>

  <!-- Pie Chart: Room Type Distribution -->
  <div class="chart-container">
    <canvas id="roomTypeChart"></canvas>
  </div>

  <script>
  // 1) BAR CHART for Daily Bookings
  fetch('get_booking_data.php')
    .then(response => response.json())
    .then(data => {
      const ctx = document.getElementById('dailyBookingsChart').getContext('2d');
      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: data.dates,  // e.g. ["2025-01-01", "2025-01-02", ...]
          datasets: [{
            label: 'Bookings Per Day',
            data: data.bookings, // e.g. [10, 15, ...]
            backgroundColor: 'rgba(54, 162, 235, 0.6)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            title: {
              display: true,
              text: 'Daily Bookings Over Time (Bar Chart)',
              font: { size: 16 }
            },
            legend: { display: true }
          },
          scales: {
            x: {
              title: { display: true, text: 'Date' }
            },
            y: {
              beginAtZero: true,
              title: { display: true, text: 'Number of Bookings' },
              ticks: {
                stepSize: 1
              }
            }
          }
        }
      });
    })
    .catch(error => console.error('Error loading daily bookings data:', error));

  // 2) PIE CHART for Room Type Distribution
  fetch('get_room_distribution.php')
    .then(response => response.json())
    .then(data => {
      const ctx2 = document.getElementById('roomTypeChart').getContext('2d');
      new Chart(ctx2, {
        type: 'pie',
        data: {
          labels: data.roomTypes,   // e.g. ["Single", "Double", "Suite"]
          datasets: [{
            label: 'Room Type Distribution',
            data: data.totals,      // e.g. [10, 5, 2]
            backgroundColor: [
              'rgba(255, 99, 132, 0.6)',  // Pink
              'rgba(75, 192, 192, 0.6)',  // Teal
              'rgba(255, 206, 86, 0.6)',  // Yellow
              'rgba(153, 102, 255, 0.6)', // Purple
              'rgba(255, 159, 64, 0.6)'   // Orange
            ],
            borderColor: 'rgba(255,255,255,1)',
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            title: {
              display: true,
              text: 'Room Type Distribution (Pie Chart)',
              font: { size: 16 }
            },
            legend: {
              display: true,
              position: 'right'
            }
          }
        }
      });
    })
    .catch(error => console.error('Error loading room distribution data:', error));

  // 3) Export to PDF using jsPDF + html2canvas
  document.getElementById('exportPdf').addEventListener('click', () => {
    html2canvas(document.body).then(canvas => {
      const imgData = canvas.toDataURL('image/png');
      const { jsPDF } = window.jspdf;
      const doc = new jsPDF('p', 'mm', 'a4');

      doc.text("Hotel Management Analytics", 10, 10);
      doc.addImage(imgData, 'PNG', 10, 20, 190, 160);
      doc.save("analytics_report.pdf");
    });
  });

  // 4) Export to Excel using SheetJS
  document.getElementById('exportExcel').addEventListener('click', () => {
    // Create a hidden table with the stat boxes
    let table = document.createElement("table");
    let stats = document.querySelectorAll('.stat-box');
    stats.forEach(stat => {
      let row = table.insertRow();
      let cell = row.insertCell();
      cell.innerText = stat.innerText;
    });

    const wb = XLSX.utils.table_to_book(table, { sheet: "Analytics" });
    XLSX.writeFile(wb, 'analytics_report.xlsx');
  });
  </script>

</body>
</html>
