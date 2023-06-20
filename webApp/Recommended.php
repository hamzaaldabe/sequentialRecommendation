<?php
session_start();
include "connect.php";

if (!isset($_SESSION['Username'])) {
    header('Location: index.php'); // Redirect To login Page
}

?>
<?php include "sections/header.php" ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="main.php">MoviesLens</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="main.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="Recommended.php">For Me</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div id="row" class="row">
    <div id="movie" class="col-md-3 text-center">
      <label class="font"> Title</label>
      </br>
      <label class="font">  ID </label>
      </br>
      <button type="submit" class="btn btn-primary btn-block">Watch</button>
    </div>
    
    <div id="movie" class="col-md-3 text-center">
      <label class="font"> Title</label>
      </br>
      <label class="font">  ID </label>
      </br>
      <button type="submit" class="btn btn-primary btn-block">Watch</button>
    </div>

    <div id="movie" class="col-md-3 text-center">
      <label class="font"> Title</label>
      </br>
      <label class="font">  ID </label>
      </br>
      <button type="submit" class="btn btn-primary btn-block">Watch</button>
    </div>

    <div id="movie" class="col-md-3 text-center">
      <label class="font"> Title</label>
      </br>
      <label class="font">  ID </label>
      </br>
      <button type="submit" class="btn btn-primary btn-block">Watch</button>
    </div>

    <div id="movie" class="col-md-3 text-center">
      <label class="font"> Title</label>
      </br>
      <label class="font">  ID </label>
      </br>
      <button type="submit" class="btn btn-primary btn-block">Watch</button>
    </div>

    <div id="movie" class="col-md-3 text-center">
      <label class="font"> Title</label>
      </br>
      <label class="font">  ID </label>
      </br>
      <button type="submit" class="btn btn-primary btn-block">Watch</button>
    </div>
  </div>


<?php "sections/footer.php" ?>