<?php

namespace App\Http\Repository;

use App\Http\ViewModel\ResponseModel;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Exception;
use Hash;
use Log;
use Str;

interface IUserRepository
{
    function register(array $register);
    function login(array $register);
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

    public function login(array $register)
    {
        try {
            $user = User::where("email", $register["email"])->first();
            if($user == null){
                return ResponseModel::Ok(
                    __("error_message.user_not_found"),
                    "",
                );
            }
            
            if (Hash::check($register['password'],$user->password)) {
                $token = $user->createToken(Str::uuid7().$user->name, expiresAt: Carbon::now("utc")->addMinutes(30));
                return ResponseModel::Ok(
                    __("success_message.user_login_message",["name"=>$user->name]),
                    $token->plainTextToken,
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
