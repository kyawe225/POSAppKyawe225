<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function __construct(protected readonly ICuponRepository $repository)
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

    public function insert(CuponCreateRequest $request)
    {
        $validated = $request->validated();
        $response = $this->repository->create($validated);
        return response()->json($response);
    }

    public function update(int $id, CuponUpdateRequest $request)
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
