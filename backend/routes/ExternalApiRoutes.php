
<?php

require_once __DIR__ . '/../services/ExternalApiService.php';

Flight::route('GET /external/cars', function() {

    $make = Flight::request()->query->make;
    $model = Flight::request()->query->model ?? '';

    if (empty($make)) {
        Flight::json(['error' => 'Car make is required'], 400);
        return;
    }

    try {
        $service = new ExternalApiService();
        $result = $service->getCars($make, $model);

        Flight::json($result, 200);

    } catch (Throwable $e) {
        Flight::json([
            'error' => $e->getMessage()
        ], 500);
    }
});

