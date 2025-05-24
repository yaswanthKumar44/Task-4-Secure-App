<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';
require_once 'includes/functions.php';

$auth = new Auth();
if ($auth->isLoggedIn()) {
    header('Location: index.php');
    exit();
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitizeInput($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (!verifyCsrfToken($_POST['csrf_token'])) {
        $errors[] = 'Invalid CSRF token';
    } else {
        $errors = validateForm($_POST, ['email' => 'Email', 'password' => 'Password', 'confirm_password' => 'Confirm Password']);
        if ($password !== $confirm_password) {
            $errors[] = 'Passwords do not match';
        }
        if (empty($errors)) {
            if ($auth->register($email, $password)) {
                header('Location: login.php?success=1');
                exit();
            } else {
                $errors[] = 'Registration failed';
            }
        }
    }
}
?>

<?php include 'templates/header.php'; ?>
<?php include 'templates/navbar.php'; ?>

<div class="container mx-auto mt-8 max-w-md">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-semibold mb-6">Register</h2>
        <?php if ($errors): ?>
            <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_GET['success'])): ?>
            <div class="bg-green-100 text-green-700 p-4 rounded mb-4">Registration successful! Please login.</div>
        <?php endif; ?>
        <form id="registerForm" action="register.php" method="POST" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                <span class="error text-red-500 text-sm hidden">Email is required</span>
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                <span class="error text-red-500 text-sm hidden">Password is required</span>
            </div>
            <div>
                <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                <span class="error text-red-500 text-sm hidden">Confirm Password is required</span>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Register</button>
        </form>
    </div>
</div>

<?php include 'templates/footer.php'; ?>