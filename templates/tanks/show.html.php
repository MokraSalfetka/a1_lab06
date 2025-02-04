<?php

/** @var \App\Model\Tank $tanks */
/** @var \App\Service\Router $router */

$title = "{$tanks->getMake()} {$tanks->getModel()} ({$tanks->getId()})";
$bodyClass = 'show';

ob_start(); ?>
    <h1><?= htmlspecialchars($tanks->getMake()) ?> <?= htmlspecialchars($tanks->getModel()) ?></h1>
    <article>
        <p><strong>Marka:</strong> <?= htmlspecialchars($tanks->getMake()) ?></p>
        <p><strong>Model:</strong> <?= htmlspecialchars($tanks->getModel()) ?></p>
        <p><strong>Rocznik:</strong> <?= htmlspecialchars($tanks->getYear()) ?></p>
    </article>

    <ul class="action-list">
        <li><a href="<?= $router->generatePath('tank-index') ?>">Back to list</a></li>
        <li><a href="<?= $router->generatePath('tank-edit', ['id' => $tanks->getId()]) ?>">Edit</a></li>
    </ul>
<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
