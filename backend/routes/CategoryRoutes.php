
<?php

require_once __DIR__ . '/CrudRoutes.php';
require_once __DIR__ . '/../services/CategoryService.php';

registerCrudRoutes('categories', 'CategoryService');
