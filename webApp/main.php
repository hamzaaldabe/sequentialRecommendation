<?php
session_start();
include "connect.php";
$now = date_create()->format('Y-m-d H:i:s');
// Function to search for movie title on Google and retrieve the first image URL
if (!isset($_SESSION['Username'])) {
    header('Location: index.php'); // Redirect To login Page
}

if (isset($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
} else {
    $pageno = 1;
}
$no_of_records_per_page = 12;
$offset = ($pageno - 1) * $no_of_records_per_page;

$total_pages_sql = "SELECT COUNT(*) FROM movies";
$total_pages_sql_stmt = $con->prepare($total_pages_sql);

$total_pages_sql_stmt->execute();
$total_rows = $total_pages_sql_stmt->fetch()[0];
$total_pages = ceil($total_rows / $no_of_records_per_page);

?>
<?php include "sections/header.php" ?>
<?php include "sections/navbar.php" ?>
<div class="container">


    <div id="row" class="row">
        <?php
        $stmt = $con->prepare("SELECT 
																*
															FROM 
                              movies
                              LIMIT $offset, $no_of_records_per_page
													");

        $stmt->execute();
        $movies = $stmt->fetchAll();

        if (!empty($movies)) {
            foreach ($movies as $movie) {
                echo '
    <form  method="post" class="col-lg-3 col-md-3 col-s-3 col-xs-12" action="sendData.php?pageno=' . $pageno . '">          
      <div id="movie" class="col-md-12 text-center">
      <label class="font" name="MovieID" > ' . $movie['MovieID'] . '</label>
      <input type="text" hidden value="' . $movie['MovieID'] . '" name="MovieID" />
      <input type="text" hidden value="' . session_id() . '" name="sessionId" />
      <input type="text" hidden value="' . $_SESSION['userID'] . '" name="userID" />
      <input type="text" hidden value="' . $now . '" name="timestamp" />
      </br>
      <label class="font"> ' . $movie['Title'] . ' </label>
      
      </br>
      <label class="font" name="MovieID" > ' . $movie['Genre'] . '</label>
      </br>
      <button type="submit" class="btn btn-primary btn-block">Watch</button>
      </div>
      </form>  
      ';
            }
        } else {
            echo 'There\'s No movies To Show';
        }

        ?>

    </div>
    <ul class="pagination">
        <li><a href="?pageno=1" class="btn btn-primary btn-block">First</a></li>
        <li class="<?php if ($pageno <= 1) {
            echo 'disabled';
        } ?>">
            <a href="<?php if ($pageno <= 1) {
                echo '#';
            } else {
                echo "?pageno=" . ($pageno - 1);
            } ?>" class="btn btn-primary btn-block">Prev</a>
        </li>
        <li class="<?php if ($pageno >= $total_pages) {
            echo 'disabled';
        } ?>">
            <a class="btn btn-primary btn-block" href="<?php if ($pageno >= $total_pages) {
                echo '#';
            } else {
                echo "?pageno=" . ($pageno + 1);
            } ?> ">Next</a>
        </li>
        <li><a class="btn btn-primary btn-block" href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
    </ul>
</div>
<?php include "sections/footer.php" ?>