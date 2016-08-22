<?php

namespace App\Services;

use Cloudder;

trait FileUpload
{
    public function cloudder($fileName, $path)
    {
        Cloudder::upload($fileName, $path);
        $result = Cloudder::getResult()['url'];

        return $result;
    }
}
