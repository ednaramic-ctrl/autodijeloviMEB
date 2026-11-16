
<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../dao/userdao.php';

class UserService {

    private $dao;

    public function __construct() {
        $this->dao = new UserDao(Database::connection());
    }

    public function getAll() {
        return $this->dao->getAll();
    }

    public function getById($id) {
        if ($id <= 0) {
            throw new InvalidArgumentException("Invalid user ID");
        }

        $user = $this->dao->getById($id);

        if (!$user) {
            throw new Exception("User not found");
        }

        return $user;
    }

    public function create($data) {
        if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
            throw new InvalidArgumentException("All fields are required");
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Invalid email");
        }

        if (strlen($data['password']) < 6) {
            throw new InvalidArgumentException("Password must have at least 6 characters");
        }

        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        return $this->dao->create($data);
    }

    public function update($id, $data) {
        if ($id <= 0) {
            throw new InvalidArgumentException("Invalid user ID");
        }

        if (isset($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Invalid email");
        }

        return $this->dao->update($id, $data);
    }

    public function delete($id) {
        if ($id <= 0) {
            throw new InvalidArgumentException("Invalid user ID");
        }

        return $this->dao->delete($id);
    }
}
