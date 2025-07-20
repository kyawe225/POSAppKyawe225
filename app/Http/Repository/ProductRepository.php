<?php

namespace App\Http\Repository;

use App\Http\ViewModel\ResponseModel;
use App\Models\User;
use Exception;
use Hash;
use Log;

interface IProductRepository extends ICrudRepository {}

class ProductRepository implements IProductRepository
{
    public function create(array $request) {}
    public function update(int $id, array $array) {}
    public function delete(int $id) {}
    public function all() {}
    public function get(int $id) {}
}
