<?php

require '../server/config.php';
require 'sessionInfo.php';
require 'validation.php';

$session = new SessionInfo();
$userFName = $session->s_fName;
$userID = $session->s_id;

function generateGroupKey($conn, $randStr)
{
    //$randStr = uniqid('GUP', true);
    //return $randStr;

    $keyExists = false; // Initialize $keyExists

    $query = "SELECT * FROM group_req";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {

        if ($row['group_id'] == $randStr) {

            $keyExists = true;
            break;

        } else {
            $keyExists = false;
        }

    }

    return $keyExists;

}

function generateKey($conn)
{

    $keyLength = 4;
    $str = "GROUP0123456789";
    $randStr = substr(str_shuffle($str), 0, $keyLength);

    $checkKey = generateGroupKey($conn, $randStr);

    while ($checkKey == true) {
        $randStr = substr(str_shuffle($str), 0, $keyLength);
        $checkKey = generateGroupKey($conn, $randStr);

    }

    return $randStr;
}

?>


<?php
// get all value 
if (isset($_POST['group_req'])) {

    $group_id = $_POST['group_id'];
    $std_2 = $_POST['std_2'];
    $std_3 = $_POST['std_3'];
    $std_4 = $_POST['std_4'];
    $dept_name = $_POST['dept_name'];
    $on_hold = 'on_hold';

    $group_id = mysqli_real_escape_string($conn, $group_id);
    $std_2 = mysqli_real_escape_string($conn, $std_2);
    $std_3 = mysqli_real_escape_string($conn, $std_3);
    $std_4 = mysqli_real_escape_string($conn, $std_4);
    $dept_name = mysqli_real_escape_string($conn, $dept_name);

    //student ID validation
    $demoObj = new Validation();
    $std2 = $demoObj->validStId($std_2);
    $std3 = $demoObj->validStId($std_3);
    $std4 = $demoObj->validStId($std_4);

    if ($std2 && $std3 && $std4){

        //checking empty field
        if (!empty($std_2) && !empty($std_3) && !empty($std_4) && !empty($dept_name) ) {


            //for 2nd team member 
            $forStd02 = "SELECT student_id FROM student WHERE student_id = '$std_2'";
            $queryForStd02 = $conn->query($forStd02);
            $studentDetail02 = $queryForStd02->fetch_assoc();

            //for 3rd team member 
            $forStd03 = "SELECT student_id FROM student WHERE student_id = '$std_3'";
            $queryForStd03 = $conn->query($forStd03);
            $studentDetail03 = $queryForStd03->fetch_assoc();

            //for 4th team member 
            $forStd04 = "SELECT student_id FROM student WHERE student_id = '$std_4'";
            $queryForStd04 = $conn->query($forStd04);
            $studentDetail04 = $queryForStd04->fetch_assoc();


            //if didn't find student ID in Database
            if (!$studentDetail02) {
                echo "
                <script>
                    alert('You 2nd group member do\'t have an account');
                    window.location.href='capstone_reg.php';
                </script>
                ";
            } elseif (!$studentDetail03) {
                echo "
                <script>
                    alert('You 3rd group member do\'t have an account');
                    window.location.href='capstone_reg.php';
                </script>
                ";
            } elseif (!$studentDetail04) {
                echo "
                <script>
                    alert('You 4th group member do\'t have an account');
                    window.location.href='capstone_reg.php';
                </script>
                ";
            }
            //or find all student ID in Database
            else {
                //$sql = "SELECT * FROM group_req WHERE student_id = '$student_id' AND s_password = '$md5_s_pass' && role = 'student'";
                //$notStudent = "SELECT * FROM student WHERE student_id = '$student_id' AND s_password = '$md5_s_pass' && role = 'not'";   
                $studentIdError = "SELECT * FROM group_req WHERE std_1 = '$userID' OR std_2 = '$userID' OR std_3 = '$userID' OR std_4 = '$userID'
                                                                    OR std_1 = '$std_2' OR std_2 = '$std_2' OR std_3 = '$std_2' OR std_4 = '$std_2' 
                                                                    OR std_1 = '$std_3' OR std_2 = '$std_3' OR std_3 = '$std_3' OR std_4 = '$std_3'
                                                                    OR std_1 = '$std_4' OR std_2 = '$std_4' OR std_3 = '$std_4' OR std_4 = '$std_4'";

                $queryStudentIdError = $conn->query($studentIdError);

                if ($queryStudentIdError) {

                    if (mysqli_num_rows($queryStudentIdError) > 0) {

                        $result_fetch = mysqli_fetch_assoc($queryStudentIdError);

                        //alert for team member in another group 
                        if ($result_fetch['std_1'] == $userID || $result_fetch['std_2'] == $userID || $result_fetch['std_3'] == $userID || $result_fetch['std_4'] == $userID) {

                            echo "
                                    <script>
                                        alert('1st group member already has a group.');
                                        window.location.href='capstone_reg.php';
                                    </script>
                                    ";
                        } elseif ($result_fetch['std_1'] == $std_2 || $result_fetch['std_2'] == $std_2 || $result_fetch['std_3'] == $std_2 || $result_fetch['std_4'] == $std_2) {
                            echo "
                                    <script>
                                        alert('2nd group member already has a group.');
                                        window.location.href='capstone_reg.php';
                                    </script>
                                    ";
                        } elseif ($result_fetch['std_1'] == $std_3 || $result_fetch['std_2'] == $std_3 || $result_fetch['std_3'] == $std_3 || $result_fetch['std_4'] == $std_3) {
                            echo "
                                    <script>
                                        alert('3rd group member already has a group.');
                                        window.location.href='capstone_reg.php';
                                    </script>
                                    ";
                        } else {
                            echo "
                                    <script>
                                        alert('4th group member already has a group.');
                                        window.location.href='capstone_reg.php';
                                    </script>
                                    ";
                        }
                    }

                    //if all team member not part of any group
                    else {

                        //checking for entering the same student ID
                        if ($userID == $std_2 || $userID == $std_3 || $userID == $std_4 || $std_2 == $std_3 || $std_2 == $std_4 || $std_3 == $std_4) {

                            echo "
                                <script>
                                    alert(' Don\'t entry the same student ID');
                                    window.location.href='capstone_reg.php';
                                </script>
                                ";


                        }
                        //if all the student ID is uniqe
                        else {

                            $insert = "INSERT INTO group_req (`group_id`, `std_1`, `std_2`, `std_3`, `std_4`, `dept_name`, `status`) VALUES ('$group_id', '$userID', '$std_2', '$std_3', '$std_4', '$dept_name', '$on_hold')";

                            if ($conn->query($insert) == true) {

                                // after create a account, jump to login page
                                echo "
                                <script>
                                    alert('Your group has been created, wait for 72h for your supervisor to assign it.');
                                    window.location.href='home.php';
                                </script>
                                ";
                            } else {

                                // for Query error
                                echo "
                                <script>
                                    alert('Cannot Run Query 01');
                                    window.location.href='home.php';
                                </script>
                                ";
                            }


                        }

                    }

                } else {
                    // for Query error
                    echo "
                        <script>
                            alert('Cannot Run Query 02');
                            window.location.href='home.php';
                        </script>
                    ";
                }

            }



        } else {

            // for Query error
            echo "
            <script>
                alert('Cannot Run Query 03');
                window.location.href='home.php';
            </script>
            ";
        }
    }
}

