
<?php

require_once __DIR__ . '/CrudRoutes.php';
require_once __DIR__ . '/../services/OrderItemService.php';

registerCrudRoutes('order_items', 'OrderItemService');
