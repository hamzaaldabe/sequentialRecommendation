<?php
session_start();
include "connect.php";
include "sections/header.php";
include "sections/navbar.php";

if (!isset($_SESSION['Username'])) {
  header('Location: index.php'); // Redirect To login Page
}

$userId = 6;


// API URL
$url = 'http://127.0.0.1:8000/sequential/forme/';

// Create a new cURL resource
$ch = curl_init($url);

// Setup request to send json via POST
$data = array(
  'user_id' => 6,
);

$payload = json_encode($data);

// Attach encoded JSON string to the POST fields
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

// Set the content type to application/json
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

// Return response instead of outputting
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = json_decode(curl_exec($ch), true);
$moviesResponse = implode(",", $response);
// Close cURL resource
curl_close($ch);

?>
<div class="container">


  <div id="row" class="row">
    <?php
    $stmt = $con->prepare("SELECT 
																*
															FROM 
                              movies
                              where MovieID in ($moviesResponse)
													");

    $stmt->execute();
    $movies = $stmt->fetchAll();

    if (!empty($movies)) {
      foreach ($movies as $movie) {
        echo '
    <form  method="post" class="col-lg-3 col-md-3 col-s-3 col-xs-12" action="sendData.php">          
      <div id="movie" class="col-md-12 text-center">
      <label class="font" name="MovieID" > ' . $movie['MovieID'] . '</label>
      <input type="text" hidden value="' . $movie['MovieID'] . '" name="MovieID" />
      <input type="text" hidden value="' . session_id() . '" name="sessionId" />
      <input type="text" hidden value="' . $_SESSION['userID'] . '" name="userID" />
      </br>
      <label class="font"> ' . $movie['Title'] . ' </label>
      
      </br>
      <label class="font" name="MovieID" > ' . $movie['Genre'] . '</label>
      </br>
      </div>
      </form>  
      ';
      }
    } else {
      echo 'There\'s No movies To Show';
    }

    ?>

  </div>
</div>
<?php include "sections/footer.php" ?>