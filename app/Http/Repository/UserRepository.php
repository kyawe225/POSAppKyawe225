<?php

namespace App\Http\Repository;

use App\Http\ViewModel\ResponseModel;
use App\Models\User;
use Exception;
use Hash;
use Log;

interface IUserRepository
{
    function register(array $register);
}

class UserRepository implements IUserRepository
{
    public function register(array $register)
    {
        try {
            if (User::where("email", $register["email"])->exists()) {
                return ResponseModel::Ok(
                    __("error_message.user_duplicate_email_message"),
                    "",
                );
            }
            $register["password"] = Hash::make($register["password"]);
            $user = User::create($register);
            $success = $user->save();
            if ($success) {
                return ResponseModel::Ok(
                    __("success_message.user_register_message"),
                    "",
                );
            }
            return ResponseModel::Ok(
                __("error_message.user_register_message"),
                "",
            );
        } catch (Exception $e) {
            Log::error("UserRepository->register => " . $e->getMessage());
            return ResponseModel::Ok(
                __("error_message.user_register_message"),
                "",
            );
        }
    }
}
