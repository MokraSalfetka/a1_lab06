<?php
namespace App\Controller;

use App\Exception\NotFoundException;
use App\Model\Comment;  // Change to Comment model
use App\Service\Router;
use App\Service\Templating;

class CommentController  
{
    public function indexAction(Templating $templating, Router $router): ?string
    {
        $comments = Comment::findAll();
        return $templating->render('comment/index.html.php', [
            'comments' => $comments,
            'router' => $router,
        ]);
    }

    public function createAction(?array $requestPost, Templating $templating, Router $router): ?string
    {
        if ($requestPost) {
            $comment = Comment::fromArray($requestPost);

            $errors = $this->validateComment($comment);
            if (!empty($errors)) {
                return $templating->render('comment/create.html.php', [
                    'comment' => $comment,
                    'errors' => $errors,
                    'router' => $router,
                ]);
            }

            $comment->save();

            $path = $router->generatePath('comment-index');
            $router->redirect($path);
            return null;
        } else {
            $comment = new Comment(); 
        }

        return $templating->render('comment/create.html.php', [  
            'comment' => $comment,  
            'router' => $router,
        ]);
    }

    public function editAction(int $commentId, ?array $requestPost, Templating $templating, Router $router): ?string
    {
        $comment = Comment::find($commentId); 
        if (!$comment) {
            throw new NotFoundException("Missing comment with id $commentId");
        }

        if ($requestPost) {
            $comment->fill($requestPost);  

            $errors = $this->validateComment($comment); 
            if (!empty($errors)) {
                return $templating->render('comment/edit.html.php', [  
                    'comment' => $comment, 
                    'errors' => $errors,
                    'router' => $router,
                ]);
            }

            $comment->save();

            $path = $router->generatePath('comment-index');
            $router->redirect($path);
            return null;
        }

        return $templating->render('comment/edit.html.php', [  // Change view to comment
            'comment' => $comment,  // Change to comment
            'router' => $router,
        ]);
    }

    public function showAction(int $commentId, Templating $templating, Router $router): ?string
    {
        $comment = Comment::find($commentId);
        if (!$comment) {
            throw new NotFoundException("Missing comment with id $commentId");
        }

        return $templating->render('comment/show.html.php', [
            'comment' => $comment,
            'router' => $router,
        ]);
    }

    public function deleteAction(int $commentId, Router $router): ?string
    {
        $comment = Comment::find($commentId);  // Change to Comment
        if (!$comment) {
            throw new NotFoundException("Missing comment with id $commentId");
        }

        $comment->delete();
        $path = $router->generatePath('comment-index');
        $router->redirect($path);
        return null;
    }

    private function validateComment(Comment $comment): array  // Change validation to validateComment
    {
        $errors = [];

        if (empty($comment->getSubject())) {  // Change to Comment subject
            $errors[] = 'Subject is required.';
        } elseif (strlen($comment->getSubject()) < 5) {
            $errors[] = 'Subject must be at least 5 characters long.';
        }

        if (empty($comment->getContent())) {  // Change to Comment content
            $errors[] = 'Content is required.';
        } elseif (strlen($comment->getContent()) < 10) {
            $errors[] = 'Content must be at least 10 characters long.';
        }

        return $errors;
    }
}
