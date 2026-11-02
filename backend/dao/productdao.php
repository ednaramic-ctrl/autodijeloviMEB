<?php
require_once __DIR__ . '/BaseDao.php';
class ProductDao extends BaseDao {
    protected string $table = 'products';
    protected array $fields = ['name', 'description', 'price', 'stock', 'category_id'];
}
