<?php

namespace App\Http\Repository;

interface ICrudRepository
{
    public function create(array $request);
    public function update(int $id, array $request);
    public function delete(int $id);
    public function get(int $id);
    public function all();
}
