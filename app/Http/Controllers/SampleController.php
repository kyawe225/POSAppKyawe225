<?php

namespace App\Http\Controllers;

use App\Http\Repository\IUserRepository;
use Illuminate\Routing\Controller;

class SampleController extends Controller
{
    public function __construct(private readonly IUserRepository $repository) {}

    public function hello()
    {
        return "Hello";
    }
}
