<?php

namespace App\Http\Repository;

use App\Http\ViewModel\ResponseModel;
use App\Models\ProductCategory;
use App\Models\User;
use Exception;
use Hash;
use Log;

interface IProductCategoryRepository extends ICrudRepository
{
}

class ProductCategoryRepository implements IProductCategoryRepository
{
    public function create(array $request)
    {
        $exists = ProductCategory::where("name", $request["name"])
            ->exists();
        if ($exists) {
            return ResponseModel::fail("", ""); // some kind of myanmar or english text.
        }
        $request['is_active'] = false;
        $supplier = ProductCategory::create($request);
        $inserted = $supplier->save();
        if (!$inserted) {
            return ResponseModel::fail("", "");
        }
        return ResponseModel::Ok("", "");
    }
    public function update(int $id, array $request)
    {
        $exists = ProductCategory::where("name", $request["name"])->where("id","<>",$id)
            ->exists();
        if ($exists) {
            return ResponseModel::fail("", ""); // some kind of myanmar or english text.
        }
        $productCategory = ProductCategory::where("id", $id)->first();
        if ($productCategory == null) {
            return ResponseModel::fail("", "");
        }
        $updated = $productCategory->update($request);
        if (!$updated) {
            return ResponseModel::fail("", "");
        }
        return ResponseModel::Ok("", "");
    }
    public function delete(int $id)
    {
        try {
            $productCategory = ProductCategory::where("id", $id)->first();
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
            $productCategories = ProductCategory::orderByDesc("created_at")->get();
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
            $productCategory = ProductCategory::where("id", $id)->first();
            if ($productCategory == null) {
                return ResponseModel::fail("", "");
            }

            return ResponseModel::Ok("", $productCategory);
        } catch (Exception $e) {
            Log::error("ProductCategoryRepository.get => ${$e->getMessage()}");
            return ResponseModel::fail("", $productCategory);
        }
    }
}
