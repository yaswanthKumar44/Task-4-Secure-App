<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';
require_once 'includes/functions.php';

$auth = new Auth();
if (!$auth->isLoggedIn()) {
    header('Location: login.php');
    exit();
}

$database = new Database();
$db = $database->getConnection();
$query = "SELECT p.*, u.email FROM posts p JOIN users u ON p.user_id = u.id ORDER BY p.created_at DESC";
$stmt = $db->prepare($query);
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include 'templates/header.php'; ?>
<?php include 'templates/navbar.php'; ?>

<div class="container mx-auto mt-8 flex">
    <?php include 'templates/sidebar.php'; ?>
    <div class="ml-64 flex-1 p-6">
        <h2 class="text-2xl font-semibold mb-6">User Dashboard</h2>
        <?php if (isset($_SESSION['errors'])): ?>
            <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                <?php foreach ($_SESSION['errors'] as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; unset($_SESSION['errors']); ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_GET['success'])): ?>
            <div class="bg-green-100 text-green-700 p-4 rounded mb-4">Post created successfully!</div>
        <?php endif; ?>
        <div class="grid grid-cols-1 gap-4">
            <?php foreach ($posts as $post): ?>
                <div class="bg-white p-4 rounded-lg shadow">
                    <h3 class="text-lg font-semibold"><?php echo htmlspecialchars($post['title']); ?></h3>
                    <p class="text-gray-600"><?php echo htmlspecialchars($post['content']); ?></p>
                    <p class="text-sm text-gray-500">Posted by <?php echo htmlspecialchars($post['email']); ?> on <?php echo $post['created_at']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php include 'templates/footer.php'; ?>