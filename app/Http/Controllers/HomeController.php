<?php

namespace Xkye\Http\Controllers;

use Route;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function routesJs( Request $request )
    {
        $routes = Route::getRoutes();
        $r = [];
        foreach ($routes as $key => $value) {
            if( $value->getName() && ! isset( $value->getAction()['jsroute'] ) )
            {
                $r[ $value->getName() ] = url($value->uri());
            }
        }
        $content = 'window._route = ' . json_encode( $r, 128 );

        return response( $content )->header('Content-Type', 'text/javascript');
    }

    public function index()
    {
        return view('welcome');
    }
}
