
<?php

require_once __DIR__ . '/CrudRoutes.php';
require_once __DIR__ . '/../services/OrderService.php';

registerCrudRoutes('orders', 'OrderService');
