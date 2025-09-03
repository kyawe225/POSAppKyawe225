<?php

namespace App\Http\Repository;

use App\Http\Repository\ICrudRepository;
use App\Http\ViewModel\ResponseModel;
use App\Models\InventoryOrder;
use App\Models\Product;
use Carbon\Carbon;


interface IInventoryOrderRepository extends ICrudRepository
{

}

class InventoryOrderRepository implements IInventoryOrderRepository
{
    public function create(array $request)
    {
        $request["status"] = "ordered";
        $inventory = InventoryOrder::create($request);
        $save = $inventory->save();
        if (!$save)
            return Response::fail("", "");
        return ResponseModel::Ok("", "");
    }
    public function update(int $id, array $request)
    {
        try {
            $inventory = InventoryOrder::where("id", $id)->first();
            DB::beginTransaction();
            $save = $inventory->update($request);
            if ($request["status"] == "delivered") {
                $product = Product::where("id", $id)->first();

                $inventoryLog = [
                    "order_id" => $request->id,
                    "product_id" => $request['product_id'],
                    "number_of_items" => $request['quantity'],
                    "transaction_type" => 'purchase',
                    "transaction_date" => Carbon::now('utc'),
                    "current_stock" => 0, // this is bull shit.
                    "unit_cost" => $product->unit_price,
                    "notes" => "system generated"
                ];

                $log = InventoryLog::create($inventoryLog);
                $log->save();


                $product->quantity += $request['quantity'];
                $product->save();
            }
            DB::commit();

            if (!$save)
                return Response::fail("", "");

            return ResponseModel::Ok("", "");
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("InventoryOrder.Update => ${$e->getMessage()}");
            return ResponseModel::fail("c", "");
        }

    }
    public function delete(int $id)
    {
        $inventory = InventoryOrder::where("id", $id)->first();
        $save = $inventory->delete();

        if (!$save)
            return Response::fail("", "");

        return ResponseModel::Ok("", "");
    }
    public function get(int $id)
    {
        $inventory = InventoryOrder::where("id", $id)->first();

        if ($inventory == null)
            return Response::fail("", "");

        return ResponseModel::Ok("", $inventory);
    }
    public function all()
    {
        $inventory = InventoryOrder::all();

        if ($inventory == null)
            return Response::fail("", "");

        return ResponseModel::Ok("", $inventory);
    }
}