<?php

require '../server/config.php';
require 'sessionInfo.php';
require 'validation.php';

$session = new SessionInfo();
$userFName = $session->f_fName;
$faculty_id = $session->f_id;

$demoObj = new Validation();

$student_id = "";
$mark = "";
$semester = "";
$year = "";
$course = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST["student_id"];
    $mark = $_POST["mark"];
    $course = $_POST["course"];
    $semester = $_POST["semester"];
    $year = date("Y");

    do {
        if (empty($student_id) || empty($mark) || empty($course) || empty($semester)) {
            $errorMessage = "All fields are required";
            break;
        }

        $stdId = $demoObj->validStId($student_id);
        $stdMark = $demoObj->markSubmit($mark);

        if ($stdId && $stdMark) {

            $student_id = mysqli_real_escape_string($conn, $student_id);
            $mark = mysqli_real_escape_string($conn, $mark);

            $semYear = $semester . "-" . $year;

            if ($course == "400A") {

                //for executed Student ID

                $user_exist_query = "SELECT * FROM 400a_mark WHERE student_id = '$student_id'";
                $exist_result = $conn->query($user_exist_query);

                $studentIdError = "SELECT * FROM student WHERE student_id = '$student_id'";
                $queryStudentIdError = $conn->query($studentIdError);

                if ($exist_result) {

                    // it will be executed for  Student ID or Email

                    if (mysqli_num_rows($exist_result) > 0) {
                        $result_fetch = mysqli_fetch_assoc($exist_result);
                        if ($result_fetch['student_id'] == $student_id) {
                            // Error for Student ID existence
                            $errorMessage = "This student ID already exists";
                            break;
                        }
                    } elseif ($queryStudentIdError->num_rows == 0) {
                        $errorMessage = "Student ID not found in Database";
                        break;
                    } else {
                        $faculty_group = "SELECT * FROM `group` JOIN group_req WHERE (std_1 = '$student_id' OR std_2 = '$student_id' OR std_3 = '$student_id' OR std_4 = '$student_id') AND `group`.`faculty_id` = '$faculty_id'";
                        $queryGroup = $conn->query($faculty_group);

                        if ($queryGroup->num_rows > 0) {
                            //add mark to database

                            $insert = "INSERT INTO `400a_mark`(`student_id`, `mark`, `semester`, `faculty_id`) VALUES ('$student_id','$mark','$semYear', '$faculty_id')";
                            $result = $conn->query($insert);


                            if (!$result) {
                                $errorMessage = "Invalid query: " . $conn->error;
                                break;
                            }

                            // Fetch group IDs based on the student ID
                            $selectGroups = "
                                    SELECT `group_id`
                                    FROM `group_req`
                                    WHERE `std_1` = '$student_id'
                                        OR `std_2` = '$student_id'
                                        OR `std_3` = '$student_id'
                                        OR `std_4` = '$student_id';
                                ";

                            $resultGroups = $conn->query($selectGroups);

                            if ($resultGroups->num_rows > 0) {
                                while ($row = $resultGroups->fetch_assoc()) {
                                    $groupId = $row['group_id'];

                                    // Update the 'grp_thesis_type' table for each group ID
                                    $update = "
                                            UPDATE `grp_thesis_type`
                                            SET `400A` = `400A` + 1
                                            WHERE `group_id` = '$groupId';
                                        ";

                                    $resultUpdate = $conn->query($update);

                                    if (!$resultUpdate) {
                                        // Handle the error appropriately
                                        echo "Update failed: " . $conn->error;
                                    }
                                }
                            } else {
                                // No groups found for the given student ID
                                echo "No groups found for the given student ID";
                            }


                            $student_id = "";
                            $mark = "";
                            $semester = "";
                            $year = "";

                            $successMessage = "Mark has been added";
                            break;

                        } else {
                            $errorMessage = "You are not the supervisor of his/her group";
                            break;
                        }
                    }
                } else {
                    echo "<script>alert('Cannot Run Query'); window.location.href='400A_mark.php';</script>";
                }
            } elseif ($course == "400B") {

                //for executed Student ID

                $user_exist_query = "SELECT * FROM 400b_mark WHERE student_id = '$student_id'";
                $exist_result = $conn->query($user_exist_query);

                $studentIdError = "SELECT * FROM student WHERE student_id = '$student_id'";
                $queryStudentIdError = $conn->query($studentIdError);

                if ($exist_result) {

                    // it will be executed for  Student ID or Email

                    if (mysqli_num_rows($exist_result) > 0) {
                        $result_fetch = mysqli_fetch_assoc($exist_result);
                        if ($result_fetch['student_id'] == $student_id) {
                            // Error for Student ID existence
                            $errorMessage = "This student ID already exists";
                            break;
                        }
                    } elseif ($queryStudentIdError->num_rows == 0) {
                        $errorMessage = "Student ID not found in Database";
                        break;
                    } else {
                        $faculty_group = "SELECT * FROM `group` JOIN group_req WHERE (std_1 = '$student_id' OR std_2 = '$student_id' OR std_3 = '$student_id' OR std_4 = '$student_id') AND `group`.`faculty_id` = '$faculty_id'";
                        $queryGroup = $conn->query($faculty_group);

                        if ($queryGroup->num_rows > 0) {
                            //add mark to database

                            $insert = "INSERT INTO `400b_mark`(`student_id`, `mark`, `semester`, `faculty_id`) VALUES ('$student_id','$mark','$semYear', '$faculty_id')";
                            $result = $conn->query($insert);

                            if (!$result) {
                                $errorMessage = "Invalid query: " . $conn->error;
                                break;
                            }

                            // Fetch group IDs based on the student ID
                            $selectGroups = "
                                    SELECT `group_id`
                                    FROM `group_req`
                                    WHERE `std_1` = '$student_id'
                                        OR `std_2` = '$student_id'
                                        OR `std_3` = '$student_id'
                                        OR `std_4` = '$student_id';
                                ";

                            $resultGroups = $conn->query($selectGroups);

                            if ($resultGroups->num_rows > 0) {
                                while ($row = $resultGroups->fetch_assoc()) {
                                    $groupId = $row['group_id'];

                                    // Update the 'grp_thesis_type' table for each group ID
                                    $update = "
                                            UPDATE `grp_thesis_type`
                                            SET `400B` = `400B` + 1
                                            WHERE `group_id` = '$groupId';
                                        ";

                                    $resultUpdate = $conn->query($update);

                                    if (!$resultUpdate) {
                                        // Handle the error appropriately
                                        echo "Update failed: " . $conn->error;
                                    }
                                }
                            } else {
                                // No groups found for the given student ID
                                echo "No groups found for the given student ID";
                            }

                            $student_id = "";
                            $mark = "";
                            $semester = "";
                            $year = "";

                            $successMessage = "Mark has been added";

                            break;
                        } else {
                            $errorMessage = "You are not the supervisor of his/her group";
                            break;
                        }
                    }
                } else {

                    echo "<script>alert('Cannot Run Query'); window.location.href='400A_mark.php';</script>";
                }
            } else {

                //for executed Student ID

                $user_exist_query = "SELECT * FROM 400c_mark WHERE student_id = '$student_id'";
                $exist_result = $conn->query($user_exist_query);

                $studentIdError = "SELECT * FROM student WHERE student_id = '$student_id'";
                $queryStudentIdError = $conn->query($studentIdError);

                if ($exist_result) {

                    // it will be executed for  Student ID or Email

                    if (mysqli_num_rows($exist_result) > 0) {
                        $result_fetch = mysqli_fetch_assoc($exist_result);
                        if ($result_fetch['student_id'] == $student_id) {
                            // Error for Student ID existence
                            $errorMessage = "This student ID already exists";
                            break;
                        }
                    } elseif ($queryStudentIdError->num_rows == 0) {
                        $errorMessage = "Student ID not found in Database";
                        break;
                    } else {
                        $faculty_group = "SELECT * FROM `group` JOIN group_req WHERE (std_1 = '$student_id' OR std_2 = '$student_id' OR std_3 = '$student_id' OR std_4 = '$student_id') AND `group`.`faculty_id` = '$faculty_id'";
                        $queryGroup = $conn->query($faculty_group);

                        if ($queryGroup->num_rows > 0) {
                            //add mark to database

                            $insert = "INSERT INTO `400c_mark`(`student_id`, `mark`, `semester`, `faculty_id`) VALUES ('$student_id','$mark','$semYear', '$faculty_id')";
                            $result = $conn->query($insert);

                            if (!$result) {
                                $errorMessage = "Invalid query: " . $conn->error;
                                break;
                            }

                            // Fetch group IDs based on the student ID
                            $selectGroups = "
                                    SELECT `group_id`
                                    FROM `group_req`
                                    WHERE `std_1` = '$student_id'
                                        OR `std_2` = '$student_id'
                                        OR `std_3` = '$student_id'
                                        OR `std_4` = '$student_id';
                                ";

                            $resultGroups = $conn->query($selectGroups);

                            if ($resultGroups->num_rows > 0) {
                                while ($row = $resultGroups->fetch_assoc()) {
                                    $groupId = $row['group_id'];

                                    // Update the 'grp_thesis_type' table for each group ID
                                    $update = "
                                            UPDATE `grp_thesis_type`
                                            SET `400C` = `400C` + 1
                                            WHERE `group_id` = '$groupId';
                                        ";

                                    $resultUpdate = $conn->query($update);

                                    if (!$resultUpdate) {
                                        // Handle the error appropriately
                                        echo "Update failed: " . $conn->error;
                                    }
                                }
                            } else {
                                // No groups found for the given student ID
                                echo "No groups found for the given student ID";
                            }

                            $student_id = "";
                            $mark = "";
                            $semester = "";
                            $year = "";

                            $successMessage = "Mark has been added";

                            break;
                        } else {
                            $errorMessage = "You are not the supervisor of his/her group";
                            break;
                        }
                    }
                } else {

                    echo "<script>alert('Cannot Run Query'); window.location.href='400A_mark.php';</script>";
                }
            }
        }
    } while (false);
}

