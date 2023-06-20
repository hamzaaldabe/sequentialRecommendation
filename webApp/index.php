<?php
session_start();

include "connect.php";

if (isset($_SESSION['Username'])) {
    header('Location: main.php'); // Redirect To main Page
}

// Check If User Coming From HTTP Post Request

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashedPass = md5($password);


    // Check If The User Exist In Database

    $stmt = $con->prepare("SELECT 
									*
								FROM 
									users 
								WHERE 
									username = ? 
								AND 
									password = ? 
								LIMIT 1");

    $stmt->execute(array($username, $hashedPass));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();

    // If Count > 0 This Mean The Database Contain Record About This Username

    if ($count > 0) {
        echo "Connected successfully";

        $_SESSION['Username'] = $username; // Register Session Name
        $_SESSION['ID'] = $row['UserID']; // Register Session ID
        header('Location: main.php'); // Redirect To Dashboard Page
        exit();
    }

}

?>

<?php include "sections/header.php"?>
<div class="container main-container">
    <div class="row justify-content-center">
        <div class="card" style="width: 40rem;">
            <div class="card-body">
                <div class="name">
                    <p class="h1" style="text-align: center">MoviesLens</p>
                </div>
                <div class="col-xl-12 col-md-12 col-lg-12">
                    <form class="bg-white rounded shadow-5-strong p-5" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="form1Example1">Username</label>
                            <input type="text" id="form1Example1" name="username" class="form-control"/>
                        </div>

                        <!-- Password input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="form1Example2">Password</label>
                            <input type="password" id="form1Example2" name="password" class="form-control"/>
                        </div>

                        <!-- 2 column grid layout for inline styling -->
                        <div class="row mb-4">
                            <div class="col d-flex justify-content-start">
                                <!-- Checkbox -->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="form1Example3"
                                           checked/>
                                    <label class="form-check-label" for="form1Example3">
                                        Remember me
                                    </label>
                                </div>
                            </div>

                            <div class="col text-center">
                                <!-- Simple link -->
                                <a href="#">Forgot password?</a>
                            </div>
                        </div>

                        <!-- Submit button -->
                        <div class="d-grid gap-2 col-6 mx-auto">
                            <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php "sections/footer.php"?>
