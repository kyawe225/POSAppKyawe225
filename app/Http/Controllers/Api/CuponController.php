<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repository\ICuponRepository;
use App\Http\Requests\Cupon\CuponCreateRequest;
use App\Http\Requests\Cupon\CuponUpdateRequest;

class CuponController extends Controller
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

    public function check(){
        $validated= request()->validate([
            "cupon_code"=>"required|string",
            "subtotal"=> "required|decimal:2"
        ]);
        $cupon_code = request()->input("cupon_code");
        $subtotal = request()->input("subtotal");
        $response = $this->repository->check($cupon_code,$subtotal);
        return response()->json($response);
    }
}
