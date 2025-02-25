<?php
require_once __DIR__ . '/../classes/Database.php';
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

<!-- Minimal CSS for styling the table -->
<style>
    .manage-users-container {
        max-width: 800px;
        margin: 40px auto;
        font-family: Arial, sans-serif;
    }

    .manage-users-container h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    table.manage-users-table {
        width: 100%;
        border-collapse: collapse;
    }

    table.manage-users-table th,
    table.manage-users-table td {
        border: 1px solid #ccc;
        padding: 10px;
        text-align: left;
    }

    table.manage-users-table th {
        background-color: #f7f7f7;
    }

    /* Alternate row coloring */
    table.manage-users-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    /* Style for the delete link */
    a.delete-link {
        color: #d9534f;
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
        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
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
    </table>
</div>

<?php include __DIR__ . '/../templates/admin_footer.php'; ?>
