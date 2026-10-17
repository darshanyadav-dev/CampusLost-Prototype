<?php require_once 'functions.php'; $page_title = $page_title ?? 'CampusLost'; ?>
<!doctype html>
<html lang="en"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($page_title) ?> · CampusLost</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="assets/css/style.css" rel="stylesheet">
</head><body>
<nav class="navbar navbar-expand-lg sticky-top"><div class="container">
  <a class="navbar-brand" href="index.php"><i class="bi bi-shield-check"></i> Campus<span>Lost</span></a>
  <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav"><i class="bi bi-list"></i></button>
  <div class="collapse navbar-collapse" id="nav"><ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
    <li class="nav-item"><a class="nav-link" href="browse.php">Browse</a></li>
    <?php if (logged_in()): ?><li class="nav-item"><a class="nav-link" href="my-items.php">My items</a></li>
    <?php if (is_admin()): ?><li class="nav-item"><a class="nav-link" href="admin.php">Admin</a></li><?php endif; ?>
    <li class="nav-item"><a class="btn btn-primary btn-sm px-3" href="post-item.php"><i class="bi bi-plus-lg"></i> Post item</a></li>
    <li class="nav-item"><a class="nav-link" href="logout.php">Sign out</a></li>
    <?php else: ?><li class="nav-item"><a class="nav-link" href="login.php">Sign in</a></li><li class="nav-item"><a class="btn btn-primary btn-sm px-3" href="register.php">Join now</a></li><?php endif; ?>
  </ul></div>
</div></nav>
<main class="container py-4">
<?php if ($msg = flash('success')): ?><div class="alert alert-success alert-dismissible fade show"><?= e($msg) ?><button class="btn-close" data-bs-dismiss="alert"></button></div><?php endif; ?>
<?php if ($msg = flash('error')): ?><div class="alert alert-danger alert-dismissible fade show"><?= e($msg) ?><button class="btn-close" data-bs-dismiss="alert"></button></div><?php endif; ?>
