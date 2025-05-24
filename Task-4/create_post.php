<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';
require_once 'includes/functions.php';

$auth = new Auth();
if (!$auth->isLoggedIn() || (!$auth->isAdmin() && !$auth->isEditor())) {
    header('Location: index.php');
    exit();
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = sanitizeInput($_POST['title']);
    $content = sanitizeInput($_POST['content']);

    if (!verifyCsrfToken($_POST['csrf_token'])) {
        $errors[] = 'Invalid CSRF token';
    } else {
        $errors = validateForm($_POST, ['title' => 'Title', 'content' => 'Content']);
        if (empty($errors)) {
            $database = new Database();
            $db = $database->getConnection();
            $query = "INSERT INTO posts (user_id, title, content) VALUES (:user_id, :title, :content)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':user_id', $_SESSION['user_id']);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':content', $content);
            if ($stmt->execute()) {
                header('Location: index.php?success=1');
                exit();
            } else {
                $errors[] = 'Failed to create post';
            }
        }
    }
}
?>

<?php include 'templates/header.php'; ?>
<?php include 'templates/navbar.php'; ?>

<div class="container mx-auto mt-8 flex">
    <?php include 'templates/sidebar.php'; ?>
    <div class="ml-64 flex-1 p-6">
        <h2 class="text-2xl font-semibold mb-6">Create Post</h2>
        <?php if ($errors): ?>
            <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form id="postForm" action="create_post.php" method="POST" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" id="title" name="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                <span class="error text-red-500 text-sm hidden">Title is required</span>
            </div>
            <div>
                <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                <textarea id="content" name="content" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"></textarea>
                <span class="error text-red-500 text-sm hidden">Content is required</span>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Submit</button>
        </form>
    </div>
</div>

<?php include 'templates/footer.php'; ?>