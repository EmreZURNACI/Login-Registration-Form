<?php
require 'connection.php';
require 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-7 mx-auto">
                <h2 class="fs-1 text-center">Please Sign In</h2>
                <div class="d-flex justify-content-center">
                    <img src="<?php
                                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                    $username = safeForm($_POST["username"]);
                                    $password = safeForm($_POST["password"]);
                                    $sql = "SELECT * FROM `userstbl` where `userName`='$username' and `password`='$password';";
                                    if (!empty($username) and !empty($password)) {
                                        $sql = "SELECT * FROM `userstbl` where `userName`='$username' and `password`='$password';";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo $row["avatarPath"];
                                            }
                                        }
                                    }
                                }

                                ?>" class="rounded-circle images my-2">
                </div>
                <form action="<?php echo ($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <div class="mb-2 input-group d-flex flex-column">
                        <label for="username" class="fs-5">Username:</label>
                        <input type="text" name="username" autocomplete="off" id="username" class="form-control border-1 border-secondary border w-100 rounded-2">
                        <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            if (empty($_POST["username"])) {
                                echo ("<span class='text-danger'>Username input is not be empty.Try Again...</span>");
                            }
                        }
                        ?>
                    </div>
                    <div class="mb-2 input-group d-flex flex-column">
                        <label for="password" class="fs-5">Password:</label>
                        <input type="password" name="password" id="password" class="form-control border-1 border-secondary border w-100 rounded-2">
                        <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            if (empty($_POST["password"])) {
                                echo ("<span class='text-danger'>Password input is not be empty.Try Again...</span>");
                            }
                        }
                        ?>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary w-100">Sign In</button>
                    </div>
                    <div>
                        <a href="register.php" class="text-center d-flex justify-content-end">Create New Account</a>
                    </div>
                    <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $username = safeForm($_POST["username"]);
                        $password = safeForm($_POST["password"]);
                        if (!empty($username) and !empty($password)) {
                            $sql = "SELECT * FROM `userstbl` where `userName`='$username' and `password`='$password';";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                sleep(1.5);
                                header("Location:loginSuccessed.html");
                                exit;
                            } else {
                                echo ("<span class='text-danger'>Username or password is wrong.Try Again...</span>");
                            }
                        }
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>
</body>

</html>