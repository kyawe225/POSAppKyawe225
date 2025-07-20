<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repository\IProductCategoryRepository;
use App\Http\Requests\Product\ProductCategoryCreateRequest;
use App\Http\Requests\Product\ProductCategoryUpdateRequest;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function __construct(protected readonly IProductCategoryRepository $repository)
    {

    }

    public function index()
    {
        $data = $this->repository->all();
        return response()->json($data);
    }
    public function getDetail(int $id)
    {
        $data = $this->repository->get($id);
        return response()->json($data);
    }

    public function insert(ProductCategoryCreateRequest $request)
    {
        $validated = $request->validated();
        $response = $this->repository->create($validated);
        return response()->json($response);
    }

    public function update(ProductCategoryUpdateRequest $request, int $id)
    {
        $validated = $request->validated();
        $response = $this->repository->update($id,$validated);
        return response()->json($response);
    }

    public function delete(int $id)
    {
        $response = $this->repository->delete($id);
        return response()->json($response);
    }
}
