
<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../dao/categorydao.php';

class CategoryService {

    private $dao;

    public function __construct() {
        $this->dao = new CategoryDao(Database::connection());
    }

    public function getAll() {
        return $this->dao->getAll();
    }

    public function getById($id) {
        if ($id <= 0) {
            throw new InvalidArgumentException("Invalid category ID");
        }

        $category = $this->dao->getById($id);

        if (!$category) {
            throw new Exception("Category not found");
        }

        return $category;
    }

    public function create($data) {
        if (empty($data['name'])) {
            throw new InvalidArgumentException("Category name is required");
        }

        return $this->dao->create($data);
    }

    public function update($id, $data) {
        if ($id <= 0 || empty($data['name'])) {
            throw new InvalidArgumentException("Invalid category data");
        }

        return $this->dao->update($id, $data);
    }

    public function delete($id) {
        if ($id <= 0) {
            throw new InvalidArgumentException("Invalid category ID");
        }

        return $this->dao->delete($id);
    }
}
