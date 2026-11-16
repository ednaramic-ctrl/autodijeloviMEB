
<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/database.php';

Flight::route('GET /', function() {
    Flight::json([
        'message' => 'AutoDijelovi API is running'
    ]);
});

require_once __DIR__ . '/routes/UserRoutes.php';
require_once __DIR__ . '/routes/VehicleCheckRoutes.php';
require_once __DIR__ . '/routes/CategoryRoutes.php';
require_once __DIR__ . '/routes/ProductRoutes.php';
require_once __DIR__ . '/routes/OrderRoutes.php';
require_once __DIR__ . '/routes/OrderItemRoutes.php';
require_once __DIR__ . '/routes/ExternalApiRoutes.php';

Flight::start();
