<?php include "assest/head.php"; ?>

<?php

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
    header("location: index.php");
    exit;
}

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT * FROM users WHERE username = '" . $_POST['username'] . "'";

        $stmt = $pdo->prepare($sql);

            // Attempt to execute the prepared statement
        $stmt->execute();
                // Check if username exists, if yes then verify password
                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {
                        $id = $row["id"];
                        $username = $row["username"];
                        $hashed_password = $row["password"];
                        if ($password == $hashed_password) {
                            // Password is correct, so start a new session
                            session_start();
                            if(isset($_POST["check"])){
                                setcookie('username' , $_POST["username"], time()+ 3600*24*15 );
                                setcookie('password' , $_POST["password"], time()+ 3600*24*15 );
                            }
                            else{
                                    unset($_COOKIE['username']);
                                    unset($_COOKIE['password']);
                                    //$username=$_COOKIE['username'];
                                    //$password=$_COOKIE['password'];
                                    setcookie('username' , null, time()-1 );
                                    setcookie('password' , null, time()-1 );
                                
                            }
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION['message1']="Succesfully Login";

                            // Redirect user to welcome page
                            header("location: index.php");
                        } else {
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else {
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
           

            // Close statement
            unset($stmt);
        
    }

    // Close connection
    unset($pdo);
}
?>
<!-- <link href="css/home.css" rel="stylesheet"> -->
<link type="text/css" rel="stylesheet" href="css/style.css" />
    <title>Login</title>
</head>

<body class="d-flex flex-column min-vh-100">

    <!-- Header -->
    <?php include "assest/header.php" ?>
    <!-- </Header> -->

    <!-- Main -->
    <main class="main">

        <!-- Latest Articles -->
        <div class="section jumbotron mb-0 h-100">
            <!-- container -->
            <div class="container d-flex flex-column justify-content-center align-items-center h-100">

                <div class="wrapper my-0 pt-3 bg-white w-50 text-center">
                    <img src="img/logo/logo1.png" alt="logo" style="width: 100px;height: auto;">
                </div>

                <!-- row -->
                <div class="wrapper bg-white rounded px-4 py-4 w-50">

                    <form action="login.php" method="POST">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control <?= (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php if(isset($_COOKIE['username'])){ echo $_COOKIE['username'];} ?>" required>
                            <span class="invalid-feedback"><?= $username_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control <?= (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php if(isset($_COOKIE['password'])){ echo $_COOKIE['password'];} ?>">
                            <span class="invalid-feedback"><?= $password_err; ?></span>
                        </div>
                        <div class=>
                            <input type="submit" class="btn btn-success" value="Login">
                        </div>
                        <div class="form-group">
		            	<label class="checkbox-wrap checkbox-primary">Remember Me
									  <input name ="check" <?php if (isset($_COOKIE["username"])){echo "checked";} ?> type="checkbox" >                   
									  <span class="checkmark"></span>
									</label>
								</div>
                        <p><a href="#" class="text-muted">Lost your password?</a></p>
                        
                    </form>
                </div>

                <!-- /row -->

            </div>
            <!-- /container -->
        </div>


    </main><!-- </Main> -->
    <!-- Footer -->
    <?php require "assest/footer.php" ?> 

</body>

</html>