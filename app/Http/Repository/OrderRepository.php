<?php

namespace App\Http\Repository;

use App\Http\ViewModel\ResponseModel;
use App\Models\Order;
use Carbon\Carbon;
use DB;
use Exception;
use Hash;
use Log;
use Str;

interface IOrderRepository extends ICrudRepository
{
}

class OrderRepository implements ICuponRepository
{
    public function create(array $request)
    {
        try {
            $order = Arr::except($request, "order_items");
            DB::beginTransaction();
            $orderModel = Order::create($order);
            $inserted = $orderModel->save();
            $order_items = $request["order_items"];
            foreach ($order_items as $o) {
                $o['order_id'] = $orderModel->id;
                OrderItem::create($o);
            }
            DB::commit();
            if (!$inserted) {
                return ResponseModel::fail("", "");
            }
            return ResponseModel::Ok("", "");
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("OrderRepository.Create => ${$e->getMessage()}");
            return ResponseModel::fail("", "");
        }

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
            OrderItem::where('order_id',$order->id)->delete();
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
    public function all()
    {
        try {
            $orders = Order::with(["order_items","order_items.product"])->get();
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
            $order = Order::where("id", $id)->with(["order_items","order_items.product"])->first();
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
