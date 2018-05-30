<?php

namespace App;

use Nette;
use Nette\Application\Routers\Route;
use Nette\Application\Routers\RouteList;


class RouterFactory
{
	use Nette\StaticClass;

	/**
	 * @return Nette\Application\IRouter
	 */
	public static function createRouter()
	{
		$router = new RouteList;
		//$router[] = new Route('<presenter>/<action>[/<id>]', 'Homepage:default');
		//$router[] = new Route('<presenter>/[<category>]/[<name>]-[<id>]', 'Core:Product:default');
        $router[] = new Route('<presenter>/[<id>]', [
            'presenter' => 'Core:Product',
            'action' => [
                Route::FILTER_TABLE => [
                    'default' => 'default'
                ],
                Route::FILTER_STRICT => true
            ]
        ]);
		return $router;
	}
}