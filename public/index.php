<?php
require_once(dirname(__FILE__) . '/../vendor/autoload.php');
require_once(dirname(__FILE__) . '/../src/App/config.php');

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use App\Helper\Session;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

Session::startSession();    //fürs backend damit man angemeldet bleibt, speichert

/* @var $config array */
date_default_timezone_set("Europe/Berlin");

$response = new Response();


$routes = new RouteCollection();
$routes->add('startPage', new Route('/', ['_controller' => 'App\Controller\Frontend\StartPageController::indexAction']));
$routes->add('programs', new Route('/programme', ['_controller' => 'App\Controller\Frontend\BlogController::listAction']));
$routes->add('programDetail', new Route('/programm/{id}', ['_controller' => 'App\Controller\Frontend\BlogController::detailAction'], ['id' => '\d+']));
$routes->add('programm-comment', new Route('/programm/{id}/kommentieren', ['_controller' => 'App\Controller\Frontend\BlogCommentController::showCommentFormAction'], ['id' => '\d+']));
$routes->add('not-found', new Route('/not-found', ['_controller' => 'App\Controller\Frontend\NotFoundController::notFoundAction']));
$routes->add('impressum', new Route('/impressum', ['_controller' => 'App\Controller\Frontend\ImpressumController::indexAction']));
$routes->add('documentation', new Route('/dokumentation', ['_controller' => 'App\Controller\Frontend\DocumentationController::indexAction']));

// admin Routes:
$routes->add('backendLogin', new Route('/admin', ['_controller' => 'App\Controller\Backend\SessionController::loginAction']));
$routes->add('backendStartPage', new Route('/admin/start', ['_controller' => 'App\Controller\Backend\StartPageController::indexAction']));
$routes->add('backendProgram', new Route('/admin/programme', ['_controller' => 'App\Controller\Backend\ProgramController::indexAction']));
$routes->add('backendProgramEdit', new Route('/admin/programm-bearbeiten/{id}', ['_controller' => 'App\Controller\Backend\ProgramController::editAction'], ['id' => '\d+']));
$routes->add('backendProgramDelete', new Route('/admin/programm-loeschen/{id}', ['_controller' => 'App\Controller\Backend\ProgramController::deleteAction'], ['id' => '\d+']));
$routes->add('backendUserList', new Route('/admin/nutzer', ['_controller' => 'App\Controller\Backend\BackendUserController::indexAction']));
$routes->add('backendLogout', new Route('/admin/logout', ['_controller' => 'App\Controller\Backend\SessionController::logoutAction']));

$request = Request::createFromGlobals();
$context = new RequestContext('/');
$context->fromRequest($request);

try {
    $uri = $request->getPathInfo();
    route($routes, $context, $uri, $request, $config);
} catch (ResourceNotFoundException $e) {
    $uri = '/not-found';
    route($routes, $context, $uri, $request, $config);
}

function route($routes, $context, $uri, $request, $config)
{
    $matcher = new UrlMatcher($routes, $context);
    $parameters = $matcher->match($uri);
    foreach ($parameters as $key => $value) {
        $request->attributes->set($key, $value);
    }
    if (!is_null($parameters)) {
        $controllerMap = preg_split('/::/', $parameters['_controller']);
        $controllerClass = $controllerMap[0];
        $action = isset($controllerMap[1]) ? $controllerMap[1] : null;
        if ($action) {
            $controller = new $controllerClass($config);
            $response = $controller->$action($request);
        } else {
            $response = new Response('Server error', 500);
        }
    } else {
        $response = new Response('Not Found', 404);
    }
    $response->send();
}








