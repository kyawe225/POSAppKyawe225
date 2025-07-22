<?php

namespace App\Http\Repository;

use App\Http\ViewModel\ResponseModel;
use App\Models\InventoryLog;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Arr;
use Carbon\Carbon;
use DB;
use Exception;
use Hash;
use Log;
use Str;

interface IOrderRepository extends ICrudRepository
{
    function summary(array $request);
}

class OrderRepository implements IOrderRepository
{
    public function create(array $request)
    {
        try {
            //#region data prepare
            $order = Arr::except($request, "order_items");
            $order_items = $request["order_items"];
            $order['order_number'] = Str::uuid7();
            $order['order_date'] = Carbon::now("utc");
            //#endregion
            DB::beginTransaction();
            $orderModel = Order::create($order);
            $inserted = $orderModel->save();
            foreach ($order_items as $o) {
                $o['order_id'] = $orderModel->id;
                $response = $this->productChanges($o);
                if ($response->status == "NG") {
                    return $response;
                }
                $this->inventoryLogChanges($o,$orderModel);
                $item = OrderItem::create($o);
                $item->save();
                
            }
            DB::commit();
            if (!$inserted) {
                return ResponseModel::fail("a", "");
            }
            return ResponseModel::Ok("b", "");
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("OrderRepository.Create => ${$e->getMessage()}");
            return ResponseModel::fail("c", "");
        }

    }

    private function inventoryLogChanges(array $o,Order $orderModel)
    {
        $inventoryLog = [
            "order_id" => $orderModel->id,
            "product_id" => $o['product_id'],
            "number_of_items" => $o['quantity'],
            "transaction_type" => 'sale',
            "transaction_date" => Carbon::now('utc'),
            "current_stock" => 0, // this is bull shit.
            "unit_cost" => $o["unit_price"],
            "notes" => "system generated"
        ];
        $log = InventoryLog::create($inventoryLog);
        $log->save();
    }

    private function productChanges(array $o)
    {
        $product = Product::where("id", $o['product_id'])->where("status", "active")->first();
        if ($product == null)
            return ResponseModel::fail("", "");
        $product->quantity -= $o['quantity'];
        $product->save();
        return ResponseModel::Ok("", "");
    }
    // this will be complicated one too bad i don't fix for those
    public function update(int $id, array $request)
    {

    }
    public function delete(int $id)
    {
        try {
            $order = Order::where("id", $id)->first();
            if ($order == null) {
                return ResponseModel::fail("", "");
            }
            DB::beginTransaction();
            OrderItem::where('order_id', $order->id)->delete();
            $updated = $order->delete();
            DB::commit();
            if (!$updated) {
                return ResponseModel::fail("", "");
            }
            return ResponseModel::Ok("", "");
        } catch (Exception $e) {
            Log::error("ProductCategoryRepository.Delete => ${$e->getMessage()}");
            return ResponseModel::fail("", "");
        }
    }

    public function summary(array $request){

    }

    public function all()
    {
        try {
            $orders = Order::with(["order_items", "order_items.product"])->get();
            if ($orders == null || $orders->count() <= 0) {
                return ResponseModel::fail("", "");
            }

            return ResponseModel::Ok("", $orders);
        } catch (Exception $e) {
            Log::error("ProductCategoryRepository.all => ${$e->getMessage()}");
            return ResponseModel::fail("", "");
        }
    }
    public function get(int $id)
    {
        try {
            $order = Order::where("id", $id)->with(["order_items", "order_items.product"])->first();
            if ($order == null) {
                return ResponseModel::fail("", $order);
            }

            return ResponseModel::Ok("", $order);
        } catch (Exception $e) {
            Log::error("ProductCategoryRepository.get => ${$e->getMessage()}");
            return ResponseModel::fail("", "");
        }
    }
}
