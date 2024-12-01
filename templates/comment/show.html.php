<?php

/** @var \App\Model\comment $post */
/** @var \App\Service\Router $router */

$title = "{$post->getSubject()} ({$post->getId()})";
$bodyClass = 'show';

ob_start(); ?>
    <h1><?= $post->getSubject() ?></h1>
    <article>
        <?= $post->getContent();?>
    </article>

    <ul class="action-list">
        <li> <a href="<?= $router->generatePath('comment-index') ?>">Back to list</a></li>
        <li><a href="<?= $router->generatePath('comment-edit', ['id'=> $post->getId()]) ?>">Edit</a></li>
    </ul>
<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
