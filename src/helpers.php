<?php


if(!function_exists('aes_encrypt')) {
    function aes_encrypt($string, $key)
    {
        // openssl_encrypt 加密不同Mcrypt，对秘钥长度要求，超出16加密结果不变
        $data = openssl_encrypt($string, 'AES-128-ECB', $key, OPENSSL_RAW_DATA);
        return base64_encode($data);
    }
}
/**
 * @param string $string 需要解密的字符串
 * @param string $key 密钥
 * @return string
 */
if(!function_exists('aes_decrypt')) {
    function aes_decrypt($string, $key)
    {
        //填充值为pkcs7padding
        return openssl_decrypt(base64_decode($string), 'AES-128-ECB', $key, OPENSSL_RAW_DATA);
    }
}
