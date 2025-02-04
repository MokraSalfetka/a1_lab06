<?php

/** @var \App\Model\Tank $tanks */
/** @var \App\Service\Router $router */

$title = "Edit Tank {$tanks->getMake()} {$tanks->getModel()} ({$tanks->getId()})";
$bodyClass = "edit";

ob_start(); ?>
    <h1><?= htmlspecialchars($title) ?></h1>
    <form action="<?= $router->generatePath('tank-edit') ?>" method="post" class="edit-form">
        <?php require __DIR__ . DIRECTORY_SEPARATOR . '_form.html.php'; ?>
        <input type="hidden" name="action" value="tank-edit">
        <input type="hidden" name="id" value="<?= $tanks->getId() ?>">
    </form>

    <ul class="action-list">
        <li>
            <a href="<?= $router->generatePath('tank-index') ?>">Back to list</a>
        </li>
        <li>
            <form action="<?= $router->generatePath('tank-delete') ?>" method="post">
                <input type="submit" value="KILL!! I mean delete..." onclick="return confirm('Are you sure about that?')">
                <input type="hidden" name="action" value="tank-delete">
                <input type="hidden" name="id" value="<?= $tanks->getId() ?>">
            </form>
        </li>
    </ul>

<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
