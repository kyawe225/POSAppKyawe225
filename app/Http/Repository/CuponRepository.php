<?php

namespace App\Http\Repository;

use App\Http\ViewModel\ResponseModel;
use App\Models\PromoCupon;
use Carbon\Carbon;
use DB;
use Exception;
use Hash;
use Log;
use Str;

interface ICuponRepository extends ICrudRepository
{
    function check(string $cupon_code,float $subtotal);
}

class CuponRepository implements ICuponRepository
{
    public function create(array $request)
    {
        $exists = PromoCupon::where("cupon_code", $request["cupon_code"])
            ->exists();
        if ($exists) {
            return ResponseModel::fail("", ""); // some kind of myanmar or english text.
        }

        $request['cupon_qr_barcode'] = Str::random(5) . Str::uuid();
        $request["valid_from"] = Carbon::parse($request["valid_from"], 'utc');
        $request["valid_until"] = Carbon::parse($request["valid_until"], 'utc');
        if ($request["valid_from"] > Carbon::now("utc")) {
            $request["status"] = "scheduled";
        } else if ($request['valid_from']->date() == Carbon::now("utc")->date()) {
            $request['status'] = 'active';
        } else if ($request['valid_from']->date() < Carbon::now("utc")->date() || $request['valid_from'] > $request["valid_until"]) {
            return ResponseModel::fail("", "");
        }
        $supplier = PromoCupon::create($request);
        $inserted = $supplier->save();
        if (!$inserted) {
            return ResponseModel::fail("", "");
        }
        return ResponseModel::Ok("", "");
    }
    public function update(int $id, array $request)
    {
        $exists = PromoCupon::where("cupon_code", $request["cupon_code"])->where("id", "<>", $id)
            ->exists();
        if ($exists) {
            return ResponseModel::fail("", ""); // some kind of myanmar or english text.
        }
        $productCategory = PromoCupon::where("id", $id)->first();
        if ($productCategory == null) {
            return ResponseModel::fail("", "");
        }
        $request["valid_from"] = Carbon::parse($request["valid_from"], 'utc');
        $request["valid_until"] = Carbon::parse($request["valid_until"], 'utc');
        $updated = $productCategory->update($request);
        if (!$updated) {
            return ResponseModel::fail("", "");
        }
        return ResponseModel::Ok("", "");
    }
    public function delete(int $id)
    {
        try {
            $exists = CuponUsageRecord::where("cupon_id", $id)->exists();
            if ($exists) {
                return ResponseModel::fail("", "");
            }
            $productCategory = PromoCupon::where("id", $id)->first();
            if ($productCategory == null) {
                return ResponseModel::fail("", "");
            }
            DB::beginTransaction();
            $updated = $productCategory->delete();
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
            $productCategories = PromoCupon::all()->map(function ($p) {
                if ($p->valid_until < Carbon::now("utc")) {
                    $p->status = "expired";
                }
                return $p;
            });
            if ($productCategories == null) {
                return ResponseModel::fail("", "");
            }

            return ResponseModel::Ok("", $productCategories);
        } catch (Exception $e) {
            Log::error("ProductCategoryRepository.all => ${$e->getMessage()}");
            return ResponseModel::fail("", "");
        }
    }
    public function get(int $id)
    {
        try {
            $promoCupon = PromoCupon::where("id", $id)->first();
            if ($promoCupon == null) {
                return ResponseModel::fail("", "");
            }
            if ($promoCupon->valid_until < Carbon::now("utc")) {
                $promoCupon->status = "expired";
            }

            return ResponseModel::Ok("", $promoCupon);
        } catch (Exception $e) {
            Log::error("ProductCategoryRepository.get => ${$e->getMessage()}");
            return ResponseModel::fail("", "");
        }
    }

    public function check(string $cupon_code,$subtotal)
    {
        try {
            $cupon = PromoCupon::where("cupon_code", $cupon_code)->orWhere("cupon_code", $cupon_code)->first();
            if ($cupon != null) {
                if ($cupon->minimum_purchase_amount < $subtotal) {
                    return ResponseModel::fail("", "");
                }
                if (Carbon::now('utc') >= $cupon->valid_from && Carbon::now("utc") <= $cupon->valid_until) {
                    return ResponseModel::fail("", "");
                }
                if ($cupon->usage_limit < $cupon->usage_count) {
                    return ResponseModel::fail("", "");
                }

                return ResponseModel::Ok("", $cupon);
            }
        } catch (Exception $e) {
            Log::error("ProductCategoryRepository.get => ${$e->getMessage()}");
            return ResponseModel::fail("", "");
        }
    }
}