?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Capstone Registration Page</title>
    <link rel="stylesheet" href="../css/main.css?v=<?= $version ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/d4c3426ce2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
</head>

<body style="background-color: #f2f6ff;">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">

        <div class="container-fluid" style="margin-left:50px">

            <a class="navbar-brand" href="#">East West University</a>

            <ul class="navbar-nav" style="margin-right:100px">

                <a href="" class="text-dark mx-3">
                    <i class="fas fa-envelope fa-2x"></i>
                    <span class="badge bg-danger badge-dot"></span>
                </a>


                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo $userFName ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                        <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                        <li><a class="dropdown-item" id="logOut" href="logout.php">Logout</a></li>
                    </ul>
                </li>


            </ul>

        </div>
    </nav>


    <div style="font-size:20px;">

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">

            <div class="container-fluid" style="margin-left:70px;">

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">

                        <li class="nav-item" style="margin-left:10px">
                            <a class="nav-link" href="home.php">Home</a>
                        </li>

                        <li class="nav-item" style="margin-left:30px">
                            <a class="nav-link active" aria-current="page" href="#">Capstone</a>
                        </li>

                        <li class="nav-item" style="margin-left:30px">
                            <a class="nav-link" href="group.php">Group</a>
                        </li>

                        <li class="nav-item" style="margin-left:30px">
                            <a class="nav-link" href="vivaInfo.php">Viva Info</a>
                        </li>

                        <li class="nav-item" style="margin-left:30px">
                            <a class="nav-link" href="grade_report.php">Grade</a>
                        </li>

                        <li class="nav-item" style="margin-left:30px">
                            <a class="nav-link" href="info.php">Info</a>
                        </li>

                    </ul>
                </div>

            </div>

        </nav>

    </div>

        <div style="background-color:#E7E7E7">

            <div class="ms-5" style="text-align: left; padding-top: 30px">
                <h3 style="color:black; margin-left: 100px;"><b>Register for your capstone group...!</b></h3>
            </div>
            <hr style="width:auto;text-align:left;margin-left:0">

        </div>



        <form action="capstone_reg.php" method="POST">

            <div style="margin-left: 20%; margin-right: 20%; margin-top: 50px;">

            <div class="form-floating mb-3">
                <input type="hidden" class="form-control" placeholder="Group ID" name="group_id"
                    id="group_id" value="<?php echo generateKey($conn); ?>" readonly>
            </div>
            
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingInput" placeholder="studentID" name="std_1"
                        value="<?php echo $userID; ?>" readonly>
                    <label for="floatingInput">1st Student ID</label>

                </div>


                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingInput" placeholder="studentID" name="std_2" required>
                    <label for="floatingInput">2nd Student ID</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingInput" placeholder="studentID" name="std_3" required>
                    <label for="floatingInput">3rd Student ID</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingInput" placeholder="studentID" name="std_4" required>
                    <label for="floatingInput">4th Student ID</label>
                </div>  

                <div class="mb-3">
                    <select type="text" class="form-control" name="dept_name" required>
                        <option value="" disabled selected>Department</option>
                        <option value="CSE">CSE</option>
                        <option value="EEE">EEE</option>
                        <option value="ECE">ECE</option>
                        <option value="BBA">BBA</option>
                    </select>
                </div>

                <br>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-outline-primary" id="group_req" name="group_req">SUBMIT</button>
                </div>

            </div>

        </form>






    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
        </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
        </script>
</body>

</html>