<?php $page_title = 'Find what matters';
require 'header.php';
$latest = $conn->query("SELECT i.*, u.name FROM items i JOIN users u ON u.id=i.user_id WHERE i.status != 'returned' ORDER BY i.created_at DESC LIMIT 3"); ?>
<section class="hero p-4 p-md-5 mb-5">
    <div class="row align-items-center">
        <div class="col-lg-7">
            <p class="text-uppercase small fw-bold opacity-75 mb-2">A safer campus community</p>
            <h1 class="display-5 mb-3">Lost something? Let the campus help.</h1>
            <p class="lead opacity-75 mb-4">A simple, secure place to reunite students with the things that matter.</p>
            <a class="btn btn-light px-4 me-2" href="browse.php">Explore listings</a><a
                class="btn btn-outline-light px-4" href="post-item.php">Post an item</a>
        </div>
        <div class="col-lg-5 d-none d-lg-block text-center"><i class="bi bi-search-heart"
                style="font-size:9rem;opacity:.25"></i></div>
    </div>
</section>
<section class="d-flex justify-content-between align-items-end mb-3">
    <div>
        <p class="text-primary fw-semibold mb-1">RECENTLY POSTED</p>
        <h2 class="h3 fw-bold mb-0">Help close the loop</h2>
    </div><a href="browse.php" class="text-decoration-none">See all <i class="bi bi-arrow-right"></i></a>
</section>
<div class="row g-4"><?php while ($item = $latest->fetch_assoc()): ?>
        <div class="col-md-4"><?php include 'item-card.php'; ?></div><?php endwhile; ?>
</div>
<section class="row g-3 mt-5">
    <div class="col-md-4">
        <div class="stat p-4"><i class="bi bi-pencil-square fs-3 text-primary"></i>
            <h3 class="h5 mt-3">1. Post it</h3>
            <p class="mb-0 text-secondary">Share a clear description and location.</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat p-4"><i class="bi bi-people fs-3 text-primary"></i>
            <h3 class="h5 mt-3">2. Get matched</h3>
            <p class="mb-0 text-secondary">The campus community can find your listing.</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat p-4"><i class="bi bi-heart fs-3 text-primary"></i>
            <h3 class="h5 mt-3">3. Reunite</h3>
            <p class="mb-0 text-secondary">Safely arrange a return and mark it done.</p>
        </div>
    </div>
</section>
<?php require 'footer.php'; ?>