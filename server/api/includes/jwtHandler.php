<?php
require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/sendJson.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;

$tokenSecret = 'ntubed_global';

function encodeToken($data)
{
    global $tokenSecret;
    $token = array(
        'iss' => $_SERVER['REQUEST_URI'],
        'iat' => time(),
        'exp' => time() + 604800, // 7day
        'data' => $data
    );
    return JWT::encode($token, $tokenSecret, 'HS256');
}

function decodeToken($token)
{
    global $tokenSecret;
    try {
        $decode = JWT::decode($token, new Key($tokenSecret, 'HS256'));
        return $decode->data;
    } catch (ExpiredException | SignatureInvalidException $e) {
        sendJson(401, $e->getMessage());
    } catch (UnexpectedValueException | Exception $e) {
        sendJson(400, $e->getMessage());
    }
}