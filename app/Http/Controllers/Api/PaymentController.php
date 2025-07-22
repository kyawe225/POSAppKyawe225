<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repository\IPaymentRepository;
use App\Http\Requests\Cupon\CuponCreateRequest;
use App\Http\Requests\Cupon\CuponUpdateRequest;
use App\Http\Requests\Payment\PaymentCreateRequest;

class PaymentController extends Controller
{
    public function __construct(protected readonly IPaymentRepository $repository)
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

    public function insert(PaymentCreateRequest $request)
    {
        $validated = $request->validated();
        $response = $this->repository->create($validated);
        return response()->json($response);
    }

    public function delete(int $id)
    {
        $response = $this->repository->delete($id);
        return response()->json($response);
    }
}
