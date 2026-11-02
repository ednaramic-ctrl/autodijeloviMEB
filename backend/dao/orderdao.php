<?php
require_once __DIR__ . '/BaseDao.php';
class OrderDao extends BaseDao {
    protected string $table = 'orders';
    protected array $fields = ['user_id', 'order_date', 'total'];
}
