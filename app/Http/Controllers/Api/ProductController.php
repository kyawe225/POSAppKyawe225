<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repository\IProductRepository;
use App\Http\Requests\Product\ProductCreateRequest;
use App\Http\Requests\Product\ProductUpdateRequest;

class ProductController extends Controller
{
    public function __construct(protected readonly IProductRepository $repository)
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

    public function getByCategory(int $id)
    {
        $data = $this->repository->filterByCategory($id);
        return response()->json($data);
    }

    public function getByCategoryPagination(int $id)
    {
        $data = $this->repository->filterByCategoryPagination($id);
        return response()->json($data);
    }

    public function insert(ProductCreateRequest $request)
    {
        $validated = $request->validated();
        $response = $this->repository->create($validated);
        return response()->json($response);
    }

    public function update(int $id, ProductUpdateRequest $request)
    {
        $validated = $request->validated();
        $response = $this->repository->update($id, $validated);
        return response()->json($response);
    }

    public function delete(int $id)
    {
        $response = $this->repository->delete($id);
        return response()->json($response);
    }
}
