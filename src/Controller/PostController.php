<?php
namespace App\Controller;

use App\Exception\NotFoundException;
use App\Model\Post;  // Change to Post model
use App\Service\Router;
use App\Service\Templating;

class PostController
{
    // Index Action: Display a list of posts
    public function indexAction(Templating $templating, Router $router): ?string
    {
        $posts = Post::findAll();  // Get all posts
        return $templating->render('post/index.html.php', [  // Use post template
            'posts' => $posts,
            'router' => $router,
        ]);
    }

    // Create Action: Create a new post
    public function createAction(?array $requestPost, Templating $templating, Router $router): ?string
    {
        if ($requestPost) {
            $post = Post::fromArray($requestPost);  // Create a post from the request data

            $errors = $this->validatePost($post);  // Validate post
            if (!empty($errors)) {
                return $templating->render('post/create.html.php', [  // Use post create template
                    'post' => $post,
                    'errors' => $errors,
                    'router' => $router,
                ]);
            }

            $post->save();  // Save the new post

            $path = $router->generatePath('post-index');  // Redirect to the post index page
            $router->redirect($path);
            return null;
        } else {
            $post = new Post();  // If no post data, initialize a new Post object
        }

        return $templating->render('post/create.html.php', [  // Render the create template
            'post' => $post,
            'router' => $router,
        ]);
    }

    // Edit Action: Edit an existing post
    public function editAction(int $postId, ?array $requestPost, Templating $templating, Router $router): ?string
    {
        $post = Post::find($postId);  // Find the post by ID
        if (!$post) {
            throw new NotFoundException("Missing post with id $postId");
        }

        if ($requestPost) {
            $post->fill($requestPost);  // Fill the post with new data

            $errors = $this->validatePost($post);  // Validate the updated post
            if (!empty($errors)) {
                return $templating->render('post/edit.html.php', [  // Use post edit template
                    'post' => $post,
                    'errors' => $errors,
                    'router' => $router,
                ]);
            }

            $post->save();  // Save the updated post

            $path = $router->generatePath('post-index');  // Redirect to the post index page
            $router->redirect($path);
            return null;
        }

        return $templating->render('post/edit.html.php', [  // Render the edit template
            'post' => $post,
            'router' => $router,
        ]);
    }

    // Show Action: Display a single post
    public function showAction(int $postId, Templating $templating, Router $router): ?string
    {
        $post = Post::find($postId);  // Find the post by ID
        if (!$post) {
            throw new NotFoundException("Missing post with id $postId");
        }

        return $templating->render('post/show.html.php', [  // Use post show template
            'post' => $post,
            'router' => $router,
        ]);
    }

    // Delete Action: Delete a post
    public function deleteAction(int $postId, Router $router): ?string
    {
        $post = Post::find($postId);  // Find the post by ID
        if (!$post) {
            throw new NotFoundException("Missing post with id $postId");
        }

        $post->delete();  // Delete the post
        $path = $router->generatePath('post-index');  // Redirect to the post index page
        $router->redirect($path);
        return null;
    }

    // Validate post: Ensure subject and content are valid
    private function validatePost(Post $post): array
    {
        $errors = [];

        if (empty($post->getSubject())) {  // Check if subject is empty
            $errors[] = 'Subject is required.';
        } elseif (strlen($post->getSubject()) < 5) {  // Check if subject is too short
            $errors[] = 'Subject must be at least 5 characters long.';
        }

        if (empty($post->getContent())) {  // Check if content is empty
            $errors[] = 'Content is required.';
        } elseif (strlen($post->getContent()) < 10) {  // Check if content is too short
            $errors[] = 'Content must be at least 10 characters long.';
        }

        return $errors;
    }
}

