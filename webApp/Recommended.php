<?php
session_start();
include "connect.php";

if (!isset($_SESSION['Username'])) {
  header('Location: index.php'); // Redirect To login Page
}

?>
<?php include "sections/header.php" ?>
<?php include "sections/navbar.php" ?>

<div id="row" class="row">
  <div id="movie" class="col-md-3 text-center">
    <label class="font"> Title</label>
    </br>
    <label class="font"> ID </label>
    </br>
    <button type="submit" class="btn btn-primary btn-block">Watch</button>
  </div>

  <div id="movie" class="col-md-3 text-center">
    <label class="font"> Title</label>
    </br>
    <label class="font"> ID </label>
    </br>
    <button type="submit" class="btn btn-primary btn-block">Watch</button>
  </div>

  <div id="movie" class="col-md-3 text-center">
    <label class="font"> Title</label>
    </br>
    <label class="font"> ID </label>
    </br>
    <button type="submit" class="btn btn-primary btn-block">Watch</button>
  </div>

  <div id="movie" class="col-md-3 text-center">
    <label class="font"> Title</label>
    </br>
    <label class="font"> ID </label>
    </br>
    <button type="submit" class="btn btn-primary btn-block">Watch</button>
  </div>

  <div id="movie" class="col-md-3 text-center">
    <label class="font"> Title</label>
    </br>
    <label class="font"> ID </label>
    </br>
    <button type="submit" class="btn btn-primary btn-block">Watch</button>
  </div>

  <div id="movie" class="col-md-3 text-center">
    <label class="font"> Title</label>
    </br>
    <label class="font"> ID </label>
    </br>
    <button type="submit" class="btn btn-primary btn-block">Watch</button>
  </div>
</div>


<?php "sections/footer.php" ?>