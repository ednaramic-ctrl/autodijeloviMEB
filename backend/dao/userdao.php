<?php
require_once __DIR__ . '/BaseDao.php';
class UserDao extends BaseDao {
    protected string $table = 'users';
    protected array $fields = ['name', 'email', 'password', 'role'];
}
