<?php
require_once __DIR__ . '/../classes/Database.php'; // Ensure correct path
$pdo = connectDatabase();

// Securely delete user
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $user_id = intval($_GET['delete']);
    $stmt = $pdo->prepare("DELETE FROM users WHERE userid = ?");
    $stmt->execute([$user_id]);
}

// Fetch all users
$stmt = $pdo->query("SELECT * FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!-- Inline CSS for dark mode styling -->
<style>
    body {
        background-color: #222;
        color: #ddd;
        font-family: Arial, sans-serif;
    }
    .manage-users-container {
        max-width: 900px;
        margin: 40px auto;
        background-color: #333;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.5);
    }
    .manage-users-container h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #fff;
    }
    table.manage-users-table {
        width: 100%;
        border-collapse: collapse;
    }
    table.manage-users-table th, 
    table.manage-users-table td {
        border: 1px solid #555;
        padding: 12px;
        text-align: left;
    }
    table.manage-users-table th {
        background-color: #444;
        color: #fff;
    }
    table.manage-users-table tr:nth-child(even) {
        background-color: #3a3a3a;
    }
    table.manage-users-table tr:nth-child(odd) {
        background-color: #333;
    }
    a.delete-link {
        color: #e74c3c;
        text-decoration: none;
        font-weight: bold;
    }
    a.delete-link:hover {
        text-decoration: underline;
    }
</style>

<div class="manage-users-container">
    <h2>Manage Users</h2>

    <table class="manage-users-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= isset($user['userid']) ? htmlspecialchars($user['userid']) : 'N/A' ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td>
                    <?php if (isset($user['userid'])): ?>
                        <a class="delete-link" 
                           href="manage_users.php?delete=<?= $user['userid'] ?>" 
                           onclick="return confirm('Are you sure you want to delete this user?')">
                           Delete
                        </a>
                    <?php else: ?>
                        N/A
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/../templates/admin_footer.php'; ?>
