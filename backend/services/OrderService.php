
<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../dao/orderdao.php';

class OrderService {

    private $dao;

    public function __construct() {
        $this->dao = new OrderDao(Database::connection());
    }

    public function getAll() {
        return $this->dao->getAll();
    }

    public function getById($id) {
        if ($id <= 0) {
            throw new InvalidArgumentException("Invalid order ID");
        }

        $order = $this->dao->getById($id);

        if (!$order) {
            throw new Exception("Order not found");
        }

        return $order;
    }

    public function create($data) {
        if (empty($data['user_id'])) {
            throw new InvalidArgumentException("User ID is required");
        }

        if (!isset($data['total']) || !is_numeric($data['total']) || $data['total'] < 0) {
            throw new InvalidArgumentException("Invalid order total");
        }

        return $this->dao->create($data);
    }

    public function update($id, $data) {
        if ($id <= 0) {
            throw new InvalidArgumentException("Invalid order ID");
        }

        if (isset($data['total']) && (!is_numeric($data['total']) || $data['total'] < 0)) {
            throw new InvalidArgumentException("Invalid total");
        }

        return $this->dao->update($id, $data);
    }

    public function delete($id) {
        if ($id <= 0) {
            throw new InvalidArgumentException("Invalid order ID");
        }

        return $this->dao->delete($id);
    }
}
