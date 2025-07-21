<?php
namespace App\Http\Repository;

use Exception;
use App\Models\Payment;

interface IPaymentRepository extends ICrudRepository
{

}
// this should use payment and promocode usages.
class PaymentRepository implements IPaymentRepository
{
    // implement later
    // first create the payment object 
    // second create the cupon_usage_record if they use cupon.
    // charge case will not be happening
    // will do later
    public function create(array $request)
    {
        $payment = Arr::except($request,"cupon_code");
        $pay= Payment::create($payment);
        return $pay;
    }
    // for now no update for this payment because customer will pay from cashier
    public function update(int $id, array $request)
    {
        // $exists = Product::where(function($query) use ($request) {
        //     $query->where("name", $request["name"])
        //     ->orWhere("email", $request["email"]);
        // })->where("id","<>",$id)
        //     ->exists();
        // if ($exists) {
        //     return ResponseModel::fail("", ""); // some kind of myanmar or english text.
        // }
        // $supplier = Product::where("id", $id)->first();
        // if ($supplier == null) {
        //     return ResponseModel::fail("", "");
        // }
        // $updated = $supplier->update($request);
        // if (!$updated) {
        //     return ResponseModel::fail("", "");
        // }
        // return ResponseModel::Ok("", "");
    }
    public function delete(int $id)
    {
        try {
            $supplier = Payment::where("id", $id)->first();
            if ($supplier == null) {
                return ResponseModel::fail("", "");
            }
            DB::beginTransaction();
            $supplier->update([
                "status" => "inactive",
            ]);
            $updated = $supplier->delete();
            DB::commit();
            if (!$updated) {
                return ResponseModel::fail("", "");
            }
            return ResponseModel::Ok("", "");
        } catch (Exception $e) {
            Log::error("SupplierRepository.Delete => ${$e->getMessage()}");
            return ResponseModel::fail("", "");
        }
    }
    public function all()
    {
        try {
            $supplier = Payment::orderByDesc("created_at")->get();
            if ($supplier == null) {
                return ResponseModel::fail("", "");
            }

            return ResponseModel::Ok("", $supplier);
        } catch (Exception $e) {
            Log::error("SupplierRepository.all => ${$e->getMessage()}");
            return ResponseModel::fail("", "");
        }
    }
    public function get(int $id)
    {
        try {
            $supplier = Payment::where("id", $id)->first();
            if ($supplier == null) {
                return ResponseModel::fail("", "");
            }

            return ResponseModel::Ok("", $supplier);
        } catch (Exception $e) {
            Log::error("SupplierRepository.get => ${$e->getMessage()}");
            return ResponseModel::fail("", "");
        }
    }
}
?>