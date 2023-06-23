<?php

if (isset($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
} else {
    $pageno = 1;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $MovieID = $_POST['MovieID'];
    $sessionId = $_POST['sessionId'];
    $userID = $_POST['userID'];
    $timestamp = $_POST['timestamp'];

}
// MovieID, userID, sessionId, timestap
// API URL
$url = 'http://127.0.0.1:8000/sequential/test/';

// Create a new cURL resource
$ch = curl_init($url);

// Setup request to send json via POST
$data = array(
    'MovieID' => $MovieID,
    'sessionId' => $sessionId,
    'userID' => $userID,
    'timestamp' => $timestamp
);

$payload = json_encode(array("movie" => $data));

// Attach encoded JSON string to the POST fields
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

// Set the content type to application/json
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

// Return response instead of outputting
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the POST request
$result = curl_exec($ch);

// Close cURL resource
curl_close($ch);
header('Location: main.php?pageno=' . $pageno);
?>