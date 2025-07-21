<?php

namespace App\Http\Repository;

use App\Http\ViewModel\ResponseModel;
use App\Models\Product;
use App\Models\User;
use Arr;
use Carbon\Carbon;
use DB;
use Exception;
use Hash;
use Log;
use Str;

interface IProductRepository extends ICrudRepository {
    function filterByCategory(int $categoryId);
    function filterByCategoryPagination(int $categoryId);
}

class ProductRepository implements IProductRepository
{
    public function create(array $request)
    {
        $exists = Product::where("name", $request["name"])
            ->exists();
        if ($exists) {
            return ResponseModel::fail("", ""); // some kind of myanmar or english text.
        }
        $request['status'] = "inactive";
        $request['sku'] = "sku_" . Str::uuid7();
        $request["attribute"]=json_encode(json_decode($request["attribute"]));
        $supplier = Product::create($request);
        $inserted = $supplier->save();
        if (!$inserted) {
            return ResponseModel::fail("", "");
        }
        return ResponseModel::Ok("", "");
    }
    public function update(int $id, array $request)
    {
        $exists = Product::where("name", $request["name"])->where("id","!=",$id)
            ->exists();
        if ($exists) {
            return ResponseModel::fail("", ""); // some kind of myanmar or english text.
        }
        $product = Product::where("id", $id)->first();
        if ($product == null) {
            return ResponseModel::fail("", "");
        }
        
        $updated = $product->update(Arr::except($request,"sku"));
        if (!$updated) {
            return ResponseModel::fail("", "");
        }
        return ResponseModel::Ok("", "");
    }
    public function delete(int $id)
    {
        try {
            $product = Product::where("id", $id)->first();
            if ($product == null) {
                return ResponseModel::fail("", "");
            }
            DB::beginTransaction();
            $updated = $product->delete();
            DB::commit();
            if (!$updated) {
                return ResponseModel::fail("", "");
            }
            return ResponseModel::Ok("", "");
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("ProductRepository.Delete => ${$e->getMessage()}");
            return ResponseModel::fail("", "");
        }
    }
    public function all()
    {
        try {
            $products = Product::orderByDesc("created_at")->get();
            if ($products == null) {
                return ResponseModel::fail("", "");
            }

            return ResponseModel::Ok("", $products);
        } catch (Exception $e) {
            Log::error("ProductRepository.all => ${$e->getMessage()}");
            return ResponseModel::fail("", "");
        }
    }
    public function get(int $id)
    {
        try {
            $product = Product::where("id", $id)->first();
            if ($product == null) {
                return ResponseModel::fail("", "");
            }

            return ResponseModel::Ok("", $product);
        } catch (Exception $e) {
            Log::error("ProductRepository.get => ${$e->getMessage()}");
            return ResponseModel::fail("", "");
        }
    }

    public function filterByCategory(int $categoryId){
        try {
            $product = Product::where("category_id", $categoryId)->orderBy("name")->get();
            if ($product == null) {
                return ResponseModel::fail("", "");
            }

            return ResponseModel::Ok("", $product);
        } catch (Exception $e) {
            Log::error("ProductRepository.get => ${$e->getMessage()}");
            return ResponseModel::fail("", "");
        }
    }

    public function filterByCategoryPagination(int $categoryId){
        try {
            $product = Product::where("category_id", $categoryId)->orderBy("name")->paginate(env("PerPage",20));
            if ($product == null) {
                return ResponseModel::fail("", "");
            }

            return ResponseModel::Ok("", $product);
        } catch (Exception $e) {
            Log::error("ProductRepository.get => ${$e->getMessage()}");
            return ResponseModel::fail("", "");
        }
    }
}
