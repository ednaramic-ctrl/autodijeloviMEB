
<?php

require_once __DIR__ . '/CrudRoutes.php';
require_once __DIR__ . '/../services/UserService.php';

registerCrudRoutes('users', 'UserService');
