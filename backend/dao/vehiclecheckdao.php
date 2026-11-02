<?php
require_once __DIR__ . '/BaseDao.php';
class VehicleCheckDao extends BaseDao {
    protected string $table = 'vehicle_checks';
    protected array $fields = ['user_id', 'brand', 'model', 'year', 'part'];
}