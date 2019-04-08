<?php
require('./bootstrap.php');

echo "Obtaining token...";

// prepare the request
$uri = getenv('ISSUER') . '/v1/token';
$clientId = getenv('CLIENT_ID');
$clientSecret = getenv('CLIENT_SECRET');
$token = base64_encode("$clientId:$clientSecret");
$payload = http_build_query([
    'grant_type' => 'client_credentials',
    'scope'      => getenv('SCOPE')
]);

// build the curl request
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $uri);
curl_setopt( $ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/x-www-form-urlencoded',
    "Authorization: Basic $token"
]);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// process and return the response
$response = curl_exec($ch);
$response = json_decode($response, true);
if (! isset($response['access_token'])
    || ! isset($response['token_type'])) {
    exit('failed, exiting.');
}

echo "success!\n";

// here's your token to use in API requests
print_r($response['access_token']);

?>