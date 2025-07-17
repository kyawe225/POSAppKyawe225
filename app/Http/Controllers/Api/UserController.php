<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repository\IUserRepository;
use App\Http\Requests\User\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        protected readonly IUserRepository $repository,
    ) {}
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();
        $response = $this->repository->register($validated);
        return response()->json($response);
    }
}
