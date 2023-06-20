<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $MovieID = $_POST['MovieID'];
    echo $MovieID;
}

// // API URL
// $url = 'https://www.example.com/api';

// // Create a new cURL resource
// $ch = curl_init($url);

// // Setup request to send json via POST
// $data = array(
//     'username' => 'codexworld',
//     'password' => '123456'
// );
// $payload = json_encode(array("user" => $data));

// // Attach encoded JSON string to the POST fields
// curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

// // Set the content type to application/json
// curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

// // Return response instead of outputting
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// // Execute the POST request
// $result = curl_exec($ch);

// // Close cURL resource
// curl_close($ch);
?>