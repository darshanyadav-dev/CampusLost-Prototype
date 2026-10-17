<?php require 'functions.php';
require_login();
$item_id = (int) ($_GET['item'] ?? 0);
$q = $conn->prepare('SELECT * FROM items WHERE id=? AND user_id=?');
$q->bind_param('ii', $item_id, $_SESSION['user']['id']);
$q->execute();
$item = $q->get_result()->fetch_assoc();
if (!$item) {
    flash('error', 'Listing not found.');
    redirect('my-items.php');
}
if (isset($_GET['set'])) {
    $claim = (int) $_GET['set'];
    $state = $_GET['state'] === 'approved' ? 'approved' : 'rejected';
    $q = $conn->prepare('UPDATE claims SET status=? WHERE id=? AND item_id=?');
    $q->bind_param('sii', $state, $claim, $item_id);
    $q->execute();
    flash('success', 'Claim updated.');
    redirect('claims.php?item=' . $item_id);
}
$q = $conn->prepare('SELECT c.*,u.name,u.email FROM claims c JOIN users u ON u.id=c.claimant_id WHERE c.item_id=? ORDER BY c.created_at DESC');
$q->bind_param('i', $item_id);
$q->execute();
$claims = $q->get_result();
$page_title = 'Claims';
require 'header.php'; ?>
<a class="text-decoration-none small" href="my-items.php"><i class="bi bi-arrow-left"></i> My items</a>
<h1 class="h2 fw-bold mt-3">Claims for “<?= e($item['title']) ?>”</h1>
<div class="row g-3 mt-1"><?php if ($claims->num_rows):
    while ($claim = $claims->fetch_assoc()): ?>
            <div class="col-12">
                <article class="card">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h2 class="h5 mb-1"><?= e($claim['name']) ?></h2><a href="mailto:<?= e($claim['email']) ?>"
                                    class="small"><?= e($claim['email']) ?></a>
                            </div><span
                                class="badge bg-<?= $claim['status'] === 'approved' ? 'success' : ($claim['status'] === 'rejected' ? 'secondary' : 'warning text-dark') ?> text-capitalize"><?= e($claim['status']) ?></span>
                        </div>
                        <p class="my-3" style="white-space:pre-line"><?= e($claim['message']) ?></p>
                        <?php if ($claim['status'] === 'pending'): ?><a class="btn btn-sm btn-success"
                                href="claims.php?item=<?= $item_id ?>&set=<?= $claim['id'] ?>&state=approved">Approve</a><a
                                class="btn btn-sm btn-outline-secondary"
                                href="claims.php?item=<?= $item_id ?>&set=<?= $claim['id'] ?>&state=rejected">Decline</a><?php endif; ?>
                    </div>
                </article>
            </div><?php endwhile; else: ?>
        <div class="empty">No one has claimed this item yet.</div><?php endif; ?>
</div><?php require 'footer.php'; ?>