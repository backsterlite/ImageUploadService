<?php

use App\models\Database;
use Aura\SqlQuery\QueryFactory;
use Delight\Auth\Auth;
use DI\ContainerBuilder ;
use League\Plates\Engine;

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions([
    QueryFactory::class => function()
    {
        return new QueryFactory('mysql');
    },
    Engine::class => function()
    {
        return new Engine(dirname(__DIR__) . '/app/views/');
    },
    PDO::class => function()
    {
        return new PDO('mysql:host=localhost;dbname=marlin', 'root', '');
    },
    Auth::class => function($container)
    {
        return new Auth($container->get('PDO'));
    },
    Swift_Mailer::class => function()
    {
        $transport = (new Swift_SmtpTransport('smtp.gmail.com', 587,'tls'))
                                            ->setUsername('coilofluck@gmail.com')
                                            ->setPassword('kapr1zofgods');
        return new Swift_Mailer($transport);
    }
]);
$container = $containerBuilder->build();
$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->get('/', ['App\controllers\HomeController', 'index']);
    $r->get('/category{id:\id+}', ['App\controllers\HomeController', 'category']);

    $r->get('/login', ['App\controllers\LoginController', 'showForm']);
    $r->post('/login', ['App\controllers\LoginController', 'login']);
    $r->get('/register', ['App\controllers\RegisterController', 'showForm']);
    $r->post('/register', ['App\controllers\RegisterController', 'registration']);
    $r->get('/verify_email', ['App\controllers\VerificationController', 'verify']);
});


// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        // ... call $handler with $vars
        $container->call($handler,$vars);
        break;
}