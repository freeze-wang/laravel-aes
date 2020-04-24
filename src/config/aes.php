<?php

use Illuminate\Support\Str;

return [
    'encode_name' => env('AES_ENCODE_NAME','aes_encode'),   //请求参数的名称
    'signKey'=>env('AES_SIGNKEY',''),                       //aes密钥
];
