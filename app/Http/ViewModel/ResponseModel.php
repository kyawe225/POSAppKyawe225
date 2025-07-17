<?php
namespace App\Http\ViewModel;

class ResponseModel
{
    public string $status;
    public string $message;
    public $data;

    private function __construct(string $status, string $message, $data)
    {
        $this->status = $status;
        $this->message = $message;
        $this->data = $data;
    }

    public static function Ok(string $message, $data)
    {
        return new ResponseModel("OK", $message, $data);
    }
    public static function fail(string $message, $data)
    {
        return new ResponseModel("NG", $message, $data);
    }
}
