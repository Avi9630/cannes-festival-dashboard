<?php

namespace App\Http\Traits;

use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;

trait LOGTrait
{
    public function LogApi($data)
    {
        $log = new Logger($data['instance']);
        $log->pushHandler(new RotatingFileHandler(storage_path() . '/' . date('Y-m-d') . '/' . $data['dir'] . '/logs.txt'), 2);
        $requestMessage = json_encode($data['data']);
        $log->info($requestMessage);
    }
}
