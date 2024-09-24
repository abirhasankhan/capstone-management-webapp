<?php
session_start();

//database connection
require '../server/config.php';
require 'validation.php';


//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';

function sendMail($s_email, $v_code)
{

    $mail = new PHPMailer(true);


    try {
        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP(); //Send using SMTP
        $mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
        $mail->SMTPAuth = true; //Enable SMTP authentication
        $mail->Username = 'ak00.abirkhan@gmail.com'; //SMTP username
        $mail->Password = 'puxgyhwyxknacadr'; //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; //Enable implicit TLS encryption
        $mail->Port = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );



        //Recipients
        $mail->setFrom('ak00.abirkhan@gmail.com', 'EWU');
        $mail->addAddress($s_email); //Add a recipient

        //Content
        $mail->isHTML(true); //Set email format to HTML
        $mail->Subject = 'New account confirmation from EWU';
        $mail->Body = "This email is to confirm the account you just created at EWU book buy and sell website.
        Click the link below and finish the registration process 
        a href='http://localhost/oka/studentView/verify.php?s_email=$s_email&v_code=$v_code'>Verify</a>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }


}

// get all value 
if (isset($_POST['register'])) {

    $s_id = $_POST['s_id'];
    $s_fName = $_POST['s_fName'];
    $s_lName = $_POST['s_lName'];
    $s_phoneNo = $_POST['s_phoneNo'];
    $s_email = $_POST['s_email'];
    $s_password = $_POST['s_password'];
    $s_password_con = $_POST['s_password_confirmation'];
    $tot_credit = $_POST['tot_credit'];

    $v_code = bin2hex(random_bytes(16));
/*
    // for valid ID
    function validStId()
    {
        // Define the regular expression for a valid ID.
        $id_regex = "/^[0-9]{4}-[0-9]{1}-[0-9]{2}-[0-9]{3}$/";

        global $s_id;

        // Validate the ID.
        if (!preg_match($id_regex, $s_id)) {
            // The ID is invalid.
            echo "
                <script>
                    alert('The ID is not in the correct format');
                    window.location.href='sSignUp.php';
                </script>
                ";
            return false;
        } else {
            //echo "The ID is valid.";
            return true;
        }
    }

    // for valid name
    function validFastName()
    {
        // Define the regular expression for a valid name.
        $name_regex = "/^[a-zA-Z ]*$/";

        // Get the name from the POST request.
        global $s_fName;

        // Validate the name.
        if (!preg_match($name_regex, $s_fName)) {
            // The name is invalid.
            echo "
                <script>
                    alert('Fast name must only contain letters and whitespace');
                    window.location.href='sSignUp.php';
                </script>
                ";
            return false;
        } else {
            //echo "The name is valid.";
            return true;
        }
    }

    function validLastName()
    {
        // Define the regular expression for a valid name.
        $name_regex = "/^[a-zA-Z ]*$/";

        // Get the name from the POST request.
        global $s_lName;

        // Validate the name.
        if (!preg_match($name_regex, $s_lName)) {
            // The name is invalid.
            echo "
                <script>
                    alert('Last name must only contain letters and whitespace');
                    window.location.href='sSignUp.php';
                </script>
                ";
            return false;
        } else {
            //echo "The name is valid.";
            return true;
        }
    }

    // for valid phone number
    function validNumber()
    {
        // Define the regular expression for a valid phone number.
        $phone_regex = "/^[0-9]{11}$/";

        // Get the phone number from the POST request.
        global $s_phoneNo;

        // Validate the phone number.
        if (!preg_match($phone_regex, $s_phoneNo)) {
            // The phone number is invalid.
            //echo "The phone number is not in the correct format.";
            echo "
                <script>
                    alert('Phone number is not in the correct format');
                    window.location.href='sSignUp.php';
                </script>
                ";
            return false;
        } else {
            // The phone number is valid.
            //echo "The phone number is valid.";
            return true;
        }
    }

    // for valid student mail
    function validStMail()
    {
        // Define the regular expression for a valid email address.
        $email_regex = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/";

        // Get the email address from the POST request.
        global $s_email;

        // Validate the email address.
        if (!preg_match($email_regex, $s_email)) {
            // The email address is invalid.
            echo "
                <script>
                    alert('Email address is not in the correct format');
                    window.location.href='sSignUp.php';
                </script>
                ";
            return false;
        } else {
            // The email address is valid.
            //echo "The email address is valid.";
            return true;
        }

    }

    // for valid password
    function validPassword()
    {

        // Define the regular expression for a valid password.
        $password_regex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*]).{8,}$/";

        // Get the password from the POST request.
        global $s_password;

        // Validate the password.
        if (!preg_match($password_regex, $s_password)) {
            // The password is invalid.
            echo "
                <script>
                    alert('Password is invalid');
                    window.location.href='sSignUp.php';
                </script>
                ";
            return false;
        } else {
            // The password is valid.
            //echo "The password is valid.";
            return true;
        }
    }

    // for total complete credit, must be >= 90
    function validTot_credit()
    {

        global $tot_credit;

        // Validate the name.
        if ($tot_credit < 90) {
            // The name is invalid.
            echo "
                <script>
                    alert('total credit is not complete');
                    window.location.href='sSignUp.php';
                </script>
                ";
            return false;
        } else {
            //echo "total credit completed";
            return true;
        }
    }
    


*/


    // checking value field is emplty or not
    if (!empty($s_id) && !empty($s_fName) && !empty($s_lName) && !empty($s_phoneNo) && !empty($s_email) && !empty($s_password) && !empty($s_password_con) && !empty($tot_credit)) {

        $valObj = new Validation();
        $userID = $valObj->validStId($s_id);
        $userFName = $valObj->validFastName($s_fName);
        $userLName = $valObj->validLastName($s_lName);
        $userPhone = $valObj->validNumber($s_phoneNo);
        $userMail = $valObj->validStMail($s_email);
        $userPass = $valObj->validPassword($s_password);
        $userTot_credit = $valObj->validTot_credit($tot_credit);

        if ($userID && $userFName && $userLName && $userPhone && $userMail && $userPass && $userTot_credit) {

            // Escape the values to prevent syntax errors
            $s_id = mysqli_real_escape_string($conn, $s_id);
            $s_fName = mysqli_real_escape_string($conn, $s_fName);
            $s_lName = mysqli_real_escape_string($conn, $s_lName);
            $s_phoneNo = mysqli_real_escape_string($conn, $s_phoneNo);
            $s_email = mysqli_real_escape_string($conn, $s_email);
            $s_password = mysqli_real_escape_string($conn, $s_password);
            //$pick_loc = mysqli_real_escape_string($conn, $pick_loc);
            $s_password_con = mysqli_real_escape_string($conn, $s_password_con);
            $tot_credit = mysqli_real_escape_string($conn, $tot_credit);

            // Check if the email address is valid
            if (filter_var($s_email, FILTER_VALIDATE_EMAIL)) {
                // Get the domain name from the email address
                $domain = substr(strrchr($s_email, "@"), 1);

                // Check if the domain name is a university domain
                $university_domains = array("std.ewubd.edu");
                if (in_array($domain, $university_domains)) {
                    // The email address is from a university domain
                    // Proceed with registration
                    // ...

                    // matching password
                    if ($s_password === $s_password_con) {
                        // creating passwprd hash
                        $md5_s_pass = md5($s_password);

                        // checking for exist user
                        $user_exist_query = "SELECT * FROM student WHERE student_id = '$s_id' OR s_email = '$s_email' ";
                        $result = $conn->query($user_exist_query);

                        if ($result) {

                            // it will be executed for  Student ID or Email
                            if (mysqli_num_rows($result) > 0) {

                                $result_fetch = mysqli_fetch_assoc($result);

                                if ($result_fetch['student_id'] == $s_id) {
                                    // Error for Student ID existence
                                    echo "
                                    <script>
                                        alert('Already have an account in this Student ID.');
                                        window.location.href='sSignup.php';
                                    </script>
                                    ";
                                } else {
                                    // Error for Email existence
                                    echo "
                                    <script>
                                        alert('Already have an account in this Email.');
                                        window.location.href='sSignup.php';
                                    </script>
                                    ";
                                }

                            } else {

                                // If user don't exist then insert into databasae
                                $insert = "INSERT INTO student (student_id, s_firstName, s_lastName, phone_no, s_email, s_password, tot_credit, is_verified) VALUES ('$s_id', '$s_fName', '$s_lName', '$s_phoneNo', '$s_email', '$md5_s_pass', '$tot_credit', '0')";
                                $query = $conn->query($insert);

                                $insert_verify = "INSERT INTO verify_student (s_email, ver_code) VALUES ('$s_email','$v_code')";
                                $query_verify = $conn->query($insert_verify);

                                if ($query && $query_verify) {

                                    sendMail($s_email, $v_code);

                                    // after create a account, jump to login page
                                    header('location:after_signup_page.php?accountCreated');
                                } else {

                                    // for Query error
                                    echo "
                                    <script>
                                        alert('Cannot Run Query');
                                        window.location.href='sSignup.php';
                                    </script>
                                    ";
                                }
                            }
                        }
                    }



                } else {
                    // The email address is not from a university domain
                    // Show an error message
                    echo "
                    <script>
                        alert('Only students with a university email address can register.');
                        window.location.href='sSignup.php';
                    </script>
                    ";
                }
            } else {
                // The email address is not valid
                // Show an error message
                echo "
                <script>
                    alert('Please enter a valid email address.');
                    window.location.href='sSignup.php';
                </script>
                ";
            }


        }

    }


}

