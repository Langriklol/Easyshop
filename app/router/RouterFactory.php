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
        $router[] = new Route('product/add', 'Core:Product:add');
        $router[] = new Route('product/[<id>]/<action>', [
            'presenter' => 'Core:Product',
            'action' => [
                Route::VALUE => 'default',
                Route::FILTER_TABLE => [
                    'detail' => 'default',
                    'edit' => 'edit',
                    'remove' => 'delete'
                ],
                Route::FILTER_STRICT => true
            ]
        ]);

        $router[] = new Route('products', 'Core:Product:list');

        $router[] = new Route('basket/<action>/[<id>]', [
            'presenter' => 'Core:Basket',
            'action' => [
                Route::VALUE => 'default',
                Route::FILTER_TABLE => [
                    'default' => 'default',
                ],
            ]
        ]);

        $router[] = new Route('invoice[/<id>]', 'Core:Invoice:default');

        $router[] = new Route('order[/<id>]', 'Core:Order:default');
        $router[] = new Route('order/<id>/<action>', [
            'presenter' => 'Core:Order',
            'action' => [
                Route::VALUE => 'default',
                Route::FILTER_TABLE => [
                    'detail' => 'default',
                    'list' => 'list'
                ],
                Route::FILTER_STRICT => true
            ]
        ]);

        return $router;
	}
}