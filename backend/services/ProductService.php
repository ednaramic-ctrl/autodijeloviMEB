
<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../dao/productdao.php';

class ProductService {

    private $productDao;

    public function __construct() {
        $this->productDao = new ProductDao(Database::connection());
    }

    public function getAll() {
        return $this->productDao->getAll();
    }

    public function getById($id) {
        if ($id <= 0) {
            throw new InvalidArgumentException("Invalid product ID");
        }

        $product = $this->productDao->getById($id);

        if (!$product) {
            throw new Exception("Product not found");
        }

        return $product;
    }

    public function create($data) {

        if (empty($data['name'])) {
            throw new InvalidArgumentException("Product name is required");
        }

        if (!isset($data['price']) || !is_numeric($data['price']) || $data['price'] < 0) {
            throw new InvalidArgumentException("Invalid product price");
        }

        if (!isset($data['stock']) || !is_numeric($data['stock']) || $data['stock'] < 0) {
            throw new InvalidArgumentException("Invalid product stock");
        }

        if (empty($data['category_id']) || $data['category_id'] <= 0) {
            throw new InvalidArgumentException("Category is required");
        }

        return $this->productDao->create($data);
    }

    public function update($id, $data) {

        if ($id <= 0) {
            throw new InvalidArgumentException("Invalid product ID");
        }

        if (isset($data['name']) && empty($data['name'])) {
            throw new InvalidArgumentException("Product name cannot be empty");
        }

        if (isset($data['price']) && (!is_numeric($data['price']) || $data['price'] < 0)) {
            throw new InvalidArgumentException("Invalid product price");
        }

        if (isset($data['stock']) && (!is_numeric($data['stock']) || $data['stock'] < 0)) {
            throw new InvalidArgumentException("Invalid product stock");
        }

        return $this->productDao->update($id, $data);
    }

    public function delete($id) {

        if ($id <= 0) {
            throw new InvalidArgumentException("Invalid product ID");
        }

        return $this->productDao->delete($id);
    }
}
