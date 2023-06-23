<?php
session_start();
include "connect.php";

if (isset($_SESSION['Username'])) {
    header('Location: main.php'); // Redirect To main Page
}
?>
<?php include "sections/header.php" ?>

<?php

if (isset($_POST['register'])) {
    if ($_POST['firstname'] != "" || $_POST['username'] != "" || $_POST['password'] != "") {
        try {
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $username = $_POST['username'];
            // md5 encrypted
            $password = md5($_POST['password']);
            // $password = $_POST['password'];
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO `users` VALUES (null, '$firstname', '$lastname', '$username', '$password')";
            $con->exec($sql);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        $_SESSION['message'] = array("text" => "User successfully created.", "alert" => "info");
        $con = null;
        header('location:index.php');
    
    } else {
        echo "
				<script>alert('Please fill up the required field!')</script>
				<script>window.location = 'registration.php'</script>
			";
    }
}
?>



<div class="container main-container">
    <div class="row justify-content-center">
        <div class="card" style="width: 40rem;">
            <div class="card-body">
                <div class="name">
                    <p class="h1" style="text-align: center">Register</p>
                </div>
                <form class="bg-white rounded shadow-5-strong p-5" method="post"
                    action="<?php echo $_SERVER['PHP_SELF'] ?>">
                    <!-- First name input -->
                    <div id="userrow" class="row">
                        <div class="col d-flex">
                            <input type="text" placeholder="First Name" id="form1Example1" name="firstname"
                                class="form-control" />

                        </div>
                        <div class="col d-flex">
                            <input type="text" placeholder="Last Name" id="form1Example1" name="lastname"
                                class="form-control" />
                        </div>
                    </div>
                    <!-- Email input -->
                    <div class="form-outline mb-4">
                        <input type="text" placeholder="Username" id="form1Example1" name="username"
                            class="form-control" />
                    </div>

                    <!-- Password input -->
                    <div class="form-outline mb-4">
                        <input type="password" placeholder="Password" id="form1Example2" name="password"
                            class="form-control" />
                    </div>
                    <div class="d-grid gap-2 col-6 mx-auto">
                        <button id="regbtn" type="submit" name="register"
                            class="btn btn-primary btn-block">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php "sections/footer.php" ?>