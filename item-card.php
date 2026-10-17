<a href="item.php?id=<?= $item['id'] ?>" class="text-decoration-none text-dark">
    <article class="card item-card h-100 overflow-hidden">
        <?php if ($item['image']): ?><img class="item-photo w-100" src="uploads/<?= e($item['image']) ?>"
                alt="<?= e($item['title']) ?>"><?php else: ?>
            <div class="placeholder-photo"><i class="bi bi-box-seam"></i></div><?php endif; ?>
        <div class="card-body">
            <div class="d-flex justify-content-between mb-2"><span
                    class="badge badge-<?= e($item['status']) ?> text-capitalize"><?= e($item['status']) ?></span><small
                    class="text-secondary"><?= date('M j', strtotime($item['item_date'])) ?></small></div>
            <h3 class="h5 fw-bold mb-1 text-truncate"><?= e($item['title']) ?></h3>
            <p class="small text-secondary mb-0"><i class="bi bi-geo-alt"></i> <?= e($item['location']) ?></p>
        </div>
    </article>
</a>