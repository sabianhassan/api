<?php
require_once __DIR__ . '/../classes/Database.php'; // Ensure correct path
$pdo = connectDatabase();

// Securely delete user
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $user_id = intval($_GET['delete']);
    $stmt = $pdo->prepare("DELETE FROM users WHERE userid = ?"); // Changed `id` to `userid`
    $stmt->execute([$user_id]);
}

// Fetch all users
$stmt = $pdo->query("SELECT * FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>



<h2>Manage Users</h2>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Email</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($users as $user): ?>
    <tr>
        <td><?= isset($user['userid']) ? htmlspecialchars($user['userid']) : 'N/A' ?></td> <!-- Changed `id` to `userid` -->
        <td><?= htmlspecialchars($user['email']) ?></td>
        <td>
            <?php if (isset($user['userid'])): ?> <!-- Changed `id` to `userid` -->
                <a href="manage_users.php?delete=<?= $user['userid'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
            <?php else: ?>
                N/A
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php include __DIR__ . '/../templates/admin_footer.php'; ?>
