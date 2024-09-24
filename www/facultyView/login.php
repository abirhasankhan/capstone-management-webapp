<?php
session_start();

// Database connection
require '../server/config.php';
require 'validation.php';

// Include reCAPTCHA keys
$recaptcha_secret_key = '6LcfqjspAAAAAOaSreXHtKK9DN3hbI1wMerGRpiF';

if (isset($_POST['login'])) {
    $f_email = $_POST['f_email'];
    $f_password = $_POST['f_password'];

    $valObj = new Validation();

    // Validate reCAPTCHA
    $recaptcha_response = $_POST['g-recaptcha-response'];

    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptcha_data = [
        'secret' => $recaptcha_secret_key,
        'response' => $recaptcha_response,
    ];

    $recaptcha_options = [
        'http' => [
            'header' => 'Content-type: application/x-www-form-urlencoded',
            'method' => 'POST',
            'content' => http_build_query($recaptcha_data),
        ],
    ];

    $recaptcha_context = stream_context_create($recaptcha_options);
    $recaptcha_result = file_get_contents($recaptcha_url, false, $recaptcha_context);
    $recaptcha_data = json_decode($recaptcha_result, true);

    // reCAPTCHA validation passed, continue with your existing login logic
    if ($recaptcha_data['success']) {


        if (!empty($f_email) && !empty($f_password)) {

            $userMail = $valObj->validFLMail($f_email);
            $userPass = $valObj->validPassword($f_password);

            if ($userMail && $userPass) {

                // Escape the values to prevent syntax errors

                $f_email = mysqli_real_escape_string($conn, $f_email);
                $f_password = mysqli_real_escape_string($conn, $f_password);

                $md5_f_pass = md5($f_password);

                $sql = "SELECT * FROM faculty WHERE `f_email` = '$f_email' AND `f_password` = '$md5_f_pass' AND `is_verified` = '1'";
                $query = $conn->query($sql);

                if ($query->num_rows > 0) {
                    $result_fetch = mysqli_fetch_assoc($query);

                    // Set cookies after successful login
                    setcookie('user_id', $result_fetch['faculty_id'], time() + 3600, '/'); // Cookie expires in 1 hour
                    setcookie('user_email', $result_fetch['f_email'], time() + 3600, '/');

                    // Set session variables
                    $_SESSION['login'] = true;
                    $_SESSION['faculty_id'] = $result_fetch['faculty_id'];
                    $_SESSION['f_firstname'] = $result_fetch['f_firstname'];
                    $_SESSION['f_lastname'] = $result_fetch['f_lastname'];
                    $_SESSION['phone_no'] = $result_fetch['phone_no'];
                    $_SESSION['f_email'] = $result_fetch['f_email'];
                    $_SESSION['department_dept_name'] = $result_fetch['department_dept_name'];
                    $_SESSION['is_verified'] = $result_fetch['is_verified'];

                    header('location:home.php');

                } else {
                    echo "
                        <script>
                            alert('Invalid email or password');
                            window.location.href='login.php';
                        </script>
                    ";
                }
                
            }

        } else {
            echo "
                <script>
                    alert('field can't be empty');
                    window.location.href='login.php';
                </script>
            ";
        }

    } else {
    // reCAPTCHA validation failed
        echo "
            <script>
                alert('reCAPTCHA validation failed');
            </script>
        ";
        header('location: login.php'); // Redirect to the login page
        exit(); // Ensure that the script stops execution after the redirect
    }

}
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://kit.fontawesome.com/d4c3426ce2.js" crossorigin="anonymous"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>
    <div class="container">
        <div class="form-box">
            <h1 id="title">Sign in (Faculty)</h1>

            <?php

            if (isset($_GET['accountCreated'])) {
                // echo 'Your account has been account created';
            }

            ?>

            <form action="login.php" method="POST">
                <div class="input-group">
                    <div class="input-field">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="text" class="form-control" placeholder="Email" id="f_email" name="f_email"
                            required>
                    </div>

                    <div class="input-field">
                        <i class="fa-solid fa-lock"></i>
                        <input type="Password" class="form-control" placeholder="Password" id="f_password"
                            name="f_password" required>
                    </div>

                    <div class="g-recaptcha" data-sitekey="6LcfqjspAAAAAE74KuBlUk2b9shU4tgKGMs_C_6N"></div>
                    
                    <br>

                        <p> Don't have an account? <a href="fSignup.php"> <u><b>Sign up!</b></u> </a></p>
                </div>

                    <br>
                    <br>
                    <br>

                    <div class="btn-field">
                        <button type="submit" id="signinbtn" name="login">Sign in</button>
                    </div>
            </form>
        </div>
    </div>
</body>

</html>