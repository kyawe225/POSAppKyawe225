<?php

namespace App\Http\Repository;

use App\Http\ViewModel\ResponseModel;
use App\Models\User;
use Exception;
use Hash;
use Log;

interface IProductRepository
{
    function register(array $register);
}
