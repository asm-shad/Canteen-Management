<?php 

// 	function generateToken($expirySeconds) {
//     $timestamp = time();
//     $token = uniqid('', true); 
    
   
//     $expiryTime = $timestamp + $expirySeconds;
    
  
//     $token .= '|' . $expiryTime;
    
//     return $token;
// }

// function isTokenExpired($token) {
//     $tokenParts = explode('|', $token);

//     if (count($tokenParts) != 2) {
//         return true; // Invalid token format
//     }

//     $expiryTime = $tokenParts[1];
//     $currentTime = time();

//     return ($currentTime > (int)$expiryTime);
// }




// Start the session (ensure this is done at the beginning of each page)
session_start();

function generateToken($expirySeconds) {
    // Check if token already exists in the session
    if (!isset($_SESSION['token']) || !isset($_SESSION['expiryTime']) || $_SESSION['expiryTime'] < time()) {
        $timestamp = time();
        $token = uniqid('', true); // Generate a unique ID

        // Calculate the expiry time
        $expiryTime = $timestamp + $expirySeconds;

        // Store the token and expiry time in the session
        $_SESSION['token'] = $token;
        $_SESSION['expiryTime'] = $expiryTime;
    }

    return $_SESSION['token'];
}

function isTokenExpired($token) {
    // Check if token exists and has expired
    return (!isset($_SESSION['token']) || $_SESSION['token'] !== $token || $_SESSION['expiryTime'] < time());
}

$expirySeconds = 300; 
$token = generateToken($expirySeconds);

echo $token ;

echo "<br>";

if (isTokenExpired($token)) {
    echo "Token has expired.";
} else {
    echo "Token is valid.";
}


?>