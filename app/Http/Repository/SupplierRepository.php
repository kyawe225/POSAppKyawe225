<?php

namespace App\Http\Repository;

use App\Http\ViewModel\ResponseModel;
use DB;
use Exception;
use Log;
use App\Models\Supplier;

interface ISupplierRepository extends ICrudRepository {}

class SupplierRepository implements ISupplierRepository
{
    public function create(array $request)
    {
        $exists = Supplier::where("name", $request["name"])
            ->orWhere("email", $request["email"])
            ->exists();
        if ($exists) {
            return ResponseModel::fail("", ""); // some kind of myanmar or english text.
        }
        $supplier = Supplier::create($request);
        $inserted = $supplier->save();
        if (!$inserted) {
            return ResponseModel::fail("", "");
        }
        return ResponseModel::Ok("", "");
    }
    public function update(int $id, array $request)
    {
        $exists = Supplier::where(function($query) use ($request) {
            $query->where("name", $request["name"])
            ->orWhere("email", $request["email"]);
        })->where("id","<>",$id)
            ->exists();
        if ($exists) {
            return ResponseModel::fail("", ""); // some kind of myanmar or english text.
        }
        $supplier = Supplier::where("id", $id)->first();
        if ($supplier == null) {
            return ResponseModel::fail("", "");
        }
        $updated = $supplier->update($request);
        if (!$updated) {
            return ResponseModel::fail("", "");
        }
        return ResponseModel::Ok("", "");
    }
    public function delete(int $id)
    {
        try {
            $supplier = Supplier::where("id", $id)->first();
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
            $supplier = Supplier::orderByDesc("created_at")->get();
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
            $supplier = Supplier::where("id", $id)->first();
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
