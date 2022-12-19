<?php declare(strict_types = 1);

namespace BloggiSetup\Model\Router;

use Nette\Application\Routers\RouteList;

class SetupRouter
{   
	public static function create(): RouteList
    {
        $router = new RouteList('Setup');

        $router->addRoute('setup/<presenter>/<action>', 'Database:default');

        return $router;
    }
}
