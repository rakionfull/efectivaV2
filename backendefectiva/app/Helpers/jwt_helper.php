<?php

use App\Models\Msesiones;
use Config\Services;
use Firebase\JWT\JWT;

function getSignedJWTForUser(string $user,$id_user)
{
    $issuedAtTime = time();
    // $tokenTimeToLive = getenv('JWT_TIME_TO_LIVE');
    $tokenExpiration = $issuedAtTime + 3600;    //1 hora expire time in seconds
    $notBeforeClaim = $issuedAtTime + 10;                   // not before in seconds
    // $pvtKey = Services::getPrivateKey();  
    $pvtKey =  JWT_SECRET;                  // get RSA private key (NOT IN USE)
    $payload = [
        "iss" => "Issuer of the JWT", // this can be the servername. Example: https://domain.com
        "aud" => "Audience that the JWT",
        "sub" => "Subject of the JWT",
        "nbf" => $notBeforeClaim,
        'iat' => $issuedAtTime,
        'exp' => $tokenExpiration,
        "data" => array(
            'user' => $user,
            'id' => $id_user,
        )
    ];
   
    $jwt = JWT::encode($payload, $pvtKey , 'HS256');
    $model = new Msesiones();
    $result = $model->saveSesion($payload,$id_user);
   
    return $jwt;
}