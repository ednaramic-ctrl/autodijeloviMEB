
<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../dao/orderitemdao.php';

class OrderItemService {

    private $dao;

    public function __construct() {
        $this->dao = new OrderItemDao(Database::connection());
    }

    public function getAll() {
        return $this->dao->getAll();
    }

    public function getById($id) {
        if ($id <= 0) {
            throw new InvalidArgumentException("Invalid order item ID");
        }

        $item = $this->dao->getById($id);

        if (!$item) {
            throw new Exception("Order item not found");
        }

        return $item;
    }

    public function create($data) {
        if (empty($data['order_id']) || empty($data['product_id'])) {
            throw new InvalidArgumentException("Order and product are required");
        }

        if (empty($data['quantity']) || $data['quantity'] <= 0) {
            throw new InvalidArgumentException("Quantity must be greater than zero");
        }

        if (!isset($data['price']) || !is_numeric($data['price']) || $data['price'] < 0) {
            throw new InvalidArgumentException("Invalid price");
        }

        return $this->dao->create($data);
    }

    public function update($id, $data) {
        if ($id <= 0) {
            throw new InvalidArgumentException("Invalid order item ID");
        }

        if (isset($data['quantity']) && $data['quantity'] <= 0) {
            throw new InvalidArgumentException("Invalid quantity");
        }

        return $this->dao->update($id, $data);
    }

    public function delete($id) {
        if ($id <= 0) {
            throw new InvalidArgumentException("Invalid order item ID");
        }

        return $this->dao->delete($id);
    }
}
