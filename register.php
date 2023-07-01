<?php
require 'functions.php';
require 'connection.php';
$firstName = $lastName = $username = $email = $password = $rePassword = "";
$query = "";
$firstNameErr = $lastNameErr = $usernameErr = $passwordErr = $repasswordErr = $emailErr = $avatarErr = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $target_dir = "images/";
    $target_file = $target_dir . basename($_FILES["avatar"]["name"]);
    move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file);
    if (empty(safeForm($_POST["firstName"]))) {
        $firstNameErr = "This field must not be empty";
    } else {
        $firstName = safeForm($_POST["firstName"]);
    }

    if (empty(safeForm($_POST["lastName"]))) {
        $lastNameErr = "This field must not be empty";
    } else {
        $lastName = safeForm($_POST["lastName"]);
    }

    if (empty(safeForm($_POST["username"]))) {
        $usernameErr = "This field must not be empty";
    } else {
        $tempUserName = safeForm($_POST["username"]);
        $sql = "SELECT * FROM `userstbl` where `userName`='$tempUserName';";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $usernameErr = "This username was chosen before you. Try different username.";
        } else {
            $username = safeForm($_POST["username"]);
        }
    }

    if (empty(safeForm($_POST["email"]))) {
        $emailErr = "This field must not be empty";
    } else {
        $tempEmail = safeForm($_POST["email"]);
        $sql = "SELECT * FROM `userstbl` where `email`='$tempEmail';";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $emailErr = "This email address was chosen before you. Try different email address.";
        } else {
            $email = safeForm($_POST["email"]);
        }
    }

    if (empty(safeForm($_POST["password"]))) {
        $passwordErr = "This field must not be empty";
    } else {
        if ((strlen(safeForm($_POST["password"])) >= 6) and (strlen(safeForm($_POST["password"])) <= 16)) {
            $password = safeForm($_POST["password"]);
        } else {
            $passwordErr = "Password length must be between 6 and 16";
        }
    }

    if ((empty(safeForm($_POST["repassword"]))) or (safeForm($_POST["password"])) != (safeForm($_POST["repassword"]))) {
        $repasswordErr = "passwords do not match";
        $password = null;
    }
    if (0 == filesize($target_file)) {
        $avatarErr = "Avatar must be added";
    }
    if ((!empty($firstName)) and (!empty($lastName)) and (!empty($username)) and (!empty($password)) and (!empty($email)) and (!empty($target_file))) {
        $query =  "INSERT INTO `userstbl` (`userID`, `firstName`, `lastName`, `userName`, `email`, `password`, `avatarPath`) VALUES (NULL, '$firstName', '$lastName', '$username', '$email', '$password', '$target_file');";
        if ($conn->query($query) === TRUE) {
            sleep(1.5);
            header("Location:login.php");
            exit;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="row d-flex flex-column ">
            <h2 class="text-center">Sign Up</h2>
            <div class="d-flex justify-content-center"> <img src="<?php echo $target_file; ?>" class="rounded-circle images my-2"></div>
            <form action="<?php echo ($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data" class="col-8 mx-auto">
                <div class="mb-1">
                    <div class="input-group ">
                        <label for="firstName" class="fs-5 input-group-text bg-dark text-light">First Name:</label>
                        <input type="text" tabindex="1" name="firstName" id="firstName" value="<?php if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                                                                    echo $firstName;
                                                                                                } ?>" class="form-control border-1 border border-secondary" maxlength="50">
                    </div>
                    <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST")
                        echo ("<span class='ps-3 text-danger'>$firstNameErr</span>");
                    ?>
                </div>
                <div class="mb-1">
                    <div class="input-group ">
                        <label for="lastName" class="fs-5 input-group-text bg-dark text-light">Last Name:</label>
                        <input type="text" tabindex="2" name="lastName" id="lastName" value="<?php if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                                                                    echo $lastName;
                                                                                                } ?>" class="form-control border-1 border border-secondary" maxlength="50">
                    </div>
                    <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST")
                        echo ("<span class='ps-3 text-danger'>$lastNameErr</span>");
                    ?>
                </div>

                <div class="mb-1">
                    <div class="input-group ">
                        <label for="username" class="fs-5 input-group-text bg-dark text-light">Username:</label>
                        <input type="text" tabindex="3" name="username" id="username" value="<?php if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                                                                    echo $username;
                                                                                                } ?>" class="form-control border-1 border border-secondary" maxlength="50">
                    </div>
                    <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST")
                        echo ("<span class='ps-3 text-danger'>$usernameErr</span>");
                    ?>
                </div>

                <div class="mb-1">
                    <div class="input-group ">
                        <label for="email" class="fs-5 input-group-text bg-dark text-light">Email:</label>
                        <input type="email" tabindex="4" name="email" id="email" value="<?php if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                                                            echo $email;
                                                                                        } ?>" class="form-control border-1 border border-secondary">
                    </div>
                    <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST")
                        echo ("<span class='ps-3 text-danger'>$emailErr</span>");
                    ?>
                </div>

                <div class="mb-1">
                    <div class="input-group ">
                        <label for="password" class="fs-5 input-group-text bg-dark text-light">Password:</label>
                        <input type="password" tabindex="5" name="password" id="password" value="<?php if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                                                                        echo $password;
                                                                                                    } ?>" class="form-control border-1 border border-secondary" maxlength="16" min="6">
                    </div>
                    <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST")
                        echo ("<span class='ps-3 text-danger'>$passwordErr</span>");
                    ?>
                </div>
                <div class="mb-1">
                    <div class="input-group ">
                        <label for="repassword" class="fs-5 input-group-text bg-dark text-light">Password Check: </label>
                        <input type="password" tabindex="6" name="repassword" id="repassword" class="form-control border-1 border border-secondary">
                    </div>
                    <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST")
                        echo ("<span class='ps-3 text-danger'>$repasswordErr</span>");
                    ?>
                </div>
                <div class="mb-1">
                    <div class="input-group ">
                        <label for="avatar" class="fs-5 input-group-text bg-dark text-light">Avatar:</label>
                        <input type="file" tabindex="7" name="avatar" value="<?php
                                                                                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                                                    echo $target_file;
                                                                                }
                                                                                ?>" id="avatar" class="form-control border-1 border border-secondary">
                    </div>
                    <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST")
                        echo ("<span class='ps-3 text-danger'>$avatarErr</span>");
                    ?>
                </div>
                <div class="d-flex gap-1">
                    <button class="btn btn-primary w-50 mt-1" type="submit">Submit</button>
                    <button class="btn btn-danger w-50 mt-1" type="reset">Reset</button>
                </div>
                <div>
                        <a href="login.php" class="text-center d-flex justify-content-end">Have you got a account ?</a>
                    </div>

            </form>
        </div>
    </div>
</body>

</html>