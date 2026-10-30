<?php
require_once __DIR__ . '/BaseDao.php';
class CategoryDao extends BaseDao {
    protected string $table = 'categories';
    protected array $fields = ['name', 'description'];
}
