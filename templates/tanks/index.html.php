<?php

/** @var \App\Model\Tank[] $tanks */
/** @var \App\Service\Router $router */

$title = 'Tanks list';
$bodyClass = 'index';

ob_start(); ?>
    <h1>Tank list</h1>

    <a href="<?= $router->generatePath('tank-create') ?>">Add new tank to the country stash</a>

    <ul class="index-list">
        <?php foreach ($tanks as $tank): ?>
            <li>
                <h3><?= $tank->getMake() ?> <?= $tank->getModel() ?> (<?= $tank->getYear() ?>)</h3>
                <ul class="action-list">
                    <li><a href="<?= $router->generatePath('tank-show', ['id' => $tank->getId()]) ?>">Properties</a></li>
                    <li><a href="<?= $router->generatePath('tank-edit', ['id' => $tank->getId()]) ?>">Edit</a></li>
                </ul>
            </li>
        <?php endforeach; ?>
    </ul>

<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
