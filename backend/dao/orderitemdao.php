<?php
require_once __DIR__ . '/BaseDao.php';
class OrderItemDao extends BaseDao {
    protected string $table = 'order_items';
    protected array $fields = ['order_id', 'product_id', 'quantity', 'price'];
}