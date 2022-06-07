<?php $pager->setSurroundCount(2) ?>

<div class="pagging text-center">
    <nav>
        <ul class="pagination justify-content-center">
            <?php if ($pager->hasPrevious()) : ?>
                <li class="page-item">
                    <span class="page-link">
                        <a href="<?= $pager->getFirst() ?>" aria-label="<?= lang('Pager.first') ?>">«

                        </a>
                    </span>
                </li>
                <li class="page-item">
                    <span class="page-link">
                        <a href="<?= $pager->getPrevious() ?>" aria-label="<?= lang('Pager.previous') ?>">‹

                        </a>
                    </span>
                </li>
            <?php endif ?>

            <?php foreach ($pager->links() as $link) : ?>
                <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                    <span class="page-link">
                        <a style="<?= $link['active'] ? 'color: white;' : '' ?> text-center" href="<?= $link['uri'] ?>">
                            <?= $link['title'] ?>
                        </a>
                    </span>
                </li>
            <?php endforeach ?>

            <?php if ($pager->hasNext()) : ?>
                <li class="page-item">
                    <span class="page-link">
                        <a href="<?= $pager->getNext() ?>" aria-label="<?= lang('Pager.next') ?>">›

                        </a>
                    </span>
                </li>
                <li class="page-item">
                    <span class="page-link">
                        <a href="<?= $pager->getLast() ?>" aria-label="<?= lang('Pager.last') ?>">»

                        </a>
                    </span>
                </li>
            <?php endif ?>
        </ul>
    </nav>
</div>