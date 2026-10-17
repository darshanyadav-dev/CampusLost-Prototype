<?php require 'functions.php';
if (logged_in())
    redirect('index.php');
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $stmt = $conn->prepare('SELECT * FROM users WHERE email=?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    if ($user && password_verify($_POST['password'] ?? '', $user['password'])) {
        unset($user['password']);
        $_SESSION['user'] = $user;
        flash('success', 'Welcome back, ' . $user['name'] . '!');
        redirect('index.php');
    }
    $error = 'Incorrect email or password.';
}
$page_title = 'Sign in';
require 'header.php'; ?>
<div class="card auth-card">
    <div class="card-body p-4 p-md-5">
        <h1 class="h3 fw-bold">Welcome back</h1>
        <p class="text-secondary">Sign in to manage your listings.</p><?php if ($error): ?>
            <div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
        <form method="post"><label class="form-label">Email</label><input required type="email" name="email"
                class="form-control mb-3" value="<?= e($_POST['email'] ?? '') ?>"><label
                class="form-label">Password</label><input required type="password" name="password"
                class="form-control mb-4"><button class="btn btn-primary w-100">Sign in</button></form>
        <p class="text-center small mt-3 mb-0">New here? <a href="register.php">Create an account</a></p>
    </div>
</div><?php require 'footer.php'; ?>