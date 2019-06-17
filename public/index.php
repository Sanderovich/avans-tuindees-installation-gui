<?php

use App\Http\Controllers\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

require_once __DIR__ . '/../vendor/autoload.php';

$kernel = new App\Http\Kernel();

$index = new Route("/", [
    'controller' => BaseController::class
]);
$initialSetup = new Route("/initial-setup", [
    'controller' => BaseController::class
]);
$startInitialSetup = new Route("/start-initial-setup", [
    'controller' => BaseController::class,
    'methods' => ['POST'],
]);
$information = new Route("/information", [
    'controller' => BaseController::class
]);
$setupInformation = new Route("/setup-information", [
    'controller' => BaseController::class,
    'methods' => ['POST'],
]);
$startInformationSetup = new Route("/start-information-setup", [
    'controller' => BaseController::class,
    'methods' => ['POST'],
]);
$done = new Route("/done", [
    'controller' => BaseController::class
]);

$routes = new RouteCollection();
$routes->add('', $index);
$routes->add('initialSetup', $initialSetup);
$routes->add('startInitialSetup', $startInitialSetup);
$routes->add('information', $information);
$routes->add('setupInformation', $setupInformation);
$routes->add('startInformationSetup', $startInitialSetup);
$routes->add('done', $done);

$context = new RequestContext();
$context->fromRequest(Request::createFromGlobals());

var_dump($context);

$matcher = new UrlMatcher($routes, $context);
$data = $matcher->match($context->getPathInfo());

$controller = new $data['controller']();
$method = $data['_route'] ?: 'index';

call_user_func([
    $controller,
    $method,
]);