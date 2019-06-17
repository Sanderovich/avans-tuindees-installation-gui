<?php

use App\Http\Controllers\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

require_once __DIR__ . '/../vendor/autoload.php';

$kernel = new App\Http\Kernel();

$route = new Route("/foo", [
    'controller' => BaseController::class
]);

$routes = new RouteCollection();
$routes->add('foo', $route);

$context = new RequestContext();
$context->fromRequest(Request::createFromGlobals());

$matcher = new UrlMatcher($routes, $context);
$data = $matcher->match($context->getPathInfo());

$controller = new $data['controller']();
$method = $data['_route'];
call_user_func([
    $controller,
    $method,
]);