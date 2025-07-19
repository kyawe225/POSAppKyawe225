<?php

namespace App\Http\Repository;

use App\Http\ViewModel\ResponseModel;
use App\Models\User;
use Exception;
use Hash;
use Log;

interface ICuponRepository
{
    function register(array $register);
}
