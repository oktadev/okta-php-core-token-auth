<?php
require('./bootstrap.php');

use \Firebase\JWT\JWT;

$publicKey = file_get_contents('mykey.pub');

// read a JWT from the command line
if (! isset($argv[1])) {
    exit('Please provide a key to verify');
}

$jwt = $argv[1];

$decoded = JWT::decode($jwt, $publicKey, array('RS256'));

/*
 NOTE: This will now be an object instead of an associative array. To get
 an associative array, you will need to cast it as such:
*/
print_r((array) $decoded);

?>