<?php require 'functions.php';
require_login();
$uid = $_SESSION['user']['id'];
if (isset($_GET['return'])) {
    $id = (int) $_GET['return'];
    $q = $conn->prepare("UPDATE items SET status='returned' WHERE id=? AND user_id=?");
    $q->bind_param('ii', $id, $uid);
    $q->execute();
    flash('success', 'Listing marked as returned.');
    redirect('my-items.php');
}
$q = $conn->prepare('SELECT * FROM items WHERE user_id=? ORDER BY created_at DESC');
$q->bind_param('i', $uid);
$q->execute();
$items = $q->get_result();
$page_title = 'My items';
require 'header.php'; ?>
<div class="d-flex justify-content-between align-items-end mb-4">
    <div>
        <p class="text-primary fw-semibold mb-1">YOUR LISTINGS</p>
        <h1 class="h2 fw-bold mb-0">My items</h1>
    </div><a class="btn btn-primary" href="post-item.php">Post another item</a>
</div>
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th class="ps-4">Item</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Claims</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php if ($items->num_rows):
                    while ($item = $items->fetch_assoc()):
                        $c = $conn->prepare('SELECT COUNT(*) n FROM claims WHERE item_id=?');
                        $c->bind_param('i', $item['id']);
                        $c->execute();
                        $claims = $c->get_result()->fetch_assoc()['n']; ?>
                        <tr>
                            <td class="ps-4"><a href="item.php?id=<?= $item['id'] ?>"
                                    class="fw-semibold text-decoration-none"><?= e($item['title']) ?></a>
                                <div class="small text-secondary"><?= e($item['category']) ?></div>
                            </td>
                            <td><?= e($item['location']) ?></td>
                            <td><span class="badge badge-<?= e($item['status']) ?> text-capitalize"><?= e($item['status']) ?></span>
                            </td>
                            <td><?php if ($claims): ?><a href="claims.php?item=<?= $item['id'] ?>"
                                        class="text-decoration-none"><?= $claims ?> view</a><?php else: ?>0<?php endif; ?></td>
                            <td class="text-end pe-4"><?php if ($item['status'] != 'returned'): ?><a
                                        class="btn btn-sm btn-outline-success" href="my-items.php?return=<?= $item['id'] ?>">Mark
                                        returned</a><?php endif; ?></td>
                        </tr><?php endwhile; else: ?>
                    <tr>
                        <td colspan="5" class="empty">You haven’t posted anything yet.</td>
                    </tr><?php endif; ?>
            </tbody>
        </table>
    </div>
</div><?php require 'footer.php'; ?>