<?php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../config/Database.php';
$entities = [
    'users' => 'User', 'vehicle_checks' => 'VehicleCheck',
    'categories' => 'Category', 'products' => 'Product',
    'orders' => 'Order', 'order_items' => 'OrderItem'
];
$entity = $_GET['entity'] ?? '';
if (!isset($entities[$entity])) {
    http_response_code(404);
    echo json_encode(['error' => 'Unknown entity']); exit;
}
// Educational local CRUD demo only. Add authentication/authorization before deployment.
if ($entity === 'users') {
    http_response_code(403);
    echo json_encode(['error' => 'User management requires authentication; use UserDao server-side']); exit;
}
require_once __DIR__ . '/../dao/' . $entities[$entity] . 'Dao.php';
try {
    $class = $entities[$entity] . 'Dao';
    $dao = new $class(Database::connection());
    $method = $_SERVER['REQUEST_METHOD'];
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $body = json_decode(file_get_contents('php://input'), true);
    if (in_array($method, ['POST','PUT','PATCH'], true) && !is_array($body)) {
        throw new InvalidArgumentException('JSON object required');
    }
    if ($method === 'GET') $result = $id ? $dao->getById($id) : $dao->getAll();
    elseif ($method === 'POST') { $result = ['id' => $dao->create($body)]; http_response_code(201); }
    elseif (in_array($method, ['PUT','PATCH'], true) && $id) $result = ['updated' => $dao->update($id, $body)];
    elseif ($method === 'DELETE' && $id) $result = ['deleted' => $dao->delete($id)];
    else { http_response_code(405); $result = ['error' => 'Unsupported method or missing id']; }
    if ($result === null) http_response_code(404);
    echo json_encode($result);
} catch (InvalidArgumentException $e) {
    http_response_code(400); echo json_encode(['error' => $e->getMessage()]);
} catch (PDOException $e) {
    http_response_code(400); echo json_encode(['error' => 'Database operation failed; check data and foreign keys']);
} catch (Throwable $e) {
    http_response_code(500); echo json_encode(['error' => 'Server configuration error']);
}
