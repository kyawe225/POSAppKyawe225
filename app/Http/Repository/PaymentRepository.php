<?php
namespace App\Http\Repository;

use App\Http\ViewModel\ResponseModel;
use App\Models\CuponUsageRecord;
use App\Models\PromoCupon;
use Arr;
use Carbon\Carbon;
use DB;
use Exception;
use App\Models\Payment;
use Log;
use Str;

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
        try {
            DB::beginTransaction();
            $response = $this->cuponUsage($request);

            if($response == "NG"){
                return $response;
            }

            $payment = Arr::except($request, "cupon_code");
            $payment['transaction_id'] = "tran_" . Str::uuid7();
            $payment['payment_status'] = "completed";
            $payment['payment_date'] = Carbon::now('UTC');
            $pay = Payment::create($payment);

            $success = $pay->save();

            DB::commit();
            if (!$success) {
                return ResponseModel::fail("", "");
            }
            Log::info("PaymentRepository.create => Saved payment successfully!");
            return ResponseModel::Ok("", "");
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("PaymentRepository.create => ${$e->getMessage()}");
            return ResponseModel::fail("", "");
        }

    }

    private function cuponUsage(&$request)
    {
        if (array_key_exists('cupon_code', $request)) {
            $cupon_usage = [];
            $cupon = PromoCupon::where("cupon_code", $request['cupon_code'])->orWhere("cupon_code", $request['cupon_code'])->first();
            if ($cupon != null) {
                if ($cupon->minimum_purchase_amount < $request['amount']) {
                    return ResponseModel::fail("", "");
                }
                if (Carbon::now('utc') >= $cupon->valid_from && Carbon::now("utc") <= $cupon->valid_until) {
                    return ResponseModel::fail("", "");
                }
                if ($cupon->usage_limit < $cupon->usage_count) {
                    $cupon->usage_count++;
                    return ResponseModel::fail("", "");
                }
                $total_discount = $cupon->discount_type == "percentage" ? $request["amount"] * ($cupon->discount_value / 100) : $cupon->discount_value;
                $cupon_usage = [
                    "cupon_id" => $cupon->id,
                    "order_id" => $request["order_id"],
                    "cms_user_id" => $request["cms_user_id"],
                    "customer_id" => Str::uuid7(),
                    "usage_date" => Carbon::now('UTC'),
                    "discount_value" => $cupon->discount_value,
                    "discount_type" => $cupon->discount_type
                ];
                $request['amount'] -= $total_discount;
                $cupon->save();
                if (count($cupon_usage) != 0) {
                    $model = CuponUsageRecord::create($cupon_usage);
                    $model->save();
                }
            }
        }
        return ResponseModel::Ok("","");
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
            $supplier = Payment::where("id", $id)->with("payment_methods")->first();
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