<?php

use App\Http\Repository\ICrudRepository;


interface IInventoryOrderRepository extends ICrudRepository{

}

class InventoryOrderRepository implements IInventoryOrderRepository{
    public function create(array $request){

    }
    public function update(int $id, array $request){

    }
    public function delete(int $id){

    }
    public function get(int $id){

    }
    public function all(){
        
    }
}