?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up</title>
    <link rel="stylesheet" href="../css/style.css?v=<?= $version ?>">
    <script src="https://kit.fontawesome.com/d4c3426ce2.js" crossorigin="anonymous"></script>

</head>

<body>


    <div class="container">

        <div class="form-box">

            <h1 id="title">Sign Up</h1>

            <form action="sSignup.php" method="POST">

                <div class="input-group1">

                    <div class="input-field">
                        <i class="fa-solid fa-id-badge"></i>
                        <input type="text" class="form-control" placeholder="Student ID" name="s_id" required>

                    </div>

                    <div class="input-field" id="nameField">
                        <i class="fa-solid fa-user-tie"></i>
                        <input type="text" class="form-control" placeholder="First Name" name="s_fName" required>

                    </div>

                    <div class="input-field" id="nameField">
                        <i class="fa-solid fa-user-tie"></i>
                        <input type="text" class="form-control" placeholder="Last Name" name="s_lName" required>

                    </div>

                    <div class="input-field">
                        <i class="fa-solid fa-square-phone"></i>
                        <input type="Phone" class="form-control" placeholder="Phone Number" name="s_phoneNo" required>

                    </div>

                    <div class="input-field">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="Student Email" class="form-control" placeholder="Email" name="s_email" required>

                    </div>

                    <div class="input-field">
                        <i class="fa-solid fa-lock"></i>
                        <input type="Password" class="form-control" placeholder="Password" name="s_password" required>
                    </div>

                    <div class="input-field">
                        <i class="fa-solid fa-lock"></i>
                        <input type="Password" class="form-control" placeholder="Retype Password"
                            name="s_password_confirmation" required>
                    </div>

                    <div class="input-field">
                        <i class="fa-solid fa-square-phone"></i>
                        <input type="number" class="form-control" placeholder="Total credit" name="tot_credit" required>

                    </div>

                    <br>

                    <p> Already have an account? <a href="login.php"> <u><b>Sign in!</b></u> </a></p>
                    <br>

                    <div class="btn-field">
                        <button type="submit" id="signupbtn" name="register">Sign up</button>
                    </div>


                </div>



            </form>

        </div>

    </div>


</body>

</html>