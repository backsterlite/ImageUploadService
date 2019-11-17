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
    $r->get('/category/{id:\d+}', ['App\controllers\HomeController', 'category']);
    $r->get('/user/{id:\d+}', ['App\controllers\HomeController', 'user']);


    $r->get('/login', ['App\controllers\LoginController', 'showForm']);
    $r->get('/logout', ['App\controllers\LoginController', 'logout']);
    $r->post('/login', ['App\controllers\LoginController', 'login']);
    $r->get('/register', ['App\controllers\RegisterController', 'showForm']);
    $r->post('/register', ['App\controllers\RegisterController', 'registration']);
    $r->get('/verify_email', ['App\controllers\VerificationController', 'verify']);

    $r->get('/profile/info', ['App\controllers\ProfileController', 'showProfileInfo']);
    $r->post('/profile/info', ['App\controllers\ProfileController', 'updateUserInfo']);

    $r->get('/profile/security', ['App\controllers\ProfileController', 'showProfileSecurity']);
    $r->post('/profile/security', ['App\controllers\ProfileController', 'updateUserSecurity']);



    $r->get('/photos/create', ['App\controllers\PhotoController', 'create']);
    $r->post('/photos/store', ['App\controllers\PhotoController', 'store']);
    $r->get('/photos/gallery', ['App\controllers\PhotoController', 'index']);
    $r->get('/photos/{id:\d+}', ['App\controllers\PhotoController', 'showOne']);
    $r->get('/photos/{id:\d+}/edit', ['App\controllers\PhotoController', 'edit']);
    $r->post('/photos/{id:\d+}/update', ['App\controllers\PhotoController', 'update']);
    $r->get('/photos/{id:\d+}/delete', ['App\controllers\PhotoController', 'delete']);

    $r->get('/photos/download/{id:\d+}', ['App\controllers\PhotoController', 'download']);

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
        abort(404);
//        echo '404 Not Found';
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        echo '405 Method Not Allowed';
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        // ... call $handler with $vars
        $container->call($handler,$vars);
        break;
}