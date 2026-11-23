
<?php

require_once __DIR__ . '/CrudRoutes.php';
require_once __DIR__ . '/../services/VehicleCheckService.php';

registerCrudRoutes('vehicle_checks', 'VehicleCheckService');
