<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';
require_once 'includes/functions.php';

$auth = new Auth();
if (!$auth->isLoggedIn() || !$auth->isAdmin()) {
    header('Location: index.php');
    exit();
}

$database = new Database();
$db = $database->getConnection();
$query = "SELECT * FROM users ORDER BY created_at DESC";
$stmt = $db->prepare($query);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include 'templates/header.php'; ?>
<?php include 'templates/navbar.php'; ?>

<div class="container mx-auto mt-8 flex">
    <?php include 'templates/sidebar.php'; ?>
    <div class="ml-64 flex-1 p-6">
        <h2 class="text-2xl font-semibold mb-6">Admin Panel</h2>
        <div class="bg-white p-4 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-4">Manage Users</h3>
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Role</th>
                        <th class="px-4 py-2">Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td class="border px-4 py-2"><?php echo htmlspecialchars($user['id']); ?></td>
                            <td class="border px-4 py-2"><?php echo htmlspecialchars($user['email']); ?></td>
                            <td class="border px-4 py-2"><?php echo htmlspecialchars($user['role']); ?></td>
                            <td class="border px-4 py-2"><?php echo htmlspecialchars($user['created_at']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'templates/footer.php'; ?>