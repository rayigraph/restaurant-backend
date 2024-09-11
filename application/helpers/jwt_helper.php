<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Include the JWT PHP files manually
require_once APPPATH . 'third_party/php-jwt/JWT.php';
require_once APPPATH . 'third_party/php-jwt/Key.php';
require_once APPPATH . 'third_party/php-jwt/JWTExceptionWithPayloadInterface.php';
require_once APPPATH . 'third_party/php-jwt/BeforeValidException.php';
require_once APPPATH . 'third_party/php-jwt/ExpiredException.php';
require_once APPPATH . 'third_party/php-jwt/SignatureInvalidException.php';


use \Firebase\JWT\JWT;

if (!function_exists('generate_jwt')) {
    function generate_jwt($data) {
        $key = "your_secret_key"; // Replace with your secret key
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600;  // jwt valid for 1 hour
        $payload = array(
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'data' => $data
        );

        return JWT::encode($payload, $key,'HS256');
    }
}

if (!function_exists('verify_jwt')) {
    function verify_jwt($token) {
        $key = "your_secret_key"; // Replace with your secret key
        try {
            $decoded = JWT::decode($token, new \Firebase\JWT\Key($key, 'HS256'));
            return (array) $decoded->data;
        } catch (Exception $e) {
            return false;
        }
    }
}
