<?php

use App\Models\Muser;
use Config\Services;
use Firebase\JWT\JWT;

function getJWTFromRequest($authenticationHeader): string
{
    if (is_null($authenticationHeader)) { //JWT is absent
        throw new Exception('Missing or invalid JWT in request');
    }
    //JWT is sent from client in the format Bearer XXXXXXXXX
    return explode(' ', $authenticationHeader)[1];
}

function validateJWTFromRequest(string $encodedToken)
{
    $key = JWT_SECRET;
    // $key=JWT_SECRET;
    $decodedToken = JWT::decode($encodedToken, $key, ['HS256']);
    $userModel = new Muser();
    $userModel->getUser($decodedToken->data->user);
}

function getSignedJWTForUser(string $user)
{
    $issuedAtTime = time();
    // $tokenTimeToLive = getenv('JWT_TIME_TO_LIVE');
    $tokenExpiration = $issuedAtTime + 3600;    // expire time in seconds
    $notBeforeClaim = $issuedAtTime + 10;                   // not before in seconds
    // $pvtKey = Services::getPrivateKey();  
    $pvtKey = JWT_SECRET;                  // get RSA private key (NOT IN USE)
    $payload = [
        "iss" => "Issuer of the JWT", // this can be the servername. Example: https://domain.com
        "aud" => "Audience that the JWT",
        "sub" => "Subject of the JWT",
        "nbf" => $notBeforeClaim,
        'iat' => $issuedAtTime,
        'exp' => $tokenExpiration,
        "data" => array(
            'user' => $user,
        )
    ];


    $jwt = JWT::encode($payload, $pvtKey , 'HS256');
    return $jwt;
}