<?php
require_once __DIR__ . '/../includes/auth.php';
$auth = new Auth();
?>
<aside class="w-64 bg-white p-6 shadow-lg h-screen fixed">
    <h2 class="text-xl font-semibold mb-4">Menu</h2>
    <ul>
        <li><a href="index.php" class="block py-2 hover:text-blue-600">Dashboard</a></li>
        <?php if ($auth->isAdmin() || $auth->isEditor()): ?>
            <li><a href="create_post.php" class="block py-2 hover:text-blue-600">Create Post</a></li>
        <?php endif; ?>
        <?php if ($auth->isAdmin()): ?>
            <li><a href="admin.php" class="block py-2 hover:text-blue-600">Admin Panel</a></li>
        <?php endif; ?>
    </ul>
</aside>