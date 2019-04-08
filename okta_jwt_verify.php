<?php
require('./bootstrap.php');

if (! isset($argv[1])) {
    exit('Please provide a key to verify');
}

$jwt = $argv[1];

$jwtVerifier = (new \Okta\JwtVerifier\JwtVerifierBuilder())
    ->setAudience('api://default')
    ->setClientId(getenv('CLIENT_ID'))
    ->setIssuer(getenv('ISSUER'))
    ->build();

try {
    $jwt = $jwtVerifier->verify($jwt);
} catch (Exception $e) {
    exit($e->getMessage());
}

// Displays Claims as a JSON Object
var_dump($jwt->toJson());

?>