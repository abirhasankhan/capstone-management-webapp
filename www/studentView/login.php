<?php
session_start();

// Database connection
require '../server/config.php';

// Include reCAPTCHA keys
$recaptcha_secret_key = '6LcfqjspAAAAAOaSreXHtKK9DN3hbI1wMerGRpiF';

if (isset($_POST['login'])) {
    $s_email = $_POST['s_email'];
    $s_password = $_POST['s_password'];

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

    if ($recaptcha_data['success']) {

        // reCAPTCHA validation passed, continue with your existing login logic

        $md5_s_pass = md5($s_password);

        $sql = "SELECT * FROM student WHERE `s_email` = '$s_email' AND `s_password` = '$md5_s_pass' AND `is_verified` = '1'";
        $query = $conn->query($sql);

        if ($query->num_rows > 0) {
            $result_fetch = mysqli_fetch_assoc($query);

            // Set cookies after successful login
            setcookie('user_id', $result_fetch['student_id'], time() + 3600, '/'); // Cookie expires in 1 hour
            setcookie('user_email', $result_fetch['s_email'], time() + 3600, '/');

            // Set session variables
            $_SESSION['login'] = true;
            $_SESSION['student_id'] = $result_fetch['student_id'];
            $_SESSION['s_firstName'] = $result_fetch['s_firstname'];
            $_SESSION['s_lastName'] = $result_fetch['s_lastname'];
            $_SESSION['phone_no'] = $result_fetch['phone_no'];
            $_SESSION['s_email'] = $result_fetch['s_email'];
            $_SESSION['tot_credit'] = $result_fetch['tot_credit'];
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
            <h1 id="title">Sign in (Student)</h1>

            <?php

            if (isset($_GET['accountCreated'])) {
                // echo 'Your account has been account created';
            }

            ?>

            <form action="login.php" method="POST">
                <div class="input-group">
                    <div class="input-field">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="text" class="form-control" placeholder="Email" id="s_email" name="s_email"
                            required>
                    </div>

                    <div class="input-field">
                        <i class="fa-solid fa-lock"></i>
                        <input type="Password" class="form-control" placeholder="Password" id="s_password"
                            name="s_password" required>
                    </div>

                    <div class="g-recaptcha" data-sitekey="6LcfqjspAAAAAE74KuBlUk2b9shU4tgKGMs_C_6N"></div>
                    
                    <br>

                        <p> Don't have an account? <a href="sSignup.php"> <u><b>Sign up!</b></u> </a></p>
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