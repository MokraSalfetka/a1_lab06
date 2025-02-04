<?php
namespace App\Controller;

use App\Exception\NotFoundException;
use App\Model\tank;
use App\Service\Router;
use App\Service\Templating;

class TankController
{
    public function indexAction(Templating $templating, Router $router): ?string
    {
        $tank = tank::findAll();
        $html = $templating->render('tanks/index.html.php', [
            'tanks' => $tank,
            'router' => $router,
        ]);
        return $html;
    }

    public function createAction(?array $requestPost, Templating $templating, Router $router): ?string
    {
        if ($requestPost) {
            $tank = tank::fromArray($requestPost);
            $tank->save();

            $path = $router->generatePath('tank-index');
            $router->redirect($path);
            return null;
        } else {
            $tank = new tank();
        }

        $html = $templating->render('tanks/create.html.php', [
            'tanks' => $tank,
            'router' => $router,
        ]);
        return $html;
    }

    public function editAction(int $tankId, ?array $requestPost, Templating $templating, Router $router): ?string
    {
        $tank = tank::find($tankId);
        if (! $tank) {
            throw new NotFoundException("Missing post with id $tankId");
        }

        if ($requestPost) {
            $tank->fill($requestPost);
            $tank->save();

            $path = $router->generatePath('tank-index');
            $router->redirect($path);
            return null;
        }

        $html = $templating->render('tanks/edit.html.php', [
            'tanks' => $tank,
            'router' => $router,
        ]);
        return $html;
    }

    public function showAction(int $tankId, Templating $templating, Router $router): ?string
    {
        $tank = tank::find($tankId);
        if (! $tank) {
            throw new NotFoundException("Missing post with id $tankId");
        }

        $html = $templating->render('tanks/show.html.php', [
            'tanks' => $tank,
            'router' => $router,
        ]);
        return $html;
    }

    public function deleteAction(int $tankId, Router $router): ?string
    {
        $tank = tank::find($tankId);
        if (! $tank) {
            throw new NotFoundException("Missing post with id $tankId");
        }

        $tank->delete();
        $path = $router->generatePath('tank-index');
        $router->redirect($path);
        return null;
    }
}
