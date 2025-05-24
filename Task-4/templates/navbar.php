<?php
require_once __DIR__ . '/../includes/auth.php';
$auth = new Auth();
?>
<nav class="bg-blue-600 text-white p-4 sticky top-0 z-10">
    <div class="container mx-auto flex justify-between items-center">
        <h1 class="text-2xl font-bold">Secure App</h1>
        <div>
            <?php if ($auth->isLoggedIn()): ?>
                <?php if ($auth->isAdmin()): ?>
                    <a href="admin.php" class="mr-4 hover:text-blue-200">Admin Panel</a>
                <?php endif; ?>
                <a href="index.php" class="mr-4 hover:text-blue-200">Dashboard</a>
                <a href="logout.php" class="hover:text-blue-200">Logout</a>
            <?php else: ?>
                <a href="login.php" class="mr-4 hover:text-blue-200">Login</a>
                <a href="register.php" class="hover:text-blue-200">Register</a>
            <?php endif; ?>
        </div>
    </div>
</nav>