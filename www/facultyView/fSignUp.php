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

function sendMail($f_email, $v_code)
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
        $mail->addAddress($f_email); //Add a recipient

        //Content
        $mail->isHTML(true); //Set email format to HTML
        $mail->Subject = 'New account confirmation from EWU';
        $mail->Body = "This email is to confirm the account you just created at EWU book buy and sell website. 
                        Click the link below and finish the registration process 
                        <a href='http://localhost/oka/facultyView/verify.php?f_email=$f_email&v_code=$v_code'>Verify</a>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }


}

// get all value 
if (isset($_POST['register'])) {

    $f_id = $_POST['f_id'];
    $f_fName = $_POST['f_fName'];
    $f_lName = $_POST['f_lName'];
    $f_phoneNo = $_POST['f_phoneNo'];
    $f_email = $_POST['f_email'];
    $f_password = $_POST['f_password'];
    $f_password_con = $_POST['f_password_confirmation'];
    $dept_name = $_POST['dept_name'];
    $role = 0;

    $v_code = bin2hex(random_bytes(16));


    // checking value field is emplty or not
    if (!empty($f_id) && !empty($f_fName) && !empty($f_lName) && !empty($f_phoneNo) && !empty($f_email) && !empty($f_password) && !empty($f_password_con) && !empty($dept_name)) {

        $valObj = new Validation();
        $userID = $valObj->validFLId($f_id);
        $userFName = $valObj->validFastName($f_fName);
        $userLName = $valObj->validLastName($f_lName);
        $userPhone = $valObj->validNumber($f_phoneNo);
        $userMail = $valObj->validStMail($f_email);
        $userPass = $valObj->validPassword($f_password);



        if ($userID && $userFName && $userLName && $userPhone && $userMail && $userPass) {

            // Escape the values to prevent syntax errors
            $f_id = mysqli_real_escape_string($conn, $f_id);
            $f_fName = mysqli_real_escape_string($conn, $f_fName);
            $f_lName = mysqli_real_escape_string($conn, $f_lName);
            $f_phoneNo = mysqli_real_escape_string($conn, $f_phoneNo);
            $f_email = mysqli_real_escape_string($conn, $f_email);
            $f_password = mysqli_real_escape_string($conn, $f_password);
            $f_password_con = mysqli_real_escape_string($conn, $f_password_con);
            $dept_name = mysqli_real_escape_string($conn, $dept_name);


            // Check if the email address is valid
            if (filter_var($f_email, FILTER_VALIDATE_EMAIL)) {
                // Get the domain name from the email address
                $domain = substr(strrchr($f_email, "@"), 1);

                // Check if the domain name is a university domain
                $university_domains = array("ewubd.edu");
                if (in_array($domain, $university_domains)) {
                    // The email address is from a university domain
                    // Proceed with registration
                    // ...

                    // matching password
                    if ($f_password === $f_password_con) {
                        // creating passwprd hash
                        $md5_s_pass = md5($f_password);

                        // checking for exist user
                        $user_exist_query = "SELECT * FROM faculty WHERE faculty_id = '$f_id' OR f_email = '$f_email'";
                        $result = $conn->query($user_exist_query);

                        if ($result) {

                            // it will be executed for  Student ID or Email
                            if (mysqli_num_rows($result) > 0) {

                                $result_fetch = mysqli_fetch_assoc($result);

                                if ($result_fetch['faculty_id'] == $f_id) {
                                    // Error for faculty ID existence
                                    echo "
                                    <script>
                                        alert('Already have an account in this faculty ID.');
                                        window.location.href='fSignup.php';
                                    </script>
                                    ";
                                } else {
                                    // Error for Email existence
                                    echo "
                                    <script>
                                        alert('Already have an account in this Email.');
                                        window.location.href='fSignup.php';
                                    </script>
                                    ";
                                }

                            } else {

                                // If user don't exist then insert into databasae
                                $insert = "INSERT INTO faculty (`faculty_id`, `f_firstname`, `f_lastname`, `phone_no`, `f_email`, `f_password`, `department_dept_name`, `is_verified`) VALUES ('$f_id', '$f_fName', '$f_lName', '$f_phoneNo', '$f_email', '$md5_s_pass', '$dept_name', '0')";
                                $query = $conn->query($insert);

                                $insert_verify = "INSERT INTO verify_faculty (f_email, ver_code) VALUES ('$f_email','$v_code')";
                                $query_verify = $conn->query($insert_verify);

                                if ($query && $query_verify) {

                                    sendMail($f_email, $v_code);

                                    // after create a account, jump to login page
                                    header('location:after_signup_page.php?accountCreated');
                                } else {

                                    // for Query error
                                    echo "
                                    <script>
                                        alert('Cannot Run Query');
                                        window.location.href='fSignup.php';
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
                        alert('Only faculty with a university email address can register.');
                        window.location.href='fSignup.php';
                    </script>
                    ";
                }
            } else {
                // The email address is not valid
                // Show an error message
                echo "
                <script>
                    alert('Please enter a valid email address.');
                    window.location.href='fSignup.php';
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

            <form action="fSignup.php" method="POST">

                <div class="input-group1">

                    <div class="input-field">
                        <i class="fa-solid fa-id-badge"></i>
                        <input type="text" class="form-control" placeholder="Faculty ID" name="f_id" required>

                    </div>

                    <div class="input-field" id="nameField">
                        <i class="fa-solid fa-user-tie"></i>
                        <input type="text" class="form-control" placeholder="First Name" name="f_fName" required>

                    </div>

                    <div class="input-field" id="nameField">
                        <i class="fa-solid fa-user-tie"></i>
                        <input type="text" class="form-control" placeholder="Last Name" name="f_lName" required>

                    </div>

                    <div class="input-field">
                        <i class="fa-solid fa-square-phone"></i>
                        <input type="Phone" class="form-control" placeholder="Phone Number" name="f_phoneNo" required>

                    </div>

                    <div class="input-field">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="Student Email" class="form-control" placeholder="Email" name="f_email" required>

                    </div>

                    <div class="input-field">
                        <i class="fa-solid fa-lock"></i>
                        <input type="Password" class="form-control" placeholder="Password" name="f_password" required>
                    </div>

                    <div class="input-field">
                        <i class="fa-solid fa-lock"></i>
                        <input type="Password" class="form-control" placeholder="Retype Password"
                            name="f_password_confirmation" required>
                    </div>

                    <div class="input-field">
                        <i class="fa-solid fa-building-user" style="margin-right:20px"></i>
                        <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" name="dept_name" required>
                            <option value="" disabled selected>Department</option>
                            <option value="CSE">CSE</option>
                            <option value="EEE">EEE</option>
                            <option value="ECE">ECE</option>
                            <option value="BBA">BBA</option>
                        </select>
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