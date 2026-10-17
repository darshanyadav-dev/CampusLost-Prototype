<?php $page_title = 'Browse listings';
require 'header.php';
$q = trim($_GET['q'] ?? '');
$status = $_GET['status'] ?? '';
$category = $_GET['category'] ?? '';
$sql = "SELECT i.*,u.name FROM items i JOIN users u ON u.id=i.user_id WHERE 1";
$types = '';
$params = [];
if ($q !== '') {
    $sql .= " AND (i.title LIKE ? OR i.description LIKE ? OR i.location LIKE ? )";
    $types .= 'sss';
    $like = "%$q%";
    array_push($params, $like, $like, $like);
}
if (in_array($status, ['lost', 'found', 'returned'])) {
    $sql .= " AND i.status=?";
    $types .= 's';
    $params[] = $status;
}
if ($category !== '') {
    $sql .= " AND i.category=?";
    $types .= 's';
    $params[] = $category;
}
$sql .= " ORDER BY i.created_at DESC";
$stmt = $conn->prepare($sql);
if ($types)
    $stmt->bind_param($types, ...$params);
$stmt->execute();
$items = $stmt->get_result(); ?>
<div class="d-flex justify-content-between align-items-end mb-4">
    <div>
        <p class="text-primary fw-semibold mb-1">COMMUNITY BOARD</p>
        <h1 class="h2 fw-bold mb-0">Browse listings</h1>
    </div><a class="btn btn-primary" href="post-item.php">Post item</a>
</div>
<form class="card card-body mb-4">
    <div class="row g-2">
        <div class="col-md-5"><input name="q" class="form-control" value="<?= e($q) ?>"
                placeholder="Search items or places"></div>
        <div class="col-md-3"><select name="status" class="form-select">
                <option value="">All statuses</option><?php foreach (['lost', 'found', 'returned'] as $s): ?>
                    <option <?= $status === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option><?php endforeach; ?>
            </select></div>
        <div class="col-md-3"><select name="category" class="form-select">
                <option value="">All categories</option>
                <?php foreach (['Electronics', 'Documents', 'Keys', 'Clothing', 'Accessories', 'Other'] as $c): ?>
                    <option <?= $category === $c ? 'selected' : '' ?>><?= $c ?></option><?php endforeach; ?>
            </select></div>
        <div class="col-md-1"><button class="btn btn-dark w-100"><i class="bi bi-search"></i></button></div>
    </div>
</form>
<div class="row g-4"><?php if ($items->num_rows):
    while ($item = $items->fetch_assoc()): ?>
            <div class="col-sm-6 col-lg-4"><?php include 'item-card.php'; ?></div><?php endwhile; else: ?>
        <div class="empty"><i class="bi bi-search fs-1"></i>
            <p class="mt-2">No items match your search.</p>
        </div><?php endif; ?>
</div>
<?php require 'footer.php'; ?>