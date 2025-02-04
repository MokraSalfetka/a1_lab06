<?php

/** @var \App\Model\Tank $tank */
/** @var \App\Service\Router $router */

$title = 'Create Tank';
$bodyClass = "edit";

ob_start(); ?>
    <h1>Dodaj czołg/tank/танк??</h1>
    <form action="<?= $router->generatePath('tank-create') ?>" method="post" class="edit-form">
        <?php require __DIR__ . DIRECTORY_SEPARATOR . '_form.html.php'; ?>
        <input type="hidden" name="action" value="tank-create">
    </form>

    <a href="<?= $router->generatePath('tank-index') ?>">Back to list</a>
<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
