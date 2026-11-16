
<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../dao/vehiclecheckdao.php';

class VehicleCheckService {

    private $dao;

    public function __construct() {
        $this->dao = new VehicleCheckDao(Database::connection());
    }

    public function getAll() {
        return $this->dao->getAll();
    }

    public function getById($id) {
        if ($id <= 0) {
            throw new InvalidArgumentException("Invalid vehicle check ID");
        }

        $check = $this->dao->getById($id);

        if (!$check) {
            throw new Exception("Vehicle check not found");
        }

        return $check;
    }

    public function create($data) {
        if (empty($data['user_id']) || empty($data['brand']) ||
            empty($data['model']) || empty($data['year']) ||
            empty($data['part'])) {
            throw new InvalidArgumentException("All vehicle fields are required");
        }

        if (!is_numeric($data['year']) || $data['year'] < 1900 || $data['year'] > date('Y') + 1) {
            throw new InvalidArgumentException("Invalid vehicle year");
        }

        return $this->dao->create($data);
    }

    public function update($id, $data) {
        if ($id <= 0) {
            throw new InvalidArgumentException("Invalid vehicle check ID");
        }

        if (isset($data['year']) && ($data['year'] < 1900 || $data['year'] > date('Y') + 1)) {
            throw new InvalidArgumentException("Invalid vehicle year");
        }

        return $this->dao->update($id, $data);
    }

    public function delete($id) {
        if ($id <= 0) {
            throw new InvalidArgumentException("Invalid vehicle check ID");
        }

        return $this->dao->delete($id);
    }
}