?>

<!-- The rest of your HTML code remains unchanged -->


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Grade Submit</title>
    <link rel="stylesheet" href="../css/main.css?v=<?= $version ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/d4c3426ce2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
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
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">

                        <li class="nav-item" style="margin-left:10px">
                            <a class="nav-link" href="home.php">Home</a>
                        </li>

                        <li class="nav-item" style="margin-left:30px">
                            <a class="nav-link" href="group.php">Group</a>
                        </li>

                        <li class="nav-item" style="margin-left:30px">
                            <a class="nav-link active" aria-current="page" href="#">Grade Report</a>
                        </li>

                        <li class="nav-item" style="margin-left:30px">
                            <a class="nav-link" href="info.php">Info</a>
                        </li>

                    </ul>
                </div>

            </div>

        </nav>

    </div>

    <div style="margin-left: 10%; margin-top: 50px;">
        <h2> <b>Grade Submit</b></h2>
    </div>

    <div style="margin-left: 10%; margin-right: 10%; margin-top: 5%;">
        <table class="table">

            <tbody>
                <tr>
                    <td><a class="btn btn-outline-info" href="400A_mark.php" role="button"><b>400A info</b></a></td>
                    <td><a class="btn btn-outline-info" href="400B_mark.php" role="button"><b>400B info</b></a></td>
                    <td><a class="btn btn-outline-info" href="400C_mark.php" role="button"><b>400C info</b></a></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div>
        <div class="container my-5">
            <h2>insert student mark for thesis</h2>
            <br>

            <div>
                <?php
                if (!empty($errorMessage)) {
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                    echo "<strong>$errorMessage</strong>";
                    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '</div>';
                    echo '<script>';
                    echo 'setTimeout(function() {';
                    echo '    window.location.href = "grade_submit.php";';
                    echo '}, 2000);'; // Adjust the delay time as needed
                    echo '</script>';
                }
                ?>
            </div>

            <form method="POST">

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Student ID</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="student_id" id="student_id" value="<?php echo $student_id ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Mark</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="mark" id="mark" value="<?php echo $mark ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Course</label>
                    <div class="col-sm-6">
                        <select type="text" class="form-control" name="course" id="course" value="<?php echo $course ?> " required>
                            <option value="" disabled selected>Course</option>
                            <option value="400A">400A</option>
                            <option value="400B">400B</option>
                            <option value="400C">400C</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Semester</label>
                    <div class="col-sm-6">
                        <select type="text" class="form-control" name="semester" id="semester" value="<?php echo $semester ?> " required>
                            <option value="" disabled selected>Semester</option>
                            <option value="Spring">Spring</option>
                            <option value="Summer">Summer</option>
                            <option value="Fall">Fall</option>
                        </select>
                    </div>
                </div>

                <div>
                    <?php
                    if (!empty($successMessage)) {
                        echo '<div class="row mb-3">';
                        echo '<dic class="offset-sm-3 col-sm-6">';
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                        echo "<strong>$successMessage</strong>";
                        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '<script>';
                        echo 'setTimeout(function() {';
                        echo '    window.location.href = "grade_submit.php";';
                        echo '}, 2000);'; // Adjust the delay time as needed
                        echo '</script>';
                    }
                    ?>
                </div>

                <div class="row mb-3">

                    <div class="d-grid gap-2 col-6 mx-auto">
                        <button type="submit" class="btn btn-outline-primary">SUBMIT</button>
                    </div>

                </div>

            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
    </script>
</body>

</html>