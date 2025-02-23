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
 |------------------------------------------------------------
 | FIX: Most Popular Room Type (JOIN on rooms)
 |------------------------------------------------------------
 | The "bookings" table likely doesn't have "room_type",
 | so we join "rooms" using room_id.
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
 |------------------------------------------------------------
 | Most Booked Package
 |------------------------------------------------------------
 | If your "bookings" table has a "package" column, this works.
 | Otherwise, you'd need to join a "packages" table similarly.
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics Dashboard</title>

    <!-- External Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>         <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script> 

    <!-- Optional: Your custom CSS file -->
    <link rel="stylesheet" href="../assets/style.css"> 
</head>
<body>

    <h2>Analytics Dashboard</h2>

    <!-- Basic Stats -->
    <div class="stats">
        <div class="stat-box">Total Bookings: <strong><?php echo $totalBookings; ?></strong></div>
        <div class="stat-box">Total Users: <strong><?php echo $totalUsers; ?></strong></div>
        <div class="stat-box">Most Popular Room: <strong><?php echo $popularRoomType; ?></strong></div>
        <div class="stat-box">Most Booked Package: <strong><?php echo $popularPackageType; ?></strong></div>
    </div>

    <!-- Chart Container -->
    <canvas id="bookingChart" width="400" height="200"></canvas> 

    <!-- Export Buttons -->
    <button id="exportPdf">Export to PDF</button>
    <button id="exportExcel">Export to Excel</button>

    <script>
        // 1) Fetch booking data (daily counts) and build Chart.js line chart
        fetch('get_booking_data.php')
            .then(response => response.json())
            .then(data => {
                const ctx = document.getElementById('bookingChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.dates,
                        datasets: [{
                            label: 'Bookings Per Day',
                            data: data.bookings,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: { beginAtZero: true }
                        }
                    }
                });
            })
            .catch(error => console.error('Error loading chart data:', error));

        // 2) Export to PDF using jsPDF + html2canvas
        document.getElementById('exportPdf').addEventListener('click', () => {
            html2canvas(document.body).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                const { jsPDF } = window.jspdf;
                const doc = new jsPDF('p', 'mm', 'a4');

                doc.text("Hotel Management Analytics", 10, 10);
                doc.addImage(imgData, 'PNG', 10, 20, 190, 120);
                doc.save("analytics_report.pdf");
            });
        });

        // 3) Export to Excel using SheetJS
        document.getElementById('exportExcel').addEventListener('click', () => {
            // Create a hidden table element to store stats
            let table = document.createElement("table");

            // Gather stat boxes
            let stats = document.querySelectorAll('.stat-box');
            stats.forEach(stat => {
                let row = table.insertRow();
                let cell = row.insertCell();
                cell.innerText = stat.innerText;
            });

            // Convert table to a workbook and export
            const wb = XLSX.utils.table_to_book(table, { sheet: "Analytics" });
            XLSX.writeFile(wb, 'analytics_report.xlsx');
        });
    </script>

</body>
</html>
