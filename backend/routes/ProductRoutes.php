
<?php

require_once __DIR__ . '/CrudRoutes.php';
require_once __DIR__ . '/../services/ProductService.php';

registerCrudRoutes('products', 'ProductService');
