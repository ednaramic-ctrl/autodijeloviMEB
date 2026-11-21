
<?php

function registerCrudRoutes($url, $serviceClass) {

    Flight::route('GET /' . $url, function() use ($serviceClass) {
        try {
            $service = new $serviceClass();
            Flight::json($service->getAll(), 200);
        } catch (Throwable $e) {
            Flight::json(['error' => 'Server error'], 500);
        }
    });

    Flight::route('GET /' . $url . '/@id', function($id) use ($serviceClass) {
        try {
            $service = new $serviceClass();
            Flight::json($service->getById((int)$id), 200);
        } catch (InvalidArgumentException $e) {
            Flight::json(['error' => $e->getMessage()], 400);
        } catch (Throwable $e) {
            Flight::json(['error' => $e->getMessage()], 404);
        }
    });

    Flight::route('POST /' . $url, function() use ($serviceClass) {
        try {
            $data = json_decode(Flight::request()->getBody(), true);

            if (!is_array($data)) {
                throw new InvalidArgumentException("Invalid JSON data");
            }

            $service = new $serviceClass();
            $id = $service->create($data);

            Flight::json(['id' => $id, 'message' => 'Created successfully'], 201);

        } catch (InvalidArgumentException $e) {
            Flight::json(['error' => $e->getMessage()], 400);
        } catch (Throwable $e) {
            Flight::json(['error' => 'Server error'], 500);
        }
    });

    Flight::route('PUT /' . $url . '/@id', function($id) use ($serviceClass) {
        try {
            $data = json_decode(Flight::request()->getBody(), true);

            if (!is_array($data)) {
                throw new InvalidArgumentException("Invalid JSON data");
            }

            $service = new $serviceClass();
            $result = $service->update((int)$id, $data);

            Flight::json(['updated' => $result], 200);

        } catch (InvalidArgumentException $e) {
            Flight::json(['error' => $e->getMessage()], 400);
        } catch (Throwable $e) {
            Flight::json(['error' => $e->getMessage()], 404);
        }
    });

    Flight::route('DELETE /' . $url . '/@id', function($id) use ($serviceClass) {
        try {
            $service = new $serviceClass();
            $result = $service->delete((int)$id);

            if (!$result) {
                Flight::json(['error' => 'Record not found'], 404);
                return;
            }

            Flight::json(['message' => 'Deleted successfully'], 200);

        } catch (Throwable $e) {
            Flight::json(['error' => 'Delete failed'], 500);
        }
    });
}
