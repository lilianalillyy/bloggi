<?php declare(strict_types=1);

/**
 * This file is a part of the Bloggi CMS.
 *
 * @author Lilian
 */
namespace App\Model\Router;

use Nette;
use Nette\Application\Routers\RouteList;

/**
 * The router of the application.
 */
final class RouterFactory
{
  use Nette\StaticClass;

  /**
   * All the routes in the application are set here. The default configuration
   * bases the routing based on the presenter/action, eg. /file/view for FilePresenter:view.
   *
   * If you wish to add your own routes, you may do so below utilizing the Nette Routing API.
   *
   * @return RouteList
   */
  public static function create(): RouteList
  {
    $router = new RouteList();

    $router->add(self::createAdminRouter());
    $router->add(self::createSecurityRouter());
    $router->add(self::createFrontRouter());

    return $router;
  }

  private static function createFrontRouter(): RouteList
  {
    $frontRouter = new RouteList('Front');

    $frontRouter->addRoute('<presenter>/<action>[/<id>]', 'Homepage:default');

    return $frontRouter;
  }

  private static function createSecurityRouter(): RouteList
  {
    $securityRouter = new RouteList('Security');

    $securityRouter->addRoute('auth/<action>[/<id>]', 'Auth:default');

    return $securityRouter;
  }

  private static function createAdminRouter(): RouteList
  {
    $frontRouter = new RouteList('Admin');

    $frontRouter->addRoute('admin/<presenter>/<action>[/<id>]', 'Dashboard:default');

    return $frontRouter;
  }
}
